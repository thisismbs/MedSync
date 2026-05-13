<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrean;
use App\Models\Dokter;
use Carbon\Carbon;

class DokterController extends Controller
{
    // Tampilin antrean khusus buat dokter yang lagi login (Hari ini aja)
    public function antrean()
    {
        $dokter = Dokter::where('id_user', auth()->user()->id_user)->first();

        // Tarik antrean yang belum selesai, urutkan dari yang paling lama nunggu
        $antreans = Antrean::with('pasien')
            ->where('id_dokter', $dokter->id_dokter)
            ->whereDate('created_at', Carbon::today())
            ->whereIn('status', ['Menunggu', 'Diperiksa']) // Yang udah selesai gak usah ditampilin di sini
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dokter.antrean', compact('antreans'));
    }

    // Fungsi pas dokter ngeklik tombol "Panggil Pasien"
    public function panggil($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->update(['status' => 'Diperiksa']);

        return redirect()->back()->with('success', 'Pasien berhasil dipanggil. Silakan periksa pasien dan isi rekam medis.');
    }
}