<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::paginate(5);
        // $belanja = Barang::latest()->paginate(5);

        return view('home', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'jumlah_barang' => 'required|integer',
            'harga_barang' => 'required|integer',
            'toko_pembelian' => 'required'
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'jumlah_barang' => $request->jumlah_barang,
            'harga_barang' => $request->harga_barang,
            'toko_pembelian' => $request->toko_pembelian
        ]);

        return redirect()->route('home')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->route('home')->with('success', 'Barang berhasil dihapus!');
    }
}
