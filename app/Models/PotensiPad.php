<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PotensiPad extends Model
{
    use SoftDeletes;

    protected $table = 'potensi_pad';

    protected $fillable = [
        'jenis_kegiatan',
        'komoditas',
        'volume',
        'satuan',
        'periode',
        'nilai_produksi',
        'pelaku_usaha',
        'lokasi',
        'estimasi_penerimaan'
    ];
}
