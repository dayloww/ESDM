<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengawasan extends Model
{
    use SoftDeletes;

    protected $table = 'pengawasan';

    protected $fillable = [
        'tanggal',
        'petugas',
        'objek',
        'lokasi',
        'hasil',
        'temuan',
        'rekomendasi',
        'dokumentasi',
        'tindak_lanjut',
        'status'
    ];
}
