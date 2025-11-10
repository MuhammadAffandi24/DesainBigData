<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gudang;
use Illuminate\Validation\Rule;

class GudangController extends Controller
{
    // 🔹 GET /api/gudang → tampilkan semua gudang milik user login
    public function index()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = Gudang::where('user_id', $userId)->get();

        return response()->json([
            'message' => 'Daftar Gudang milik user login',
            'data'    => $data
        ], 200);
    }

    // 🔹 GET /api/gudang/{id} → tampilkan detail gudang tertentu
    public function show($id)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $gudang = Gudang::where('user_id', $userId)->find($id);

        if (!$gudang) {
            return response()->json(['message' => 'Gudang tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail Gudang',
            'data'    => $gudang
        ], 200);
    }

    // 🔹 POST /api/gudang → tambah gudang baru
    public function store(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'nama_gudang' => [
                'required',
                'string',
                'max:100',
                Rule::unique('gudang', 'nama_gudang')->where(fn ($q) => $q->where('user_id', $userId))
            ],
            'lokasi' => 'required|string|max:100',
        ]);

        $gudang = Gudang::create([
            'user_id'     => $userId,
            'nama_gudang' => $request->nama_gudang,
            'lokasi'      => $request->lokasi,
            'status'      => 'Aktif', // otomatis aktif
            'joined_date' => now(),
        ]);

        return response()->json([
            'message' => 'Gudang berhasil ditambahkan',
            'data'    => $gudang
        ], 201);
    }

    // 🔹 DELETE /api/gudang/{id} → hapus gudang milik user login
    public function destroy($id)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $gudang = Gudang::where('user_id', $userId)->find($id);
        if (!$gudang) {
            return response()->json(['message' => 'Gudang tidak ditemukan'], 404);
        }

        $gudang->delete();
        return response()->json(['message' => 'Gudang berhasil dihapus'], 200);
    }
}
