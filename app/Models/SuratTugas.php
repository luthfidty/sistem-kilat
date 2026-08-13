<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';

    protected $fillable = [
        'nomor_st',
    ];

    public function timPemeriksa()
    {
        return $this->hasMany(TimPemeriksa::class, 'surat_tugas_id');
    }
}
