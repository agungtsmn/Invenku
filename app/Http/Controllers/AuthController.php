<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $req)
    {
        $validation = $req->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if(Auth::attempt($validation)) {
            $req->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return back()->with('error', 'Email atau password salah!');
        }
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect('/');
    }
}
