<?php


namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Bien;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Agence::withCount([
            'biens as total_properties',
            'biens as active_properties' => function($query) {
                $query->where('statut', 'disponible');
            }
        ]);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom_agence', 'like', '%' . $request->search . '%')
                  ->orWhere('ville', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('ville')) {
            $query->where('ville', 'like', '%' . $request->ville . '%');
        }

        $agencies = $query->orderBy('nom_agence')->paginate(12)->withQueryString();

        return view('agencies.index', compact('agencies'));
    }

    public function show($id)
    {
        $agency = Agence::with(['user', 'biens' => function($query) {
            $query->where('statut', 'disponible')->with('images');
        }])->findOrFail($id);

        return view('agencies.show', compact('agency'));
    }

   


    public function dashboard()
    {
        $agency = Auth::user()->agence;
        
        if (!$agency) {
            abort(404, 'الوكالة غير موجودة.');
        }

        $properties = $agency->biens()
            ->with('images')
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => $agency->biens()->count(),
            'active' => $agency->biens()->where('statut', 'disponible')->count(),
            'pending' => $agency->biens()->where('statut', 'en_attente')->count(),
            'sold' => $agency->biens()->whereIn('statut', ['vendu', 'loue'])->count(),
        ];

        // الرسائل الحديثة
        $recentMessages = Message::where('recepteur_id', Auth::id())
            ->with(['expediteur', 'bien'])
            ->latest()
            ->take(5)
            ->get();

        return view('agencies.dashboard', compact('agency', 'properties', 'stats', 'recentMessages'));
    }

    public function contact(Request $request, $id)
    {
        $agency = Agence::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // إنشاء رسالة للوكالة
        Message::create([
            'expediteur_id' => Auth::id(),
            'recepteur_id' => $agency->user_id,
            'bien_id' => null,
            'contenu' => "موضوع: {$request->subject}\n: {$request->name}\nبريد: {$request->email}\n: {$request->phone}\n\n: {$request->message}",
            'lu' => false,
        ]);

        return back()->with('success', 'تم إرسال رسالتك إلى الوكالة بنجاح.');
    }

    public function updateProfile(Request $request)
    {
        $agency = Auth::user()->agence;
        
        if (!$agency) {
            abort(404, 'الوكالة غير موجودة.');
        }

        $validator = Validator::make($request->all(), [
            'nom_agence' => 'required|string|max:255',
            'adresse' => 'required|string',
            'ville' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // تحديث بيانات المستخدم
        Auth::user()->update([
            'name' => $request->nom_agence,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        // تحديث بيانات الوكالة
        $agencyData = [
            'nom_agence' => $request->nom_agence,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'description' => $request->description,
        ];

        if ($request->hasFile('logo')) {
            // حذف الشعار القديم إذا موجود
            if ($agency->logo) {
                Storage::disk('public')->delete($agency->logo);
            }
            $agencyData['logo'] = $request->file('logo')->store('agencies', 'public');
        }

        $agency->update($agencyData);

        return back()->with('success', 'تم تحديث بيانات الوكالة بنجاح.');
    }
}