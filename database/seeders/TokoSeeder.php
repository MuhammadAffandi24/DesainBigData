<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gudang;
use App\Models\Toko;
use Illuminate\Support\Facades\Hash;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Setup User & Gudang (Sesuai kode asli teman Anda)
        $user = User::firstOrCreate(
            ['username' => 'cihuy'],
            ['password' => Hash::make('cihuy'), 'role' => 'Admin']
        );

        $gudang = Gudang::firstOrCreate(
            ['nama_gudang' => 'Gudang Utama'],
            ['user_id' => $user->user_id, 'lokasi' => 'Surakarta']
        );

        // 2. Hanya Membuat Data Toko
        $dataToko = [
            ['nama' => 'Rejeki Abadi', 'img' => 'toko1.jpg'],
            ['nama' => 'Amanah', 'img' => 'toko2.jpg'],
            ['nama' => 'Serba Ada', 'img' => 'toko3.jpg'],
            ['nama' => 'Pojok Barang', 'img' => 'toko4.jpg'],
            ['nama' => 'Toko Maju Jaya', 'img' => 'toko5.jpg'],
            ['nama' => 'Laci Ajaib', 'img' => 'toko6.jpg'],
        ];

        foreach ($dataToko as $dt) {
            Toko::firstOrCreate(
                ['nama_toko' => $dt['nama']], // Cek agar tidak duplikat
                [
                    'alamat' => 'Pasar Gede, Surakarta',
                    'banner_toko' => $dt['img']
                ]
            );
        }
    }
}