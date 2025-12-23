<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'toko_id'; // Kunci utama
    protected $guarded = ['toko_id'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'toko_id', 'toko_id');
    }
}