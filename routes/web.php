<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DaftarBelanjaController;

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

# Register
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UserController::class, 'register'])->name('register.post');

Route::get('/whoami', function () {
    return ['auth_id' => Auth::id(), 'logged_in' => Auth::check()];
});

# barang
Route::post('/delete_barang', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::post('/belanja/delete', [DaftarBelanjaController::class, 'destroy'])->name('belanja.destroy');
