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