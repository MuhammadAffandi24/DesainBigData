<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_belanja', function (Blueprint $table) {
            $table->id('riwayat_id');
            $table->date('tanggal')->useCurrent();
            $table->time('waktu')->useCurrent();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->string('nama_barang', 100);
            $table->string('kategori', 50)->nullable();
            $table->string('tempat_beli', 100);
            $table->integer('jumlah');
            $table->decimal('harga', 12, 2);
            $table->decimal('total_harga', 12, 2)->storedAs('jumlah * harga');

            $table->foreign('barang_id')->references('barang_id')->on('barang')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_belanja');
    }
};
