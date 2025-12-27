<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiwayatBelanja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RiwayatBelanjaController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $perPage = $request->input('per_page', 5); // default 5 per halaman

        $query = RiwayatBelanja::join('barang', 'riwayat_belanja.barang_id', '=', 'barang.barang_id')
            ->join('gudang', 'barang.gudang_id', '=', 'gudang.gudang_id')
            ->where('gudang.user_id', $userId)
            ->select(
                'riwayat_belanja.riwayat_id',
                'riwayat_belanja.tanggal',
                'riwayat_belanja.waktu',
                'riwayat_belanja.barang_id',
                'riwayat_belanja.nama_barang',
                'riwayat_belanja.kategori',
                'riwayat_belanja.tempat_beli',
                'riwayat_belanja.jumlah',
                'riwayat_belanja.harga',
                'riwayat_belanja.total_harga'
            );

        // 🔎 Filter berdasarkan request
        if ($request->filled('tanggal')) {
            $query->whereDate('riwayat_belanja.tanggal', $request->tanggal);
        }
        if ($request->filled('nama_barang')) {
            $query->where('riwayat_belanja.nama_barang', $request->nama_barang);
        }
        if ($request->filled('kategori')) {
            $query->where('riwayat_belanja.kategori', $request->kategori);
        }
        if ($request->filled('tempat_beli')) {
            $query->where('riwayat_belanja.tempat_beli', $request->tempat_beli);
        }

        $data = $query->orderBy('riwayat_belanja.tanggal', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat belanja berhasil diambil',
            'data' => $data->items(),
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
            ],
            'links' => [
                'next' => $data->nextPageUrl(),
                'prev' => $data->previousPageUrl(),
            ],
        ]);
    }
}
