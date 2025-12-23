<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gudang;
use Illuminate\Validation\Rule;

class GudangController extends Controller
{
    /**
     * POST /gudang/register (WEB) atau /api/gudang (API)
     */
    public function store(Request $request)
    {
        $userId = Auth::id(); // pasti ada karena route pakai auth middleware

        $request->validate([
            'nama_gudang' => [
                'required',
                'string',
                'max:100',
                Rule::unique('gudang', 'nama_gudang')
                    ->where(fn ($q) => $q->where('user_id', $userId))
            ],
            'lokasi' => 'required|string|max:100',
        ]);

        $gudang = Gudang::create([
            'user_id'     => $userId,
            'nama_gudang' => $request->nama_gudang,
            'lokasi'      => $request->lokasi,
            'status'      => 'Aktif',
            'joined_date' => now(),
        ]);

        /* ===============================
           RESPONSE SMART (API vs WEB)
        =============================== */

        // 👉 Kalau request dari API (Accept: application/json)
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Gudang berhasil ditambahkan',
                'data'    => $gudang
            ], 201);
        }

        // 👉 Kalau dari web (blade)
        return redirect()
            ->route('home')
            ->with('success', 'Gudang berhasil didaftarkan');
    }
}
