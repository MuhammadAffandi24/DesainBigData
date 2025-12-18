<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.loginadmin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return back()->with('error', 'Username atau password salah');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        // 🔐 cek role
        if ($user->role === 'Superadmin') {
            return redirect('/superadmin/home');
        }

        if ($user->role === 'Admin') {
            return redirect('/home');
        }

        Auth::logout();
        return back()->with('error', 'Role tidak diizinkan');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
