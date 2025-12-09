<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    /**
     * تخزين الرسالة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        try {

            \Log::info('store() function called', $request->all());

            // التحقق من صحة البيانات
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'ville' => 'required|string|max:255',
                'recepteur_id' => 'required|exists:users,id_user',
                'bien_id' => 'required|exists:biens,id_bien',
                'contenu' => 'required|string',
            ]);

            // إنشاء الرسالة
            $message = Message::create([
                'nom' => $validated['nom'],
                'telephone' => $validated['telephone'],
                'ville' => $validated['ville'],
                'recepteur_id' => $validated['recepteur_id'],
                'bien_id' => $validated['bien_id'],
                'contenu' => $validated['contenu'],
                'lu' => false,
            ]);

            // إذا كان الطلب AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال الرسالة بنجاح ✅',
                    'data' => $message
                ], 201);
            }

            // رسالة نجاح للطلبات العادية
            return back()->with('success', 'تم إرسال الرسالة بنجاح ✅');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // أخطاء التحقق
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هناك أخطاء في البيانات المدخلة',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error storing message: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إرسال الرسالة. حاول مرة أخرى.'
                ], 500);
            }

            return back()->with('error', 'حدث خطأ أثناء إرسال الرسالة ❌')->withInput();
        }
    }

    /**
     * عرض جميع الرسائل الخاصة بالمستخدم المسجل
     */
    public function index()
    {
        $user = auth()->user();

        $messages = Message::where('recepteur_id', $user->id_user)
            ->with(['bien']) // تحميل بيانات العقار
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.messages.index', compact('messages'));
    }

    /**
     * عرض رسالة مفردة
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // التحقق من أن المستخدم هو المستقبل
        if ($message->recepteur_id !== auth()->user()->id_user) {
            abort(403);
        }

        // تحديث حالة الرسالة إلى مقروءة
        if (!$message->lu) {
            $message->update(['lu' => true]);
        }

        return view('users.messages.show', compact('message'));
    }

    /**
     * تحديث حالة الرسالة إلى مقروءة
     */
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);

        // التحقق من أن المستخدم هو المستقبل
        if ($message->recepteur_id !== auth()->user()->id_user) {
            abort(403);
        }

        $message->update(['lu' => true]);

        return response()->json(['success' => true]);
    }
}