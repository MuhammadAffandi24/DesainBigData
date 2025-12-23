<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 50)->unique();
            $table->string('status', 10)->default('Aktif');
            $table->string('password', 255);
            $table->string('role', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // Cek driver, jika BUKAN sqlite baru jalankan perintah ini
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users ADD CONSTRAINT chk_users_status CHECK (status IN ('Aktif', 'Tidak Aktif'))");
            DB::statement("ALTER TABLE users ADD CONSTRAINT chk_users_role CHECK (role IN ('Admin', 'Superadmin'))");
        }      
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
