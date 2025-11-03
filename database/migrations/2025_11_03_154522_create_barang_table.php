<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->unsignedBigInteger('gudang_id');
            $table->string('nama_barang', 100);
            $table->string('kategori', 50)->nullable();
            $table->integer('jumlah_barang')->default(0);
            $table->decimal('harga_barang', 12, 2);
            $table->string('toko_pembelian', 50)->nullable();

            $table->foreign('gudang_id')->references('gudang_id')->on('gudang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
