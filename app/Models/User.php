<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users'; 
    protected $primaryKey = 'user_id'; 
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
}
