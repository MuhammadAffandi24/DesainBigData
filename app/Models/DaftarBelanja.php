<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarBelanja extends Model
{
    use HasFactory;

    protected $table = 'daftar_belanja';
    protected $primaryKey = 'belanja_id';
    public $timestamps = false;
    protected $fillable = ['barang_id', 'nama_barang', 'sisa_stok', 'toko_pembelian'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
