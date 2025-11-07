<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gudang;
use Illuminate\Validation\Rule;

class GudangController extends Controller
{
    // GET /api/gudang
    public function index()
    {
        // hanya tampilkan gudang milik user login
        $data = Gudang::where('user_id', Auth::id())->get();

        return response()->json([
            'message' => 'Daftar Gudang',
            'data'    => $data
        ], 200);
    }

    // POST /api/gudang
    public function store(Request $request)
    {
        $userId = Auth::id(); // otomatis dari token Sanctum
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validasi: nama_gudang hanya unik dalam scope user_id
        $request->validate([
            'nama_gudang' => [
                'required',
                'string',
                'max:100',
                Rule::unique('gudang', 'nama_gudang')->where(fn ($q) => $q->where('user_id', $userId))
            ],
            'lokasi' => 'required|string|max:100',
            'status' => 'required|string|max:50',
        ]);

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
        $gudang = Gudang::where('user_id', Auth::id())->find($id);
        if (!$gudang) {
            return response()->json(['message' => 'Gudang tidak ditemukan'], 404);
        }

        $gudang->delete();
        return response()->json(['message' => 'Gudang berhasil dihapus'], 200);
    }
}
