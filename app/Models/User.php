<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user'; // Nama tabel kustom
    protected $primaryKey = 'user_id'; // Primary key kustom

    protected $fillable = [
        'username',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    // User memiliki 1 Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}