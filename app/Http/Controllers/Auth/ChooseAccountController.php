<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ChooseAccountController extends Controller
{
    // دالة index لعرض صفحة اختيار الحساب
    public function index()
    {
        return view('auth.choose-account'); 
    }
}
