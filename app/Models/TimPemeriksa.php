<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPemeriksa extends Model
{
    use HasFactory;

    protected $table = 'tim_pemeriksa';

    protected $fillable = [
        'surat_tugas_id',
        'jabatan_id',
        'nama_pemeriksa',
        'jangka_waktu',
        'jumlah_biaya',
    ];

    public function suratTugas()
    {
        return $this->belongsTo(
            SuratTugas::class,
            'surat_tugas_id'
        );
    }

    public function jabatan()
    {
        return $this->belongsTo(
            Jabatan::class,
            'jabatan_id'
        );
    }

    public function waktuPemeriksa()
    {
        return $this->hasMany(
            WaktuPemeriksa::class,
            'tim_pemeriksa_id'
        );
    }
}