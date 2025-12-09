<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Agence;
use App\Models\Image;
use App\Models\Message;
use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Bien::with(['images', 'agence', 'user'])
            ->where('statut', 'disponible');

        // الفلاتر
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('ville')) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        if ($request->filled('surface_min')) {
            $query->where('surface', '>=', $request->surface_min);
        }

        if ($request->filled('agence')) {
            $query->where('agence_id', $request->agence);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('ville', 'like', '%' . $request->search . '%');
            });
        }

        // الترتيب
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_high':
                $query->orderBy('prix', 'desc');
                break;
            case 'surface_high':
                $query->orderBy('surface', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $properties = $query->paginate(12)->withQueryString();
        $agencies = Agence::all();

        return view('properties.index', compact('properties', 'agencies'));
    }

    public function show($id)
    {
        $property = Bien::with(['images', 'agence', 'user', 'agence.user'])
            ->where('id_bien', $id)
            ->firstOrFail();

        // التحقق من حالة العقار
        if ($property->statut === 'disponible' || $property->statut === 'approuve') {
            // العقار متاح للعرض العام
        } elseif (Auth::check() && $property->user_id === Auth::id()) {
            // المالك يحاول عرض عقاره الخاص
            if (!$property->isPaid()) {
                // العقار غير مدفوع، إعادة توجيه إلى الدفع
                return redirect()->route('payment.packages', $property->id_bien)
                    ->with('warning', 'يجب دفع رسوم النشر قبل عرض العقار.');
            }
        } else {
            // العقار غير متاح للعرض
            abort(404, 'العقار غير متاح حالياً.');
        }

        // زيادة عدد المشاهدات (يمكن إضافة حقل views في الجدول لاحقاً)
        // $property->increment('views');

        // عقارات مشابهة
        $similarProperties = Bien::with(['images'])
            ->where('type', $property->type)
            ->where('categorie', $property->categorie)
            ->where('ville', $property->ville)
            ->where('id_bien', '!=', $id)
            ->where('statut', 'disponible')
            ->take(4)
            ->get();

        // التحقق إذا كان العقار في المفضلة للمستخدم الحالي
        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Favori::where('user_id', Auth::id())
                ->where('bien_id', $id)
                ->exists();
        }

        return view('properties.show', compact('property', 'similarProperties', 'isFavorite'));
    }

    public function create()
    {
        $agences = Agence::all();
        return view('properties.create', compact('agences'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'type' => 'required|in:appartement,maison,villa,terrain,local,bureau,ferme',
            'categorie' => 'required|in:vente,location',
            'prix' => 'required|numeric|min:0',
            'surface' => 'required|numeric|min:0',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string',
            'chambres' => 'nullable|integer|min:0',
            'salles_bain' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'agence_id' => 'nullable|exists:agences,id_agence',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // إنشاء العقار
        $bien = Bien::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'categorie' => $request->categorie,
            'prix' => $request->prix,
            'surface' => $request->surface,
            'ville' => $request->ville,
            'adresse' => $request->adresse,
            'chambres' => $request->chambres,
            'salles_bain' => $request->salles_bain,
            'features' => $request->features ? json_encode($request->features) : null,
            'statut' => Auth::user()->isAdmin() ? 'disponible' : 'en_attente',
            'user_id' => Auth::id(),
            'agence_id' => $request->agence_id,
        ]);

        // رفع الصور
        if ($request->hasFile(key: 'images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('properties', 'public');
                
                Image::create([
                    'url_image' => $path,
                    'bien_id' => $bien->id_bien,
                    'ordre' => $key,
                ]);
            }
        }

        if (Auth::user()->isAdmin()) {
            $message = 'تم إضافة العقار بنجاح.';
            return redirect()->route('properties.show', $bien->id_bien)
                ->with('success', $message);
        } else {
            // إعادة توجيه المستخدمين والوكالات إلى صفحة اختيار باقات الدفع
            return redirect()->route('payment.packages', $bien->id_bien)
                ->with('success', 'تم إضافة العقار بنجاح. يرجى اختيار باقة النشر وإتمام عملية الدفع.');
        }

          //return redirect()->route('properties.show', $bien->id_bien);

    }

    public function edit($id)
    {
        $property = Bien::with('images')->findOrFail($id);
        
        // التحقق من الملكية
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح بتعديل هذا العقار.');
        }

        $agences = Agence::all();
        return view('properties.edit', compact('property', 'agences'));
    }

    public function update(Request $request, $id)
    {
        $property = Bien::findOrFail($id);
        
        // التحقق من الملكية
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح بتعديل هذا العقار.');
        }

        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'type' => 'required|in:appartement,maison,villa,terrain,local,bureau,ferme',
            'categorie' => 'required|in:vente,location',
            'prix' => 'required|numeric|min:0',
            'surface' => 'required|numeric|min:0',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string',
            'chambres' => 'nullable|integer|min:0',
            'salles_bain' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'agence_id' => 'nullable|exists:agences,id_agence',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $property->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'categorie' => $request->categorie,
            'prix' => $request->prix,
            'surface' => $request->surface,
            'ville' => $request->ville,
            'adresse' => $request->adresse,
            'chambres' => $request->chambres,
            'salles_bain' => $request->salles_bain,
            'features' => $request->features ? json_encode($request->features) : null,
            'agence_id' => $request->agence_id,
            'statut' => Auth::user()->isAdmin() ? 'disponible' : 'en_attente',
        ]);

        // إضافة صور جديدة
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $path = $image->store('properties', 'public');
                
                Image::create([
                    'url_image' => $path,
                    'bien_id' => $property->id_bien,
                    'ordre' => $property->images()->count() + $key,
                ]);
            }
        }

        return redirect()->route('properties.show', $property->id_bien)
            ->with('success', 'تم تحديث العقار بنجاح.');
    }

    public function destroy($id)
    {
        $property = Bien::findOrFail($id);
        
        // التحقق من الملكية
        if ($property->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح بحذف هذا العقار.');
        }

        // حذف الصور من التخزين
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->url_image);
            $image->delete();
        }

        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'تم حذف العقار بنجاح.');
    }

    public function contact(Request $request, $id)
    {
        $property = Bien::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // إنشاء رسالة
        Message::create([
            'expediteur_id' => Auth::id(),
            'recepteur_id' => $property->user_id,
            'bien_id' => $property->id_bien,
            'contenu' => "اسم: {$request->name}\nبريد: {$request->email}\nهاتف: {$request->phone}\n\nرسالة: {$request->message}",
            'lu' => false,
        ]);

        return back()->with('success', 'تم إرسال رسالتك بنجاح.');
    }

    public function toggleFavorite($id)
    {
        try {
            $property = Bien::findOrFail($id);

            // Check if property is available
            if (!in_array($property->statut, ['disponible', 'approuve'])) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لا يمكن إضافة هذا العقار إلى المفضلة.'
                    ], 400);
                }
                return back()->with('error', 'لا يمكن إضافة هذا العقار إلى المفضلة.');
            }

            $existingFavorite = Favori::where('user_id', Auth::id())
                ->where('bien_id', $id)
                ->first();

            if ($existingFavorite) {
                $existingFavorite->delete();
                $message = 'تم إزالة العقار من المفضلة.';
                $isFavorite = false;
            } else {
                Favori::create([
                    'user_id' => Auth::id(),
                    'bien_id' => $id,
                ]);
                $message = 'تم إضافة العقار إلى المفضلة.';
                $isFavorite = true;
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'is_favorite' => $isFavorite
                ]);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Favorite toggle error: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء تحديث المفضلة.'
                ], 500);
            }

            return back()->with('error', 'حدث خطأ أثناء تحديث المفضلة.');
        }
    }
}