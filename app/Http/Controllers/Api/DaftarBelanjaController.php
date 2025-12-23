<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarBelanja;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarBelanjaController extends Controller
{
    // Menampilkan daftar belanja user login (barang dari gudang miliknya)
    public function index()
    {
        $userId = Auth::id();

            $data = DaftarBelanja::join('barang', 'daftar_belanja.barang_id', '=', 'barang.barang_id')
            ->join('gudang', 'barang.gudang_id', '=', 'gudang.gudang_id')
            ->where('gudang.user_id', $userId)
            ->select(
                'daftar_belanja.*',
                'barang.nama_barang',
                'gudang.nama_gudang'
            )
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar belanja milik user login berhasil diambil',
            'data' => $data
        ]);
    }

    // Tambah barang ke daftar belanja berdasarkan nama_barang
    public function addToCart(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            // Cari barang berdasarkan nama + gudang milik user login
            $barang = Barang::join('gudang', 'barang.gudang_id', '=', 'gudang.gudang_id')
                ->where('barang.nama_barang', $request->nama_barang)
                ->where('gudang.user_id', Auth::id())
                ->select('barang.*')
                ->first();

            if (!$barang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang tidak ditemukan atau bukan milik gudang Anda'
                ], 404);
            }

        
            $item = DaftarBelanja::updateOrCreate(
                [
                    'barang_id' => $barang->barang_id,
                    'nama_barang' => $barang->nama_barang
                ],
                [
                    'sisa_stok' => $barang->jumlah_barang,
                    'toko_pembelian' => $barang->toko_pembelian,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan ke daftar belanja',
                'data' => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan barang ke daftar belanja',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
