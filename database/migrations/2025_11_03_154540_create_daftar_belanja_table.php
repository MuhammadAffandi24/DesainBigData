<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daftar_belanja', function (Blueprint $table) {
            $table->id('belanja_id');
            $table->unsignedBigInteger('barang_id');
            $table->string('nama_barang', 100);
            $table->integer('sisa_stok');
            $table->string('toko_pembelian', 50)->nullable();

            $table->foreign('barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daftar_belanja');
    }
};
