<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Toko;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil Gudang Utama (Wajib ada untuk foreign key)
        $gudang = Gudang::where('nama_gudang', 'Gudang Utama')->first();

        // Jika tidak ada gudang, hentikan (Safety check)
        if (!$gudang) {
            $this->command->error('Gudang Utama tidak ditemukan! Jalankan TokoSeeder terlebih dahulu.');
            return;
        }

        // Ambil semua toko yang sudah dibuat di TokoSeeder
        $tokos = Toko::all();

        // Data Barang Dummy yang akan dimasukkan ke SETIAP toko
        // (Saya ambil contoh dari kode teman Anda sebelumnya: Kopi & Minyak)
        $templateBarang = [
            [
                'nama_barang' => 'Kopi Arabica',
                'kategori' => 'Minuman',
                'jumlah_barang' => 50,
                'harga_barang' => 25000,
                'gambar' => 'kopi.png',
            ],
            [
                'nama_barang' => 'Minyak Goreng 2L',
                'kategori' => 'Sembako',
                'jumlah_barang' => 20,
                'harga_barang' => 32000,
                'gambar' => 'minyak.png',
            ],
            [
                'nama_barang' => 'Mie Instan',
                'kategori' => 'Makanan',
                'jumlah_barang' => 100,
                'harga_barang' => 3500,
                'gambar' => 'mie.png',
            ]
        ];

        // Loop setiap toko, lalu isi dengan barang-barang di atas
        foreach ($tokos as $toko) {
            foreach ($templateBarang as $item) {
                Barang::create([
                    'gudang_id'      => $gudang->gudang_id,
                    'toko_id'        => $toko->toko_id,     // Link ke Toko
                    'nama_barang'    => $item['nama_barang'],
                    'kategori'       => $item['kategori'],
                    'jumlah_barang'  => $item['jumlah_barang'],
                    'harga_barang'   => $item['harga_barang'],
                    'gambar'         => $item['gambar'],
                    'toko_pembelian' => $toko->nama_toko    // Backup nama toko
                ]);
            }
        }
    }
}