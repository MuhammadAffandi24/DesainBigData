<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPembayaran extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pembayaran';
    protected $primaryKey = 'pembayaran_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'tagihan_id',
        'user_id',
        'nama_tagihan',
        'kategori',
        'jumlah_dibayar',
        'tanggal',
        'status'
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'tagihan_id');
    }
}
