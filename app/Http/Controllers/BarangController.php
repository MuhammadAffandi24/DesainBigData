<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DaftarBelanja;
use App\Models\RiwayatBelanja;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Barang stok rendah
        $lowStockProducts = Barang::whereHas('gudang', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('jumlah_barang', '<', 10)
            ->get(['barang_id as id', 'nama_barang as name', 'jumlah_barang as stock']);

        $showLowStockPopup = false;
        if (!session()->has('show_low_stock_popup')) {
            $showLowStockPopup = count($lowStockProducts) > 0;
            session(['show_low_stock_popup' => true]);
        }

        // --------------------------
        // PAGINATION BARANG
        // --------------------------
        $barangQuery = Barang::whereHas('gudang', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        if ($request->filled('kategori')) {
            $barangQuery->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $barangQuery->where('nama_barang', 'ILIKE', '%' . $request->search . '%');
        }

        $barang = $barangQuery->paginate(5, ['*'], 'barang_page')->withQueryString();

        $kategoriList = Barang::whereHas('gudang', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->select('kategori')
        ->distinct()
        ->pluck('kategori');

        $userGudangs = Gudang::where('user_id', $userId)->get();

        // --------------------------
        // PAGINATION DAFTAR BELANJA
        // --------------------------
        $daftarBelanjaQuery = DaftarBelanja::join('barang', 'daftar_belanja.barang_id', '=', 'barang.barang_id')
            ->join('gudang', 'barang.gudang_id', '=', 'gudang.gudang_id')
            ->where('gudang.user_id', $userId)
            ->select(
                'daftar_belanja.belanja_id',
                'barang.nama_barang',
                'daftar_belanja.sisa_stok',
                'daftar_belanja.toko_pembelian',
                'barang.kategori',
                'barang.barang_id'
            );

        if ($request->filled('kategori_daftar')) {
            $daftarBelanjaQuery->where('barang.kategori', $request->kategori_daftar);
        }

        if ($request->filled('search_daftar')) {
            $daftarBelanjaQuery->where('barang.nama_barang', 'ILIKE', '%' . $request->search_daftar . '%');
        }

        $daftarBelanja = $daftarBelanjaQuery->paginate(5, ['*'], 'daftar_page')->withQueryString();

        // --------------------------
        // PAGINATION RIWAYAT BELANJA
        // --------------------------
        $riwayatBelanjaQuery = RiwayatBelanja::join('barang', 'riwayat_belanja.barang_id', '=', 'barang.barang_id')
            ->join('gudang', 'barang.gudang_id', '=', 'gudang.gudang_id')
            ->where('gudang.user_id', $userId)
            ->select(
                'riwayat_belanja.tanggal',
                'riwayat_belanja.waktu',
                'barang.nama_barang',
                'barang.kategori',
                'riwayat_belanja.tempat_beli',
                'riwayat_belanja.jumlah',
                'riwayat_belanja.harga',
                'riwayat_belanja.total_harga'
            )
            ->orderBy('riwayat_belanja.tanggal', 'desc');

        $riwayatBelanja = $riwayatBelanjaQuery->paginate(5, ['*'], 'riwayat_page')->withQueryString();

        return view('home', compact(
            'barang',
            'kategoriList',
            'daftarBelanja',
            'riwayatBelanja',
            'userGudangs',
            'lowStockProducts',
            'showLowStockPopup'
        ));
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
