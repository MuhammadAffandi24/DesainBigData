<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarBelanja;
use App\Models\Barang;
use Illuminate\Http\Request;

class DaftarBelanjaController extends Controller
{
    public function index()
    {
        $data = DaftarBelanja::with(['barang.gudang'])->get()->map(function ($item) {
            return [
                'belanja_id'     => $item->belanja_id,
                'barang_id'      => $item->barang_id,
                'nama_barang'    => $item->barang->nama_barang ?? $item->nama_barang,
                'sisa_stok'      => $item->sisa_stok,
                'toko_pembelian' => $item->toko_pembelian,
                'nama_gudang'    => $item->barang->gudang->nama_gudang ?? null,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'nama_barang'    => 'required|string',
            'sisa_stok'      => 'required|integer|min:0',
            'toko_pembelian' => 'required|string',
        ]);

        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $item = DaftarBelanja::updateOrCreate(
            ['barang_id' => $barang->barang_id],
            [
                'nama_barang'    => $barang->nama_barang,
                'sisa_stok'      => $request->sisa_stok,
                'toko_pembelian' => $request->toko_pembelian
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan / diperbarui ke daftar belanja',
            'data'    => $item
        ]);
    }

    public function destroy($id)
    {
        $item = DaftarBelanja::where('belanja_id', $id)->first();

        if (!$item) {
            $item = DaftarBelanja::where('barang_id', $id)->first();
        }

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus dari daftar belanja'
        ]);
    }
}
