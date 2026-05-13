<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    use HasFactory, Notifiable;

    // 1. Penangkal error login (karena ID kita namanya id_user)
    protected $primaryKey = 'id_user'; 

    // 2. Penangkal error "Field nama doesn't have a default value"
    protected $fillable = [
        'nama',      // Harus ada ini
        'email',
        'password',
        'role',      // Harus ada ini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
