<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmImage extends Model
{
    use HasFactory;

    protected $table = 'umkm_images';

    protected $fillable = [
        'umkm_id',
        'path',
    ];

    /**
     * Get the UMKM that owns the image.
     */
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
