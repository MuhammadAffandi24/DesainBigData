<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gudang', function (Blueprint $table) {
            $table->id('gudang_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_gudang', 100);
            $table->string('lokasi', 150)->nullable();
            $table->string('status', 10)->default('Aktif');
            $table->date('joined_date')->useCurrent();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE gudang ADD CONSTRAINT chk_gudang_status CHECK (status IN ('Aktif', 'Tidak Aktif'))");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('gudang');
    }
};
