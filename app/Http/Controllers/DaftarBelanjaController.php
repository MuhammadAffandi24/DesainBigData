<?php

namespace App\Http\Controllers;

use App\Models\DaftarBelanja;
use Illuminate\Http\Request;

class DaftarBelanjaController extends Controller
{
    public function index()
    {
        return response()->json(DaftarBelanja::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'      => 'required',
            'nama_barang'    => 'required|string',
            'sisa_stok'      => 'required|integer|min:0',
            'toko_pembelian' => 'required|string',
        ]);

        DaftarBelanja::updateOrCreate(
            ['barang_id' => $request->barang_id],
            [
                'nama_barang'    => $request->nama_barang,
                'sisa_stok'      => $request->sisa_stok,
                'toko_pembelian' => $request->toko_pembelian,
            ]
        );

        return response()->json(['message' => 'Barang berhasil ditambahkan ke daftar belanja']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'    => 'required|string',
            'sisa_stok'      => 'required|integer|min:0',
            'toko_pembelian' => 'required|string',
        ]);

        // Ganti firstOrFail() dengan first() + pengecekan
        $belanja = DaftarBelanja::where('belanja_id', $id)->first();

        if (!$belanja) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $belanja->update([
            'nama_barang'    => $request->nama_barang,
            'sisa_stok'      => $request->sisa_stok,
            'toko_pembelian' => $request->toko_pembelian,
        ]);

        return response()->json(['message' => 'Daftar belanja berhasil diperbarui']);
    }


    public function destroy($id)
    {
        $belanja = DaftarBelanja::where('belanja_id', $id)->first();

        if (!$belanja) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $belanja->delete();

        return response()->json(['message' => 'Barang dihapus dari daftar belanja']);
    }
}
