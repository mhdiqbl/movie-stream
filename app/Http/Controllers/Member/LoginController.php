<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('member.auth');
    }

    public function auth(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['roles'] = 'member';

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->route('member-dashboard');
        }
        return back()->withErrors([
            'credentials' => 'Your credential is invalid'
        ])->withInput();
    }

    public function logout()
    {

    }
}
