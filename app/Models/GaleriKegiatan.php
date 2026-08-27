<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriKegiatan extends Model
{
    protected $table = 'galeri_kegiatan';

    protected $fillable = [
        'judul',
        'kategori',
        'tanggal',
        'keterangan',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}