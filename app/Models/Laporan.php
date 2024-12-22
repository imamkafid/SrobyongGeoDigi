<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan'; // Menentukan nama tabel yang benar

    protected $fillable = [
        'nik_pelapor', 
        'deskripsi', 
        'media_path', 
        'latitude', 
        'longitude', 
        'status'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'nik_pelapor', 'nik');
    }
}