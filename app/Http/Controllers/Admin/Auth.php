<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Auth extends Controller
{

    public function login()
    {
        return view('admin/auth/login');
    }

    public function forgotPassword()
    {
        return view('admin/auth/forgot-password');
    }

}
