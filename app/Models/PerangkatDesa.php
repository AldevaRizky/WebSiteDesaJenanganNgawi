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
        'parent_id',
        'order',
        'phone',
        'email',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Parent perangkat (for hierarchical structure)
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Children perangkat (for hierarchical structure)
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

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
