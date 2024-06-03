<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $title = "Login";

        return view('login', compact('title'));
    }

    public function auth(Request $request)
    {
        try {
            $credentials = $request->validate([
                "username" => 'required',
                "password" => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended("/");
            }

            throw new \Exception("Username atau password salah");

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
