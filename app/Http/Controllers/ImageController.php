<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * حذف صورة
     */
    public function destroy($id)
    {
        $image = Image::with('bien')->findOrFail($id);
        
        // التحقق من الملكية
        if (!$this->checkImageOwnership($image)) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بحذف هذه الصورة.'
            ], 403);
        }

        try {
            $this->deleteImageFile($image);
            $image->delete();

            // إذا كانت الصورة المحذوفة هي الرئيسية، تعيين صورة أخرى كرئيسية
            if ($image->is_main) {
                $this->setNewMainImage($image->bien_id);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصورة بنجاح.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting image: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الصورة.'
            ], 500);
        }
    }

    /**
     * تعيين صورة كرئيسية
     */
    public function setAsMain($id)
    {
        $image = Image::with('bien')->findOrFail($id);
        
        if (!$this->checkImageOwnership($image)) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بتعديل هذه الصورة.'
            ], 403);
        }

        try {
            // إلغاء تعيين جميع الصور الأخرى كرئيسية
            Image::where('bien_id', $image->bien_id)
                 ->where('id', '!=', $id)
                 ->update(['is_main' => false]);

            // تعيين الصورة المحددة كرئيسية
            $image->update(['is_main' => true]);

            return response()->json([
                'success' => true,
                'message' => 'تم تعيين الصورة كرئيسية بنجاح.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error setting main image: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تعيين الصورة كرئيسية.'
            ], 500);
        }
    }

    /**
     * رفع صور جديدة لعقار موجود
     */
    public function store(Request $request, $bienId)
    {
        $bien = Bien::findOrFail($bienId);
        
        // التحقق من الملكية
        if ($bien->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بإضافة صور لهذا العقار.'
            ], 403);
        }

        $request->validate([
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB
        ]);

        try {
            $uploadedImages = [];
            
            foreach ($request->file('images') as $image) {
                $uploadedImage = $this->storeImage($image, $bienId);
                $uploadedImages[] = $uploadedImage;
            }

            // إذا لم يكن هناك صور رئيسية، تعيين الأولى كرئيسية
            if (!Image::where('bien_id', $bienId)->where('is_main', true)->exists() && count($uploadedImages) > 0) {
                Image::where('id', $uploadedImages[0]->id)->update(['is_main' => true]);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم رفع الصور بنجاح.',
                'images' => $uploadedImages
            ]);

        } catch (\Exception $e) {
            \Log::error('Error uploading images: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء رفع الصور.'
            ], 500);
        }
    }

    /**
     * إعادة ترتيب الصور
     */
    public function reorder(Request $request, $bienId)
    {
        $bien = Bien::findOrFail($bienId);
        
        if (!$this->checkBienOwnership($bien)) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بتعديل ترتيب الصور.'
            ], 403);
        }

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:images,id'
        ]);

        try {
            foreach ($request->order as $position => $imageId) {
                Image::where('id', $imageId)
                     ->where('bien_id', $bienId)
                     ->update(['order' => $position]);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم إعادة ترتيب الصور بنجاح.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error reordering images: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إعادة ترتيب الصور.'
            ], 500);
        }
    }

    /**
     * الحصول على صور العقار
     */
    public function getBienImages($bienId)
    {
        $bien = Bien::findOrFail($bienId);
        
        $images = Image::where('bien_id', $bienId)
                      ->orderBy('is_main', 'desc')
                      ->orderBy('order')
                      ->get();

        return response()->json([
            'success' => true,
            'images' => $images
        ]);
    }

    // ========== الدوال المساعدة ==========

    /**
     * التحقق من ملكية الصورة
     */
    private function checkImageOwnership($image)
    {
        return $image->bien->user_id === Auth::id() || Auth::user()->isAdmin();
    }

    /**
     * التحقق من ملكية العقار
     */
    private function checkBienOwnership($bien)
    {
        return $bien->user_id === Auth::id() || Auth::user()->isAdmin();
    }

    /**
     * حفظ الصورة
     */
    private function storeImage($image, $bienId)
    {
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();

        // إنشاء اسم فريد للصورة
        $imageName = 'bien_' . $bienId . '_' . time() . '_' . uniqid() . '.' . $extension;
        $directory = 'properties/' . $bienId;

        // إنشاء الدليل إذا لم يكن موجوداً
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // حفظ الصورة
        $imagePath = $image->storeAs($directory, $imageName, 'public');

        // حفظ معلومات الصورة في قاعدة البيانات
        return Image::create([
            'bien_id' => $bienId,
            'url_image' => $imagePath,
            'image_name' => $originalName,
            'is_main' => false,
            'order' => Image::where('bien_id', $bienId)->count()
        ]);
    }

    /**
     * حذف ملف الصورة
     */
    private function deleteImageFile($image)
    {
        $imagePath = $image->url_image;
        
        // حذف الصورة من التخزين
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * تعيين صورة جديدة كرئيسية
     */
    private function setNewMainImage($bienId)
    {
        $newMainImage = Image::where('bien_id', $bienId)->first();
        if ($newMainImage) {
            $newMainImage->update(['is_main' => true]);
        }
    }

    /**
     * تنظيف الصور المؤقتة - نسخة مبسطة بدون thumbs
     */
    public function cleanupOrphanedImages()
    {
        try {
            $allImages = Storage::disk('public')->allFiles('properties');
            $dbImages = Image::pluck('url_image')->toArray();

            $orphanedImages = array_diff($allImages, $dbImages);
            $deletedCount = 0;

            foreach ($orphanedImages as $image) {
                Storage::disk('public')->delete($image);
                $deletedCount++;
            }

            return $deletedCount;

        } catch (\Exception $e) {
            \Log::error('Error cleaning orphaned images: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * تحسين جودة الصورة (اختياري)
     */
    public function optimizeImage($imageId)
    {
        $image = Image::findOrFail($imageId);
        
        if (!$this->checkImageOwnership($image)) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بتحسين هذه الصورة.'
            ], 403);
        }

        try {
            $imagePath = Storage::disk('public')->path($image->url_image);
            
            // استخدام Intervention Image لتحسين الجودة (إذا كان مثبتاً)
            if (class_exists('Intervention\Image\Facades\Image')) {
                $optimizedImage = \Intervention\Image\Facades\Image::make($imagePath)
                    ->encode('jpg', 80) // ضغط الجودة إلى 80%
                    ->save($imagePath);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تحسين الصورة بنجاح.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error optimizing image: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحسين الصورة.'
            ], 500);
        }
    }
}