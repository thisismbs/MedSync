<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    // Kasih tau Laravel nama tabel yang bener (jangan ditambahin 's')
    protected $table = 'dokter';
    
    // Kasih tau Laravel primary key-nya apa
    protected $primaryKey = 'id_dokter';

    // Biarin semua kolom bisa diisi
    protected $guarded = [];

    // Kasih tau Dokter cara nyari data aslinya di tabel Users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}