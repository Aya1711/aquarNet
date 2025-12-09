<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\User;
use App\Models\Agence;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_properties' => Bien::count(),
            'pending_properties' => Bien::where('statut', 'en_attente')->count(),
            'active_properties' => Bien::where('statut', 'disponible')->count(),
            'total_users' => User::count(),
            'agencies_count' => Agence::count(),
            'messages_count' => Message::count(),
        ];

        $recentProperties = Bien::with(['user', 'agence'])
            ->latest()
            ->take(10)
            ->get();

        $pendingProperties = Bien::with(['user', 'agence'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProperties', 'pendingProperties'));
    }

    public function properties(Request $request)
    {
        $query = Bien::with(['user', 'agence', 'images']);

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('ville', 'like', '%' . $request->search . '%');
        }

        $properties = $query->latest()->paginate(20);

        return view('admin.properties', compact('properties'));
    }

    public function approveProperty($id)
    {
        $property = Bien::findOrFail($id);
        $property->update(['statut' => 'disponible']);

        return back()->with('success', 'تم الموافقة على العقار بنجاح.');
    }

    public function rejectProperty($id)
    {
        $property = Bien::findOrFail($id);
        $property->update(['statut' => 'rejete']);

        return back()->with('success', 'تم رفض العقار بنجاح.');
    }

    public function featureProperty($id)
    {
        $property = Bien::findOrFail($id);
        $property->update(['is_featured' => true]);

        return back()->with('success', 'تم تمييز العقار بنجاح.');
    }

    public function unfeatureProperty($id)
    {
        $property = Bien::findOrFail($id);
        $property->update(['is_featured' => false]);

        return back()->with('success', 'تم إلغاء تمييز العقار بنجاح.');
    }

    public function users(Request $request)
    {
        $query = User::withCount(['biens', 'messagesEnvoyes']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:admin,agence,particulier',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'تم تحديث صلاحية المستخدم بنجاح.');
    }

    public function agencies()
    {
        $agencies = Agence::with(['user', 'biens'])
            ->withCount(['biens as active_properties' => function($query) {
                $query->where('statut', 'disponible');
            }])
            ->latest()
            ->paginate(20);

        return view('admin.agencies', compact('agencies'));
    }

    public function reports()
    {
        // إحصائيات متقدمة
        $monthlyStats = Bien::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total,
            SUM(CASE WHEN statut = "disponible" THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN statut = "en_attente" THEN 1 ELSE 0 END) as pending
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->take(12)
        ->get();

        $topAgencies = Agence::withCount(['biens as properties_count'])
            ->orderBy('properties_count', 'desc')
            ->take(10)
            ->get();

        $topCities = Bien::selectRaw('ville, COUNT(*) as count')
            ->where('statut', 'disponible')
            ->groupBy('ville')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact('monthlyStats', 'topAgencies', 'topCities'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
}