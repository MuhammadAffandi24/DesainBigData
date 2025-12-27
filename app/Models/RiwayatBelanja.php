<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatBelanja extends Model
{
    use HasFactory;

    protected $table = 'riwayat_belanja';

    protected $primaryKey = 'riwayat_id';

    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'waktu',
        'barang_id',
        'nama_barang',
        'kategori',
        'tempat_beli',
        'jumlah',
        'harga',
        'total_harga'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}
