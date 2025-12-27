<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Register (opsional, kalau perlu daftar via API)
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'Admin',
            'status'   => 'Aktif',
        ]);

        return response()->json(['message' => 'User registered', 'data' => $user], 201);
    }

    // Login → keluarkan token Sanctum + redirect sesuai alur
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // kalau salah → balik ke form login dengan error
            return redirect()->back()->with('error', 'Username atau password salah');
        }

        // login user ke session Laravel
        Auth::login($user);

        // generate token Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        // simpan token ke session supaya bisa diambil di Blade
        session(['auth_token' => $token]);

        // cek gudang (misalnya relasi warehouse)
        if (!$user->warehouse) {
            return redirect('/gudang/register');
        }

        // redirect sesuai role
        if ($user->role === 'Superadmin') {
            return redirect('/superadmin/home');
        } elseif ($user->role === 'Admin') {
            return redirect('/home');
        } else {
            return redirect('/user/home');
        }
    }

    // Logout → hapus token yang sedang dipakai
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        Auth::logout();
        return redirect('/login')->with('message', 'Logged out');
    }

    // (opsional) Lihat semua user
    public function index()
    {
        return response()->json(User::all());
    }

    // (opsional) Update role
    public function updateRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|in:Admin,Superadmin']);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role updated', 'data' => $user]);
    }
}
