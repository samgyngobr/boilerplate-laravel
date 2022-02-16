<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authentication extends Controller
{

    /**
     * Show authentication form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('admin/auth/login');
    }

    /**
     * logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/admin/login');
    }



    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate( Request $request )
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ( Auth::attempt( $credentials, $request->get('remember') ) )
        {
            $request->session()->regenerate();
            return redirect()->intended('admin');
        }

        return back()->with([ 'error' => 'The provided credentials do not match our records.' ]);
    }



    /**
     * Show "forgotPassword" form.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return view('admin/auth/forgot-password');
    }



}
