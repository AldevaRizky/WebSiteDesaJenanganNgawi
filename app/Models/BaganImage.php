<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaganImage extends Model
{
    use HasFactory;

    protected $table = 'bagan_images';

    protected $fillable = [
        'gambar',
        'nama',
    ];

    public function getGambarUrlAttribute()
    {
        if (! $this->gambar) return null;
        return asset('storage/' . $this->gambar);
    }
}
