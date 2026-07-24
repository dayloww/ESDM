<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mineral extends Model
{
    use SoftDeletes;

    protected $table = 'mineral';

    protected $fillable = [
        'lokasi',
        'jenis_komoditas',
        'pemegang_izin',
        'luas',
        'produksi',
        'dokumentasi',
        'hasil_pemantauan',
        'tindak_lanjut'
    ];
}
