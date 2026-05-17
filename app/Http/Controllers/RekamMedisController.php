<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrean;
use App\Models\Dokter;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    // TAMPILIN DAFTAR RIWAYAT REKAM MEDIS
    public function index(Request $request)
    {
        $search = $request->search;
        
        // Cari ID Dokter yang lagi login
        $dokter = \App\Models\Dokter::where('id_user', auth()->user()->id_user)->first();

        // Tarik rekam medis KHUSUS punya dokter ini aja, plus fitur search & pagination
        $riwayats = \App\Models\RekamMedis::where('id_dokter', $dokter->id_dokter)
            ->when($search, function($query, $search) {
                return $query->whereHas('pasien', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhere('diagnosa', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc') // Urutin dari yang paling baru
            ->paginate(10)
            ->withQueryString();

        return view('dokter.rekammedis', compact('riwayats', 'search'));
    }

    // TAMPILIN FORM ISI REKAM MEDIS (Berdasarkan Pasien yg Dipanggil)
    public function create($id_antrean)
    {
        $antrean = Antrean::with('pasien')->findOrFail($id_antrean);
        return view('dokter.form-rekammedis', compact('antrean'));
    }

    // SIMPAN REKAM MEDIS & SELESAIKAN ANTREAN
    public function store(Request $request, $id_antrean)
    {
        $antrean = Antrean::findOrFail($id_antrean);

        $request->validate([
            'keluhan' => 'required',
            'diagnosa' => 'required',
            'resep_tindakan' => 'required'
        ]);

        // 1. Simpan ke tabel rekam_medis
        // 1. Simpan ke tabel rekam_medis (Keluhan digabung ke Diagnosa)
        RekamMedis::create([
            'id_pasien' => $antrean->id_pasien,
            'id_dokter' => $antrean->id_dokter,
            'tanggal'   => \Carbon\Carbon::today(),
            // Gabungin keluhan dan diagnosa pakai pemisah " | "
            'diagnosa'  => 'Keluhan: ' . $request->keluhan . ' | Diagnosa: ' . $request->diagnosa, 
            'tindakan'  => $request->resep_tindakan 
        ]);

        // 2. Ubah status antrean jadi Selesai
        $antrean->update(['status' => 'Selesai']);

        return redirect()->route('dokter.rekammedis')->with('success', 'Rekam medis berhasil disimpan dan antrean diselesaikan!');
    }

    // TAMPILIN DETAIL REKAM MEDIS
    public function show($id_rekam)
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter.user'])->findOrFail($id_rekam);
        return view('dokter.detail-rekammedis', compact('rekamMedis'));
    }
}