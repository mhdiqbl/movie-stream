<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('member.register');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->except('_token');

        $isEmailExist = User::where('email', $request->email)->exists();

        if ($isEmailExist){
            return back()
                ->withErrors([
                    'email' => 'Email already exist'
                ])
                ->withInput();
        }

        $data['roles'] = 'member';

        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('member-login');
    }
}
