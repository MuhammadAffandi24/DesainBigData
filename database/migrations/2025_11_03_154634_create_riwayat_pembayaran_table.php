<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->unsignedBigInteger('tagihan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_tagihan', 100);
            $table->string('kategori', 50)->nullable();
            $table->decimal('jumlah_dibayar', 12, 2);
            $table->date('tanggal')->useCurrent();
            $table->string('status', 20)->default('Belum Dibayar');

            $table->foreign('tagihan_id')->references('tagihan_id')->on('tagihan')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE riwayat_pembayaran ADD CONSTRAINT chk_riwayat_pembayaran_status CHECK (status IN ('Lunas', 'Belum Lunas', 'Belum Dibayar'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembayaran');
    }
};
