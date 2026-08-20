<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuPemeriksa extends Model
{
    use HasFactory;

    protected $table = 'waktu_pemeriksa';

    protected $fillable = [
        'tim_pemeriksa_id',
        'provinsi_id',
        'jumlah_hari',
    ];

    public function timPemeriksa()
    {
        return $this->belongsTo(
            TimPemeriksa::class,
            'tim_pemeriksa_id'
        );
    }

    public function provinsi()
    {
        return $this->belongsTo(
            Provinsi::class,
            'provinsi_id'
        );
    }
}