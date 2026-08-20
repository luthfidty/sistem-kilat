<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiSpj extends Model
{
    use HasFactory;
    protected $table = 'realisasi_spj';

    protected $fillable = [
        'tim_pemeriksa_id',
        'jumlah_spj',
    ];

    public function timPemeriksa()
    {
        return $this->belongsTo(
            TimPemeriksa::class,
            'tim_pemeriksa_id'
        );
    }
}
