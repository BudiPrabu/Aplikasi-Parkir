<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            \App\Models\LogAktivitas::catat('login ke dalam sistem');
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->intended('/admin/dashboard');
            if ($role === 'petugas') return redirect()->intended('/petugas/dashboard');
            if ($role === 'owner') return redirect()->intended('/owner/dashboard');
        }

        return back()->with('loginError', 'Username atau password salah!');
    }

    public function logout(Request $request) {
        \App\Models\LogAktivitas::catat('Logout dari sistem'); 
        Auth::logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}