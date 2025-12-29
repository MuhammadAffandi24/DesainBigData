<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarBelanja extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'daftar_belanja';

    // Primary key sesuai tabel PostgreSQL
    protected $primaryKey = 'belanja_id';

    // Kalau primary key auto-increment
    public $incrementing = true;

    // Tipe data primary key
    protected $keyType = 'int';

    // Nonaktifkan timestamps kalau tabel gak punya created_at/updated_at
    public $timestamps = false;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'barang_id',
        'nama_barang',
        'sisa_stok',
        'toko_pembelian'
    ];

    // Relasi ke tabel Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
