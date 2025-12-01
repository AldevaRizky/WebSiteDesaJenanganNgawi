<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataStunting extends Model
{
    use HasFactory;

    protected $table = 'data_stunting';

    protected $fillable = [
        'nama_anak',
        'tanggal_pengukuran',
        'umur_bulan',
        'tinggi_badan_cm',
        'berat_badan',
        'lingkar_kepala',
        'lingkar_lengan',
        'status_stunting',
    ];

    protected $casts = [
        'tanggal_pengukuran' => 'date',
        'umur_bulan' => 'integer',
        'tinggi_badan_cm' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'lingkar_kepala' => 'decimal:2',
        'lingkar_lengan' => 'decimal:2',
    ];

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status_stunting) {
            'normal' => 'Normal',
            'stunting' => 'Stunting',
            'severely_stunting' => 'Stunting Berat',
            'tinggi' => 'Tinggi',
            default => 'Normal'
        };
    }

    /**
     * Get status color for badge
     */
    public function getStatusColorAttribute()
    {
        return match($this->status_stunting) {
            'normal' => 'success',
            'stunting' => 'warning',
            'severely_stunting' => 'danger',
            'tinggi' => 'info',
            default => 'secondary'
        };
    }
}
