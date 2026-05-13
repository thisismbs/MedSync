<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
    // Kasih tau Laravel nama tabel yang bener
    protected $table = 'antrean';
    
    // Kasih tau Laravel primary key-nya apa
    protected $primaryKey = 'id_antrean';

    // Biarin semua kolom bisa diisi (mass assignment)
    protected $guarded = [];
    // Kasih tau Antrean cara nyari data Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    // Kasih tau Antrean cara nyari data Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }
}