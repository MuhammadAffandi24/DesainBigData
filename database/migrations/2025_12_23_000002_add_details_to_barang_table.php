<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Tambah kolom gambar
            $table->string('gambar', 255)->nullable()->after('harga_barang');
            
            // Tambah relasi ke tabel tokos (biar produk terhubung ke toko)
            $table->unsignedBigInteger('toko_id')->nullable()->after('gudang_id');
            $table->foreign('toko_id')->references('toko_id')->on('tokos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropForeign(['toko_id']);
            $table->dropColumn(['toko_id', 'gambar']);
        });
    }
};