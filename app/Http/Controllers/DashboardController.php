<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * توجيه المستخدم إلى اللوحة المناسبة حسب صلاحيته
     */
    public function index()
    {
        $user = Auth::user();
        
        // 🔥 منع المسؤول من الدخول كـ user عادي
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        // 🔥 توجيه الوكالات إلى لوحة الوكالة
        if ($user->isAgency()) {
            // التأكد من أن المستخدم لديه وكالة مسجلة
            if ($user->agence) {
                return redirect()->route('agency.dashboard');
            } else {
                // إذا كان المستخدم من نوع وكالة ولكن ليس لديه وكالة مسجلة
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'حساب الوكالة غير مكتمل. يرجى التواصل مع الإدارة.');
            }
        }
        
        // 🔥 توجيه العملاء إلى لوحة العميل
        if ($user->isClient()) {
            return redirect()->route('client.dashboard');
        }

        // 🔥 إذا لم يكن هناك صلاحية محددة
        Auth::logout();
        return redirect()->route('login')
            ->with('error', 'نوع المستخدم غير معروف. يرجى التواصل مع الإدارة.');
    }

    /**
     * لوحة تحكم المسؤول
     */
    public function adminDashboard()
    {
        // 🔥 التحقق من أن المستخدم مسؤول
        if (!Auth::user()->isAdmin()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة التحكم الإدارية.');
        }

        return view('admin.dashboard');
    }

    /**
     * لوحة تحكم الوكالة
     */
    public function agencyDashboard()
    {
        // 🔥 منع المسؤول من الدخول كـ وكالة
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'المسؤول لا يمكنه الدخول كـ وكالة.');
        }

        // 🔥 التحقق من أن المستخدم وكالة وله وكالة مسجلة
        if (!Auth::user()->isAgency() || !Auth::user()->agence) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة التحكم الخاصة بالوكالات.');
        }

        return view('agency.dashboard');
    }

    /**
     * لوحة تحكم العميل
     */
    public function clientDashboard()
    {
        // 🔥 منع المسؤول من الدخول كـ عميل
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'المسؤول لا يمكنه الدخول كـ عميل.');
        }

        // 🔥 التحقق من أن المستخدم عميل
        if (!Auth::user()->isClient()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة التحكم الخاصة بالعملاء.');
        }

        return view('client.dashboard');
    }

    /**
     * إعادة توجيه عام للوحة التحكم المناسبة
     */
    public function redirectToDashboard()
    {
        return $this->index();
    }
}