<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['roles'] = 'admin';

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->route('admin-movie');
        }

        return back()->withErrors([
            'error' => 'Your credential is invalid'
        ])->withInput();
    }
}
