<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GudangController;

# Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

# Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('username', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/home');
    }
    return back()->with('error', 'username atau password salah!');
})->name('login');

# Login Admin
Route::get('/admin/login', function () {
    return view('admin.loginadmin');
})->name('admin.login');

Route::post('/admin/login', [App\Http\Controllers\Api\UserController::class, 'login'])
    ->name('admin.login.submit');

# Register (User)
Route::get('/register', function () {
    return view('auth.register'); // form register user
})->name('register');

# Register Gudang (hanya untuk user login)
Route::middleware('auth')->group(function () {

    // Form registrasi gudang
    Route::get('/gudang/register', function () {
        return view('registergudang'); // blade register gudang
    })->name('gudang.register.form');

    // Proses simpan data gudang
    Route::post('/gudang/register', [GudangController::class, 'store'])
        ->name('gudang.register.post');

    // Halaman home (kosong sementara)
    Route::get('/home', function () {
        return ''; // kosong dulu biar redirect tidak error
    })->name('home');
});
