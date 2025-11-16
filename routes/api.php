<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\GudangController;
use App\Http\Controllers\Api\DaftarBelanjaController;
use App\Http\Controllers\Api\TagihanController;
use App\Http\Controllers\Api\RiwayatPembayaranController;

Route::prefix('users')->group(function () {
    Route::post('/register', [UserController::class, 'register'])->name('register.post');
    Route::post('/login',    [UserController::class, 'login'])->name('login.post');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logout.post');
        Route::put('/role/{id}', [UserController::class, 'updateRole']);
        Route::get('/', [UserController::class, 'index']);
    });
});

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::prefix('gudang')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [GudangController::class, 'index']);
    Route::get('/{id}', [GudangController::class, 'show']);
    Route::post('/', [GudangController::class, 'store']);
    Route::delete('/{id}', [GudangController::class, 'destroy']);
});

Route::prefix('daftar-belanja')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [DaftarBelanjaController::class, 'index']);
    Route::post('/', [DaftarBelanjaController::class, 'addToCart']);
});

Route::prefix('tagihan')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TagihanController::class, 'index']);
    Route::get('/{id}', [TagihanController::class, 'show']);
    Route::post('/', [TagihanController::class, 'store']);
    Route::put('/{id}', [TagihanController::class, 'update']);
    Route::delete('/{id}', [TagihanController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->prefix('riwayat-pembayaran')->group(function () {
    Route::get('/', [RiwayatPembayaranController::class, 'index']);
    Route::put('/{id}', [RiwayatPembayaranController::class, 'update']);
    Route::delete('/{id}', [RiwayatPembayaranController::class, 'destroy']);
    Route::get('/export/csv', [RiwayatPembayaranController::class, 'exportCsv']);
});
