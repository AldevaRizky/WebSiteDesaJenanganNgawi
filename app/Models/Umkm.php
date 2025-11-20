<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'nama',
        'deskripsi',
        'alamat',
        'link_maps',
        'link_wa',
    ];

    /**
     * Get images for the UMKM
     */
    public function images()
    {
        return $this->hasMany(UmkmImage::class, 'umkm_id');
    }
}
