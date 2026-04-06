<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated($request, $user)
    {
        // ADMIN → dashboard
        if ($user->role == 'admin') {
            return redirect('/dashboard');
        }

        // VENDOR → vendor page
        if (auth()->user()->role == 'vendor') {
            return redirect('/vendor/dashboard');
        }

        // default (kalau ada role lain)
        return redirect('/dashboard');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}