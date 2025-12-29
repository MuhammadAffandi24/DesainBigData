<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TokoImageController extends Controller
{
    // LOGIKA UPLOAD & RENAME OTOMATIS
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

    // LOGIKA HAPUS GAMBAR
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
}