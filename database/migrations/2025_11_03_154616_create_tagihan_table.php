<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('tagihan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_tagihan', 100);
            $table->string('kategori', 50)->nullable();
            $table->date('jatuh_tempo');
            $table->decimal('nominal', 12, 2);
            $table->string('status_pembayaran', 20)->default('Belum Dibayar');

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE tagihan ADD CONSTRAINT chk_tagihan_status CHECK (status_pembayaran IN ('Lunas', 'Belum Lunas', 'Belum Dibayar', 'Terlambat'))");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
