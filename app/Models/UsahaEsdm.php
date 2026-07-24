<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsahaEsdm extends Model
{
    use SoftDeletes;

    protected $table = 'usaha_esdm';

    protected $fillable = [
        'nama_pelaku_usaha',
        'nomor_identitas',
        'nomor_perizinan',
        'jenis_usaha',
        'komoditas',
        'lokasi',
        'koordinat',
        'status',
        'produksi',
        'penjualan',
        'dokumen',
        'foto'
    ];
}
