<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'perangkat_desas';

    protected $fillable = [
        'nama',
        'jabatan',
        'gambar',
        'deskripsi',
        'phone',
        'email',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
    // hierarchy removed: parent_id and order columns are dropped in latest migration

    /**
     * Scope only active records
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Get full URL for gambar if present
     */
    public function getGambarUrlAttribute()
    {
        if (! $this->gambar) {
            return null;
        }

        return asset('storage/' . $this->gambar);
    }
}
