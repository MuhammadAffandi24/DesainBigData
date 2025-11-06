<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang;

class GudangController extends Controller
{
    // 🔹 Lihat semua gudang
    public function index()
    {
        $data = Gudang::all();
        return response()->json(['message' => 'Daftar Gudang', 'data' => $data], 200);
    }

    // 🔹 Tambah gudang baru
    public function store(Request $request)
    {
        $request->validate([
    'user_id' => 'required|exists:users,user_id',
    'nama_gudang' => 'required|string|max:100|unique:gudang,nama_gudang',
    'lokasi' => 'required|string|max:100',
    'status' => 'required|string|max:50',
]);

        $gudang = Gudang::create([
            'user_id' => $request->user_id ?? null,
            'nama_gudang' => $request->nama_gudang,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'joined_date' => now()
        ]);

        return response()->json(['message' => 'Gudang berhasil ditambahkan', 'data' => $gudang], 201);
    }

    // 🔹 Hapus gudang
    public function destroy($id)
    {
        $gudang = Gudang::find($id);
        if (!$gudang) return response()->json(['message' => 'Gudang tidak ditemukan'], 404);
        $gudang->delete();

        return response()->json(['message' => 'Gudang berhasil dihapus']);
    }
}
