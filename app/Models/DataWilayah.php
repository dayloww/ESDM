<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataWilayah extends Model
{
    protected $table = 'data_wilayah';

    protected $fillable = [
        'desa_id',
        'koordinat',
        'jumlah_penduduk',
        'kondisi_ketenagalistrikan',
        'status_berlistrik',
        'potensi_energi',
        'potensi_sumber_daya_mineral'
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
