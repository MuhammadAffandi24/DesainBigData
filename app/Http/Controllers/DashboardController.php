<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

public function getData(Request $request)
{
    $userId = Auth::id();
    $filter = $request->filter ?? 'harian';
    $date   = Carbon::parse($request->date ?? now()->toDateString());

    $gudangId = DB::table('gudang')
        ->where('user_id', $userId)
        ->value('gudang_id');

    if (!$gudangId) {
        return response()->json([
            'line' => ['labels'=>[], 'pengeluaran'=>[], 'pemasukan'=>[]],
            'bar'  => [],
            'pie'  => []
        ]);
    }

    /* =========================
       RANGE & GROUP
    ========================= */
    if ($filter === 'harian') {
        $start = $date->copy()->startOfDay();
        $end   = $date->copy()->endOfDay();
        $group = "to_char(waktu, 'HH24:MI')";
    } elseif ($filter === 'mingguan') {
        $start = $date->copy()->startOfWeek();
        $end   = $date->copy()->endOfWeek();
        $group = "tanggal";
    } elseif ($filter === 'bulanan') {
        $start = $date->copy()->startOfMonth();
        $end   = $date->copy()->endOfMonth();
        $group = "tanggal";
    } else { // tahunan
        $start = $date->copy()->startOfYear();
        $end   = $date->copy()->endOfYear();
        $group = "tanggal";
    }

    /* =========================
       PENGELUARAN (FIX HARlAN)
    ========================= */
    $pengeluaran = DB::table('riwayat_belanja')
        ->join('barang', 'riwayat_belanja.barang_id', '=', 'barang.barang_id')
        ->where('barang.gudang_id', $gudangId)
        ->whereRaw("(tanggal + waktu) BETWEEN ? AND ?", [$start, $end])
        ->selectRaw("$group as label, SUM(total_harga) as total")
        ->groupBy('label')
        ->orderBy('label')
        ->get()
        ->keyBy('label');

    /* =========================
       PEMASUKAN (TIDAK PER MENIT)
    ========================= */
    $pemasukan = DB::table('riwayat_pembayaran')
        ->where('user_id', $userId)
        ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
        ->selectRaw("tanggal as label, SUM(jumlah_dibayar) as total")
        ->groupBy('label')
        ->get()
        ->keyBy('label');

    /* =========================
       LABEL MERGE
    ========================= */
    $labels = collect($pengeluaran->keys())->values();

    $out = [];
    $in  = [];

    foreach ($labels as $l) {
        $out[] = $pengeluaran[$l]->total ?? 0;
        $in[]  = 0; // pemasukan tidak per menit (BIAR LOGIS)
    }

    /* =========================
       BAR (DINAMIS)
    ========================= */
    $bar = DB::table('riwayat_belanja')
        ->join('barang', 'riwayat_belanja.barang_id', '=', 'barang.barang_id')
        ->where('barang.gudang_id', $gudangId)
        ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
        ->select('barang.nama_barang', DB::raw('SUM(jumlah) as jumlah_barang'))
        ->groupBy('barang.nama_barang')
        ->orderByDesc('jumlah_barang')
        ->get();

    /* =========================
       PIE (DINAMIS)
    ========================= */
    $pie = DB::table('riwayat_belanja')
        ->join('barang', 'riwayat_belanja.barang_id', '=', 'barang.barang_id')
        ->where('barang.gudang_id', $gudangId)
        ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
        ->select('barang.kategori', DB::raw('SUM(jumlah) as total'))
        ->groupBy('barang.kategori')
        ->get();

    return response()->json([
        'line' => [
            'labels'      => $labels,
            'pengeluaran' => $out,
            'pemasukan'   => $in,
        ],
        'bar' => $bar,
        'pie' => $pie
    ]);
}
}
