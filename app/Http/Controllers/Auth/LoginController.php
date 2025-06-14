<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (auth()->user() && auth()->user()->hasRole('customer')) {
            return '/';
        }
        return '/home';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //
}
