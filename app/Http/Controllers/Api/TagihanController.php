<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Tagihan;
use App\Models\RiwayatPembayaran;

class TagihanController extends Controller
{
    // 🔹 GET: Semua tagihan milik user login
    public function index()
    {
        $userId = Auth::id();

        $data = Tagihan::where('user_id', $userId)
            ->select('tagihan_id', 'nama_tagihan', 'kategori', 'nominal', 'jatuh_tempo', 'status_pembayaran')
            ->orderBy('jatuh_tempo', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar tagihan milik user login berhasil diambil',
            'data' => $data
        ]);
    }

    // 🔹 GET: Detail tagihan tertentu milik user login
    public function show($id)
    {
        $userId = Auth::id();
        $tagihan = Tagihan::where('tagihan_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail tagihan berhasil diambil',
            'data' => $tagihan
        ]);
    }

    // 🔹 POST: Tambah tagihan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_tagihan' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'nominal' => 'required|numeric|min:0',
            'jatuh_tempo' => 'required|date'
        ]);

        // Nonaktifkan timestamps otomatis kalau tabel tidak punya kolom created_at/updated_at
        $tagihan = new Tagihan();
        $tagihan->timestamps = false;

        $tagihan->user_id = Auth::id();
        $tagihan->nama_tagihan = $request->nama_tagihan;
        $tagihan->kategori = $request->kategori;
        $tagihan->nominal = $request->nominal;
        $tagihan->jatuh_tempo = $request->jatuh_tempo;
        $tagihan->status_pembayaran = 'Belum Lunas';
        $tagihan->save();

        return response()->json([
            'success' => true,
            'message' => 'Tagihan berhasil ditambahkan',
            'data' => $tagihan
        ], 201);
    }

    // 🔹 PUT: Update tagihan (status, nominal, tanggal pembayaran, dll)
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $tagihan = Tagihan::where('tagihan_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $request->validate([
            'nama_tagihan' => 'sometimes|string|max:100',
            'kategori' => 'sometimes|string|max:50',
            'nominal' => 'sometimes|numeric|min:0',
            'jatuh_tempo' => 'sometimes|date',
            'status_pembayaran' => 'sometimes|in:Lunas,Belum Lunas,Belum Dibayar, Terlambat',
            'tanggal_pembayaran' => 'nullable|date'
        ]);

        $tagihan->timestamps = false;
        $tagihan->update($request->only([
            'nama_tagihan', 'kategori', 'nominal', 'jatuh_tempo', 'status_pembayaran'
        ]));

        // 🔹 Jika status berubah jadi 'lunas', buat riwayat pembayaran
        if ($request->has('status_pembayaran') && $request->status_pembayaran === 'Lunas') {
            RiwayatPembayaran::create([
                'tagihan_id' => $tagihan->tagihan_id,
                'user_id' => $userId,
                'nama_tagihan' => $tagihan->nama_tagihan,
                'kategori' => $tagihan->kategori,
                'jumlah_dibayar' => $tagihan->nominal,
                'tanggal' => $request->tanggal_pembayaran
                    ? Carbon::parse($request->tanggal_pembayaran)->toDateString()
                    : Carbon::now()->toDateString(),
                'status' => 'lunas'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tagihan berhasil diperbarui',
            'data' => $tagihan
        ]);
    }

    // 🔹 DELETE: Hapus tagihan dan riwayat pembayarannya
    public function destroy($id)
    {
        $userId = Auth::id();
        $tagihan = Tagihan::where('tagihan_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        RiwayatPembayaran::where('tagihan_id', $tagihan->tagihan_id)->delete();
        $tagihan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tagihan dan riwayat pembayarannya berhasil dihapus'
        ]);
    }
}
