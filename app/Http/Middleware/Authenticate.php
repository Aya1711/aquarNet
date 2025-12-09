<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // إذا لم يكن المستخدم مسجلاً الدخول
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'يرجى تسجيل الدخول أولاً.');
        }

        return $next($request);
    }
}
