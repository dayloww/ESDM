<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Energi extends Model
{
    use SoftDeletes;

    protected $table = 'energi';

    protected $fillable = [
        // Field lama (tetap dipertahankan)
        'desa',
        'sumber_energi',
        'kapasitas',
        'jaringan',
        'potensi_ebt',
        'kondisi_infrastruktur',
        'permasalahan',
        'dokumentasi',

        // Field umum baru
        'jenis_usaha',

        // Field IUPTLS
        'nomor_izin',
        'nama_pemegang_izin',
        'nib',
        'badan_usaha',
        'jenis_pembangkit',
        'jumlah_unit',
        'latitude',
        'longitude',
        'tanggal_terbit',
        'masa_berlaku',
        'status',
        'keterangan',

        // Field UPTL
        'nama_badan_usaha',
        'penanggung_jawab',
        'jenis_usaha_penunjang',
        'bidang_kegiatan',
        'klasifikasi_usaha',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'masa_berlaku'   => 'date',
    ];
}
