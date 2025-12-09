<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // الإحصائيات
            $totalProperties = Bien::where('statut', 'disponible')->count();
            $agenciesCount = Agence::count();
            $citiesCount = Bien::where('statut', 'disponible')->distinct('ville')->count('ville');
            $usersCount = User::count();

            // أحدث العقارات
            $latestProperties = Bien::with(['images', 'agence', 'user'])
                ->where('statut', 'disponible')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            // الوكالات المميزة
            $featuredAgencies = Agence::withCount(['biens as active_properties' => function($query) {
                $query->where('statut', 'disponible');
            }])->take(4)->get();

            return view('home.index', compact(
                'totalProperties',
                'agenciesCount',
                'citiesCount',
                'usersCount',
                'latestProperties',
                'featuredAgencies'
            ));
        } catch (\Exception $e) {
            return view('home.index')->with('error', 'حدث خطأ في تحميل البيانات.');
        }
    }

    public function search(Request $request)
    {
        $query = Bien::with(['images', 'agence', 'user'])
            ->where('statut', 'disponible');

        // تطبيق الفلاتر
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
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

        // البحث النصي
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('ville', 'like', '%' . $request->search . '%')
                  ->orWhere('adresse', 'like', '%' . $request->search . '%');
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

        return view('home.search', compact('properties'));
    }


}