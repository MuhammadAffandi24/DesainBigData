<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPembayaran;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RiwayatPembayaranController extends Controller
{
    // 🔹 GET: Semua riwayat milik user login
    public function index()
    {
        $userId = Auth::id();

        $riwayat = RiwayatPembayaran::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get([
                'pembayaran_id',
                'tagihan_id',
                'user_id',
                'nama_tagihan',
                'kategori',
                'jumlah_dibayar',
                'tanggal',
                'status'
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pembayaran berhasil diambil',
            'data' => $riwayat
        ]);
    }

    // 🔹 PUT: Update riwayat pembayaran
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $riwayat = RiwayatPembayaran::where('pembayaran_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$riwayat) {
            return response()->json([
                'success' => false,
                'message' => 'Riwayat pembayaran tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $request->validate([
            'nama_tagihan' => 'sometimes|string|max:100',
            'kategori' => 'sometimes|string|max:50',
            'jumlah_dibayar' => 'sometimes|numeric|min:0',
            'tanggal' => 'sometimes|date',
            'status' => 'sometimes|in:Lunas,Belum Lunas,Belum Dibayar,Terlambat'
        ]);

        $riwayat->update($request->only(['nama_tagihan', 'kategori', 'jumlah_dibayar', 'tanggal', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pembayaran berhasil diperbarui',
            'data' => $riwayat
        ]);
    }

    // 🔹 DELETE: Hapus riwayat pembayaran
    public function destroy($id)
    {
        $userId = Auth::id();
        $riwayat = RiwayatPembayaran::where('pembayaran_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$riwayat) {
            return response()->json([
                'success' => false,
                'message' => 'Riwayat pembayaran tidak ditemukan atau bukan milik Anda'
            ], 404);
        }

        $riwayat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pembayaran berhasil dihapus'
        ]);
    }

    // 🔹 GET: Download CSV semua riwayat pembayaran user
    public function exportCsv()
    {
        $userId = Auth::id();
        $filename = "riwayat_pembayaran_user_{$userId}.csv";

        $riwayat = RiwayatPembayaran::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get([
                'pembayaran_id',
                'tagihan_id',
                'user_id',
                'nama_tagihan',
                'kategori',
                'jumlah_dibayar',
                'tanggal',
                'status'
            ]);

        if ($riwayat->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data riwayat pembayaran untuk diexport'
            ], 404);
        }

        $response = new StreamedResponse(function () use ($riwayat) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Pembayaran ID',
                'Tagihan ID',
                'User ID',
                'Nama Tagihan',
                'Kategori',
                'Jumlah Dibayar',
                'Tanggal',
                'Status'
            ]);

            foreach ($riwayat as $row) {
                fputcsv($handle, [
                    $row->pembayaran_id,
                    $row->tagihan_id,
                    $row->user_id,
                    $row->nama_tagihan,
                    $row->kategori,
                    $row->jumlah_dibayar,
                    $row->tanggal,
                    $row->status
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }

    
}
