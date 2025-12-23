<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    // Login → keluarkan token Sanctum
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Username atau password salah'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => [
                // sesuaikan dengan PK kamu: 'id' atau 'user_id'
                'user_id' => $user->user_id ?? $user->id,
                'username'=> $user->username,
                'role'    => $user->role,
                'status'  => $user->status,
            ]
        ], 200);
    }

    // Logout → hapus token yang sedang dipakai
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
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
