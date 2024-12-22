<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik', 'password', 'nama', 'alamat', 'tempat_lahir', 'tanggal_lahir'
    ];

    protected $hidden = [
        'password'
    ];
}