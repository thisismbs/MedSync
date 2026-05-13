<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    // Kasih tau Laravel nama tabel yang bener (jangan ditambahin 's')
    protected $table = 'pasien';
    
    // Kasih tau Laravel primary key-nya apa
    protected $primaryKey = 'id_pasien';

    // Biarin semua kolom bisa diisi
    protected $guarded = [];
}