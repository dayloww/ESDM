<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Energi extends Model
{
    use SoftDeletes;

    protected $table = 'energi';

    protected $fillable = [
        'desa',
        'sumber_energi',
        'kapasitas',
        'jaringan',
        'potensi_ebt',
        'kondisi_infrastruktur',
        'permasalahan',
        'dokumentasi'
    ];
}
