<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrean;
use App\Models\Pasien;
use App\Models\User;
use App\Models\Dokter;
use Carbon\Carbon;

class AntreanController extends Controller
{
    // TAMPILIN TABEL ANTREAN (HARI INI SAJA)
    public function index(Request $request)
    {
        // Tangkap request tanggal. Kalau kosong, default ke hari ini
        $tanggal = $request->tanggal ? $request->tanggal : \Carbon\Carbon::today()->format('Y-m-d');

        // Tarik data antrean KHUSUS untuk tanggal tersebut
        $antreans = \App\Models\Antrean::whereDate('created_at', $tanggal)->get();

        return view('resepsionis.kelola-antrean', compact('antreans', 'tanggal'));
    }

    // TAMPILIN FORM TAMBAH
    public function create()
    {
        $pasiens = Pasien::all(); // Buat dropdown pasien
        
        // Tarik data user dokter beserta data spesialisasi dari relasinya
        $dokters = Dokter::join('users', 'dokter.id_user', '=', 'users.id_user')
                 ->select('dokter.id_dokter', 'users.nama', 'dokter.spesialisasi')
                 ->get();

        return view('resepsionis.form-antrean', compact('pasiens', 'dokters'));
    }

    // SIMPAN ANTREAN
    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required',
            'id_dokter' => 'required',
        ]);

        // LOGIKA ANTI-SPAM: Cek apakah pasien udah daftar hari ini dan belum selesai
        $cekAntrean = \App\Models\Antrean::where('id_pasien', $request->id_pasien)
                        ->whereDate('created_at', \Carbon\Carbon::today())
                        ->whereIn('status', ['Menunggu', 'Diperiksa'])
                        ->first();

        if ($cekAntrean) {
            return redirect()->back()->with('error', 'Gagal! Pasien ini sudah terdaftar di antrean hari ini dan belum selesai diperiksa.');
        }

        // Bikin nomor antrean otomatis
        $hariIni = \Carbon\Carbon::today();
        $antreanTerakhir = \App\Models\Antrean::whereDate('created_at', $hariIni)->count();
        $nomorAntrean = $antreanTerakhir + 1;

        \App\Models\Antrean::create([
            'id_pasien' => $request->id_pasien,
            'id_dokter' => $request->id_dokter,
            'nomor_antrean' => $nomorAntrean,
            'status' => 'Menunggu'
        ]);

        return redirect()->route('resepsionis.antrean')->with('success', 'Antrean berhasil ditambahkan!');
    }

    // BATALKAN (HAPUS) ANTREAN
    public function destroy($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->delete();

        return redirect()->route('resepsionis.antrean')->with('success', 'Antrean berhasil dibatalkan.');
    }
}