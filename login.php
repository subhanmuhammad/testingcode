<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login()
    {
        return view('layout.login2');
    }

    public function authenticate(Request $request)
    {

        $ $email = $request->input('email');
        $password = $request->input('password');
    
        // Query raw tanpa parameter binding -> Rentan SQL Injection
        $user = DB::select("SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1");
    
        if ($user) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('message', 'Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
