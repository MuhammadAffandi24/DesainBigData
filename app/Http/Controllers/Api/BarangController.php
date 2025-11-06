<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\DaftarBelanja;

class BarangController extends Controller
{
    // 🔹 GET: Semua Barang
    public function index()
    {
        $barang = Barang::with('gudang:nama_gudang,gudang_id')->get();

        return response()->json([
            'message' => 'Daftar Barang',
            'data' => $barang
        ], 200);
    }

    // 🔹 POST: Tambah Barang (berdasarkan nama gudang)
    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required|string|exists:gudang,nama_gudang',
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'jumlah_barang' => 'required|integer|min:0',
            'harga_barang' => 'required|numeric|min:0',
            'toko_pembelian' => 'required|string|max:100',
        ]);

        // cari gudang berdasarkan nama_gudang
        $gudang = Gudang::where('nama_gudang', $request->nama_gudang)->first();

        // buat barang baru
        $barang = Barang::create([
            'gudang_id' => $gudang->gudang_id,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'jumlah_barang' => $request->jumlah_barang,
            'harga_barang' => $request->harga_barang,
            'toko_pembelian' => $request->toko_pembelian,
        ]);

        // otomatis masuk ke daftar_belanja
        DaftarBelanja::create([
            'barang_id' => $barang->barang_id,
            'nama_barang' => $barang->nama_barang,
            'sisa_stok' => $barang->jumlah_barang,
            'toko_pembelian' => $barang->toko_pembelian
        ]);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang->load('gudang:nama_gudang,gudang_id')
        ], 201);
    }

    // 🔹 GET: Detail Barang
    public function show($id)
    {
        $barang = Barang::with('gudang:nama_gudang,gudang_id')->find($id);
        if (!$barang) return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        return response()->json(['data' => $barang], 200);
    }

    // 🔹 PUT: Update Barang
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        if (!$barang) return response()->json(['message' => 'Barang tidak ditemukan'], 404);

        $barang->update($request->all());

        return response()->json([
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang
        ], 200);
    }

    // 🔹 DELETE: Hapus Barang
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) return response()->json(['message' => 'Barang tidak ditemukan'], 404);

        // hapus juga dari daftar_belanja
        DaftarBelanja::where('barang_id', $id)->delete();

        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }
}
