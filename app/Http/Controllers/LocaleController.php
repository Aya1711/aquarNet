<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        // Validate the locale
        if (!in_array($locale, ['en', 'ar', 'fr'])) {
            abort(404);
        }

        // Set the locale in session
        Session::put('locale', $locale);

        // Set the locale in cookie for persistence
        Cookie::queue('locale', $locale, 60 * 24 * 365); // 1 year

        // Force save the session
        Session::save();

        // Set the application locale
        App::setLocale($locale);

        // Redirect back to the previous page
        return redirect()->back();
    }
}
