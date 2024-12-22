<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik', 'nama', 'alamat', 'tempat_lahir', 'tanggal_lahir'
    ];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'nik_pelapor', 'nik');
    }
}