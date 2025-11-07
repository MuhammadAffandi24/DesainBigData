<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gudang;

class GudangController extends Controller
{
    // GET /api/gudang
    public function index()
    {
        // kalau mau hanya gudang milik user token saat ini:
        // $data = Gudang::where('user_id', Auth::id())->get();
        $data = Gudang::all();

        return response()->json([
            'message' => 'Daftar Gudang',
            'data'    => $data
        ], 200);
    }

    // POST /api/gudang
    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:100|unique:gudang,nama_gudang',
            'lokasi'      => 'required|string|max:100',
            'status'      => 'required|string|max:50',
        ]);

        $userId = Auth::id(); // otomatis dari token Sanctum
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $gudang = Gudang::create([
            'user_id'     => $userId,
            'nama_gudang' => $request->nama_gudang,
            'lokasi'      => $request->lokasi,
            'status'      => $request->status,
            'joined_date' => now(),
        ]);

        return response()->json([
            'message' => 'Gudang berhasil ditambahkan',
            'data'    => $gudang
        ], 201);
    }

    // DELETE /api/gudang/{id}
    public function destroy($id)
    {
        $gudang = Gudang::find($id);
        if (!$gudang) {
            return response()->json(['message' => 'Gudang tidak ditemukan'], 404);
        }

        $gudang->delete();
        return response()->json(['message' => 'Gudang berhasil dihapus'], 200);
    }
}
