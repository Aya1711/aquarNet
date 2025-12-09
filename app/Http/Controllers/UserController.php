<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Bien;
use App\Models\Favori;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $user = Auth::user();
        
        $userPropertiesCount = $user->biens()->count();
        $activePropertiesCount = $user->biens()->where('statut', 'disponible')->count();
        $pendingPropertiesCount = $user->biens()->where('statut', 'en_attente')->count();
        $favoritesCount = $user->favoris()->count();
        
        $recentProperties = $user->biens()
            ->with('images')
            ->latest()
            ->take(5)
            ->get();

        // الرسائل غير المقروءة
        $unreadMessagesCount = $user->messagesRecus()->where('lu', false)->count();

        return view('users.profile', compact(
            'user',
            'userPropertiesCount',
            'activePropertiesCount',
            'pendingPropertiesCount',
            'favoritesCount',
            'recentProperties',
            'unreadMessagesCount'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'telephone' => 'required|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ];

        // التحقق من كلمة المرور الحالية إذا كانت هناك محاولة لتغييرها
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.'])
                    ->withInput();
            }

            $userData['password'] = Hash::make($request->new_password);
        }

        $user->update($userData);

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }

    public function properties(Request $request)
    {
        $query = Auth::user()->biens()->with(['images', 'agence']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $properties = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Auth::user()->biens()->count(),
            'active' => Auth::user()->biens()->where('statut', 'disponible')->count(),
            'pending' => Auth::user()->biens()->where('statut', 'en_attente')->count(),
            'rejected' => Auth::user()->biens()->where('statut', 'rejete')->count(),
        ];

        return view('users.properties', compact('properties', 'stats'));
    }

    public function favorites()
    {
        $favorites = Auth::user()->favoris()
            ->with(['bien.images', 'bien.agence', 'bien.user'])
            ->whereHas('bien', function($query) {
                $query->whereIn('statut', ['disponible', 'approuve']);
            })
            ->latest()
            ->paginate(12);

        return view('users.favorites', compact('favorites'));
    }

    public function addToFavorites($id)
    {
        $property = Bien::where('statut', 'disponible')->findOrFail($id);

        // التحقق إذا كان العقار مضافاً مسبقاً
        $existingFavorite = Favori::where('user_id', Auth::id())
            ->where('bien_id', $id)
            ->first();

        if (!$existingFavorite) {
            Favori::create([
                'user_id' => Auth::id(),
                'bien_id' => $id,
            ]);

            return back()->with('success', 'تم إضافة العقار إلى المفضلة.');
        }

        return back()->with('info', 'العقار مضاف مسبقاً إلى المفضلة.');
    }

    public function removeFromFavorites($id)
    {
        $favorite = Favori::where('user_id', Auth::id())
            ->where('bien_id', $id)
            ->firstOrFail();

        $favorite->delete();

        return back()->with('success', 'تم إزالة العقار من المفضلة.');
    }

    public function messages()
    {
        $messages = Auth::user()->messagesRecus()
            ->with(['expediteur', 'bien.images'])
            ->latest()
            ->paginate(15);

        // تحديث الرسائل كمقروءة
        Auth::user()->messagesRecus()->where('lu', false)->update(['lu' => true]);

        return view('users.messages', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recepteur_id' => 'required|exists:users,id_user',
            'bien_id' => 'nullable|exists:biens,id_bien',
            'contenu' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Message::create([
            'expediteur_id' => Auth::id(),
            'recepteur_id' => $request->recepteur_id,
            'bien_id' => $request->bien_id,
            'contenu' => $request->contenu,
            'lu' => false,
        ]);

        return back()->with('success', 'تم إرسال الرسالة بنجاح.');
    }

    public function deleteMessage($id)
    {
        $message = Message::where('recepteur_id', Auth::id())
            ->findOrFail($id);

        $message->delete();

        return back()->with('success', 'تم حذف الرسالة بنجاح.');
    }
    public function editProfile()
{
    $user = Auth::user();
    return view('users.edit-profile', compact('user'));
}


    
}