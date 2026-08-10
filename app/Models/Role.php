<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role'; // Nama tabel kustom
    
    protected $fillable = ['nama_role'];

    // 1 Role dimiliki oleh banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}