<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Barang;

class TokoImageController extends Controller
{
    // ==============================
    // TOKO
    // ==============================

    // Upload & Rename Nama Toko
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'nama_toko' => 'required'
        ]);

        $namaToko = $request->nama_toko;
        $file = $request->file('image');
        
        $ext = $file->getClientOriginalExtension();
        $newName = $namaToko . '.' . $ext;
        $destinationPath = public_path('assets');

        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        foreach ($extensions as $e) {
            $oldFile = $destinationPath . '/' . $namaToko . '.' . $e;
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $file->move($destinationPath, $newName);

        return back()->with('success', 'Gambar toko berhasil diperbarui!');
    }

    // Hapus Gambar Toko
    public function delete(Request $request)
    {
        $namaToko = $request->nama_toko;
        $destinationPath = public_path('assets');
        
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $deleted = false;

        foreach ($extensions as $e) {
            $file = $destinationPath . '/' . $namaToko . '.' . $e;
            if (File::exists($file)) {
                File::delete($file);
                $deleted = true;
            }
        }

        if ($deleted) {
            return back()->with('success', 'Gambar toko berhasil dihapus. Kembali ke default.');
        } else {
            return back()->with('error', 'Gambar tidak ditemukan.');
        }
    }

    // ==============================
    // PRODUK
    // ==============================

    // Upload Gambar Produk
    public function uploadProductImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'barang_id' => 'required'
    ]);

    $barang = Barang::findOrFail($request->barang_id);
    $file = $request->file('image');

    // nama file dari nama barang
    $cleanName = preg_replace('/[^A-Za-z0-9]/', '_', $barang->nama_barang);
    $ext = $file->getClientOriginalExtension();
    $newName = $cleanName . '.' . $ext;

    $destinationPath = public_path('assets');

    // hapus file lama (SEMUA ekstensi)
    foreach (['jpg','jpeg','png','webp'] as $e) {
        $oldFile = $destinationPath . '/' . $cleanName . '.' . $e;
        if (File::exists($oldFile)) {
            File::delete($oldFile);
        }
    }

    // simpan file baru
    $file->move($destinationPath, $newName);

    // ⛔ TIDAK ADA UPDATE DATABASE

    return back()->with('success', 'Gambar produk berhasil diperbarui!');
}

    // Hapus Gambar Produk
    public function deleteProductImage(Request $request)
{
    $barang = Barang::findOrFail($request->barang_id);
    $destinationPath = public_path('assets');

    $cleanName = preg_replace('/[^A-Za-z0-9]/', '_', $barang->nama_barang);

    foreach (['jpg','jpeg','png','webp'] as $e) {
        $file = $destinationPath . '/' . $cleanName . '.' . $e;
        if (File::exists($file)) {
            File::delete($file);
        }
    }

    return back()->with('success', 'Gambar produk berhasil dihapus.');
}

}