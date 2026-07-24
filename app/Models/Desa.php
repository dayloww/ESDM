<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desa extends Model
{
    protected $table = 'desa';

    protected $fillable = ['kecamatan_id', 'nama'];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function dataWilayahs(): HasMany
    {
        return $this->hasMany(DataWilayah::class, 'desa_id');
    }
}
