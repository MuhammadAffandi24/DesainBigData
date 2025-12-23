<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Gudang;
use App\Models\Toko;
use App\Models\Barang;
use Illuminate\Support\Facades\Hash;

class TokoSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada User & Gudang dulu
        $user = User::firstOrCreate(
            ['username' => 'owner_toko'],
            ['password' => Hash::make('123456'), 'role' => 'Admin']
        );

        $gudang = Gudang::firstOrCreate(
            ['nama_gudang' => 'Gudang Utama'],
            ['user_id' => $user->user_id, 'lokasi' => 'Surakarta']
        );

        // Daftar Toko sesuai Desain Figma
        $dataToko = [
            ['nama' => 'Rejeki Abadi', 'img' => 'toko1.jpg'],
            ['nama' => 'Amanah', 'img' => 'toko2.jpg'],
            ['nama' => 'Serba Ada', 'img' => 'toko3.jpg'],
            ['nama' => 'Pojok Barang', 'img' => 'toko4.jpg'],
            ['nama' => 'Toko Maju Jaya', 'img' => 'toko5.jpg'],
            ['nama' => 'Laci Ajaib', 'img' => 'toko6.jpg'],
        ];

        foreach ($dataToko as $dt) {
            $toko = Toko::create([
                'nama_toko' => $dt['nama'],
                'alamat' => 'Pasar Gede, Surakarta',
                'banner_toko' => $dt['img'] // memastikan gambar ada di public/assets
            ]);

            // Isi Barang untuk setiap Toko
            Barang::create([
                'gudang_id' => $gudang->gudang_id, // wajib diisi
                'toko_id' => $toko->toko_id,       // relasi baru
                'nama_barang' => 'Kopi Arabica',
                'kategori' => 'Minuman',
                'jumlah_barang' => 50,
                'harga_barang' => 25000,
                'gambar' => 'kopi.png',
                'toko_pembelian' => $toko->nama_toko // Opsional, untuk backup string
            ]);

            Barang::create([
                'gudang_id' => $gudang->gudang_id,
                'toko_id' => $toko->toko_id,
                'nama_barang' => 'Minyak Goreng 2L',
                'kategori' => 'Sembako',
                'jumlah_barang' => 20,
                'harga_barang' => 32000,
                'gambar' => 'minyak.png',
                'toko_pembelian' => $toko->nama_toko
            ]);
        }
    }
}