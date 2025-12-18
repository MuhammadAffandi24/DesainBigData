<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'password' => Hash::make('superadmin123'),
                'role' => 'Superadmin',
                'status' => 'Aktif',
            ]
        );
    }
}
