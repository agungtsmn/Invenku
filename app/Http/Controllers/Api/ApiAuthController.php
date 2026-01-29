<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function loginProcess(Request $req)
    {   
        $validation = $req->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if(Auth::attempt($validation)) {
            $user = User::where('email', $req->email)->first();
            $token = $user->createToken('myAppToken')->plainTextToken;

            return response()->json([
                'message' => "Login successfully!",
                'data' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'message' => "Email atau password salah!",
            ]);
        }
    }
}
