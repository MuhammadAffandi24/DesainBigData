<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Hapus barang berdasarkan ID dari form konfirmasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($request->id);
        $nama = $barang->nama_barang;
        $barang->delete();

        // Redirect ke homepage dengan pesan sukses INI NANTI DIUBAH
        return redirect('/homepage')->with('success', $nama. ' berhasil dihapus dari list Barang');
    }
}
