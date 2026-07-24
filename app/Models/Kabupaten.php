<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';

    protected $fillable = ['nama'];

    public function kecamatans(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id');
    }
}
