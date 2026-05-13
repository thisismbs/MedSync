<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
    // Kasih tau Laravel nama tabel yang bener
    protected $table = 'antrean';
    
    // Kasih tau Laravel primary key-nya apa
    protected $primaryKey = 'id_antrean';

    // Biarin semua kolom bisa diisi (mass assignment)
    protected $guarded = [];
}