<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrean;
use Carbon\Carbon;

class AntreanController extends Controller
{
    public function create()
    {
        return view('antrean.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan biar gak ada yang kosong
        $request->validate([
            'id_pasien' => 'required',
            'id_dokter' => 'required',
        ]);

        // 2. Logika bikin nomor antrean otomatis
        // Cari tau hari ini udah ada berapa orang yang antre
        $hariIni = Carbon::now()->format('Y-m-d');
        $jumlahAntrean = Antrean::whereDate('created_at', $hariIni)->count();
        
        // Tambahin 1 dari jumlah antrean hari ini
        $urutanBaru = $jumlahAntrean + 1;
        
        // Format angkanya biar jadi 3 digit (contoh: 1 jadi 001, 12 jadi 012)
        $nomorAntreanOtomatis = 'A-' . str_pad($urutanBaru, 3, '0', STR_PAD_LEFT);

        // 3. Simpan ke database
        Antrean::create([
            'id_pasien' => $request->id_pasien,
            'id_dokter' => $request->id_dokter,
            'nomor_antrean' => $nomorAntreanOtomatis,
            'status' => 'Menunggu', // Default status pas pasien baru datang
        ]);

        // 4. Balik ke halaman sebelumnya bawa pesan sukses
        return redirect()->back()->with('success', 'Antrean sukses dibikin! Nomor: ' . $nomorAntreanOtomatis);
    }
}