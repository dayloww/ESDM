<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'nama_role',
    ];

    /**
     * Relasi: satu role memiliki banyak user.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
