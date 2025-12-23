<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokos', function (Blueprint $table) {
            $table->id('toko_id'); // Pakai toko_id sebagai primary key
            $table->string('nama_toko', 100);
            $table->string('alamat', 255)->nullable();
            $table->string('banner_toko', 255)->nullable(); // Foto Toko
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};