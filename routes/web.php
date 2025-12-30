<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// API Controllers
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GudangController;

// WEB Controllers
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SuperadminUserController;
use App\Http\Controllers\SuperadminDashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaftarBelanjaController;
use App\Http\Controllers\TokoImageController;


// Models Controllers
use App\Models\Barang;

# ===============================
# Landing Page
# ===============================
Route::get('/', function () {
    return view('landing');
})->name('landing');

# ===============================
# Login User
# ===============================
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('gudang.register.form');
    }

    return back()->with('error', 'username atau password salah!');
})->name('login');

# ===============================
# Login Admin
# ===============================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

# ===============================
# Register User
# ===============================
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

# ===============================
# Route yang butuh LOGIN
# ===============================
Route::middleware('auth')->group(function () {

    # Register Gudang
    Route::get('/gudang/register', function () {
        return view('registergudang');
    })->name('gudang.register.form');

    Route::post('/gudang/register', [GudangController::class, 'store'])
        ->name('gudang.register.post');

    # HOME (PAKAI BARANG CONTROLLER WEB)
    Route::get('/home', [BarangController::class, 'index'])
        ->name('home');

    Route::resource('barang', BarangController::class);

    Route::post('/daftar-belanja', [DaftarBelanjaController::class, 'store'])
        ->name('daftar-belanja.store');

    Route::put('/daftar-belanja/{id}', [DaftarBelanjaController::class, 'update'])
        ->name('daftar-belanja.update');

    Route::delete('/daftar-belanja/{id}', [DaftarBelanjaController::class, 'destroy'])
        ->name('daftar-belanja.destroy');
});

# ===============================
# Superadmin
# ===============================
Route::get('/superadmin/home', [SuperadminDashboardController::class, 'index'])
    ->name('superadmin.home');

Route::post('/superadmin/user/{id}/status', [SuperadminUserController::class, 'updateStatus'])
    ->name('superadmin.user.updateStatus');

Route::delete('/superadmin/user/{id}', [SuperadminUserController::class, 'destroy'])
    ->name('superadmin.user.delete');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');
});


# ===============================
# Halaman Daftar Toko
# ===============================
Route::get('/cek-toko', function () {
    $tokos = Barang::select('toko_pembelian')
        ->whereNotNull('toko_pembelian')
        ->distinct()
        ->get();
    return view('toko.index', compact('tokos'));
})->name('toko.index');

# ===============================
# Halaman Detail Toko (Daftar Produk)
# ===============================
Route::get('/cek-toko/{nama_toko}', function ($nama_toko, Request $request) {
    $nama_toko_asli = urldecode($nama_toko);

    $categories = Barang::where('toko_pembelian', $nama_toko_asli)
        ->select('kategori')
        ->distinct()
        ->pluck('kategori');

    $query = Barang::where('toko_pembelian', $nama_toko_asli);

    if ($request->has('kategori') && $request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $barang = $query->get();

    return view('toko.show', compact('barang', 'categories', 'nama_toko_asli'));
})->name('toko.show');

# ===============================
# Halaman Detail Produk
# ===============================
Route::get('/produk/{id}', function ($id) {
    $barang = Barang::findOrFail($id);
    return view('toko.detail', compact('barang'));
})->name('produk.show');

# ===============================
# Kelola Gambar Toko & Produk
# ===============================

Route::post('/toko/image/upload', [TokoImageController::class, 'upload'])
    ->name('toko.image.upload');
Route::post('/toko/image/delete', [TokoImageController::class, 'delete'])
    ->name('toko.image.delete');
Route::post('/produk/image/upload', [TokoImageController::class, 'uploadProductImage'])
    ->name('produk.image.upload');
Route::post('/produk/image/delete', [TokoImageController::class, 'deleteProductImage'])
    ->name('produk.image.delete');
# ===============================
# Logout
# ===============================
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');
