<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'barang_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'gudang_id',
        'nama_barang',
        'kategori',
        'jumlah_barang',
        'harga_barang',
        'toko_pembelian'
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }
}
