<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SejarahDesa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sejarah_desa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'deskripsi',
    ];

    /**
     * Casts
     *
     * @var array<string,string>
     */
    protected $casts = [
        'judul' => 'string',
        'subjudul' => 'string',
        'gambar' => 'string',
        'deskripsi' => 'string',
    ];
}
