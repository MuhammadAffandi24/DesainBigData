<?php
    
    # Landing Page

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

    # Login 

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form'); // <- ini untuk TAMPIL form login

Route::post('/login', function(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/home');
    }

    return back()->with('error', 'Email atau password salah!');
})->name('login'); // <- ini untuk PROSES login

    # Login Admin 

Route::get('/admin/login', function () {
    return view('admin.loginadmin'); 
})->name('admin.login');

Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'login'])
    ->name('admin.login.submit'); // <- ini untuk PROSES login

    # Register

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');