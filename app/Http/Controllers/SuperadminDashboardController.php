<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperadminDashboardController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();

        $total_gudang = DB::table('gudang')->count();

        $aktif = DB::table('gudang')
                    ->where('status', 'Aktif')
                    ->count();

        $nonaktif = DB::table('gudang')
                    ->where('status', 'Tidak Aktif')
                    ->count();

        return view('admin.homepageadmin', compact(
            'users',
            'total_gudang',
            'aktif',
            'nonaktif'
        ));
    }
}
