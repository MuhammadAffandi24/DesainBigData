<?php

namespace App\Http\Controllers;

use App\Models\DaftarBelanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# Controller untuk menambahkan barang ke Daftar Belanja
class DaftarBelanjaController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:barang,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $daftarBelanja = DaftarBelanja::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'barang_id' => $request->product_id,
                ],
                [
                    'jumlah' => \DB::raw('jumlah + ' . $request->quantity)
                ]
            );
            
            # Notifikasi berhasil menambahkan ke Faftar Belanja
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan ke daftar belanja',
                'data' => $daftarBelanja
            ]);

        # Notifikasi gagal menambahkan ke Daftar Belanja
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan barang ke daftar belanja',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}