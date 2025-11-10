<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenduduk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_penduduk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total_penduduk',
        'kepala_keluarga',
        'laki_laki',
        'perempuan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_penduduk' => 'integer',
        'kepala_keluarga' => 'integer',
        'laki_laki' => 'integer',
        'perempuan' => 'integer',
    ];
}
