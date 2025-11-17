<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = ['kategori_id', 'judul', 'slug', 'deskripsi', 'konten'];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    public function images()
    {
        return $this->hasMany(BeritaImage::class, 'berita_id');
    }
}
