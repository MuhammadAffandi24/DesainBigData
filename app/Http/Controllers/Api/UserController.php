<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UserController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Admin', // default
            'status' => 'Aktif',
        ]);

        return response()->json(['message' => 'User registered', 'data' => $user], 201);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

    // Kalau user gak ditemukan
    if (!$user) {
        return response()->json([
            'message' => 'Username tidak ditemukan'
        ], 404);
    }

    // 🔹 Kalau password salah
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Password salah'
        ], 401);
    }

    // 🔹 Buat token Sanctum
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => [
            'user_id' => $user->user_id,
            'username' => $user->username,
            'role' => $user->role,
            'status' => $user->status,
        ]
    ], 200);
}


    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    // Update Role (Admin → Superadmin)
    public function updateRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|in:Admin,Superadmin']);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role updated', 'data' => $user]);
    }

    // View All Users
    public function index()
    {
        return response()->json(User::all());
    }
}
