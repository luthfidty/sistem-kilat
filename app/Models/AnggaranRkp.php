<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranRkp extends Model
{
    use HasFactory;
    protected $table = 'anggaran_rkp';

    protected $fillable = [
        'tahun',
        'total_anggaran',
    ];
}
