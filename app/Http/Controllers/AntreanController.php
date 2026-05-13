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
        // Hanya tampilin antrean hari ini biar resepsionis fokus
        $antreans = Antrean::whereDate('created_at', Carbon::today())
            ->with(['pasien', 'dokter.user']) // Tarik relasinya
            ->orderBy('created_at', 'asc')
            ->get();

        return view('resepsionis.kelola-antrean', compact('antreans'));
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

        // Cek anomali (jangan kasih daftar kalau antrean hari ini belum selesai)
        $cekAntrean = Antrean::where('id_pasien', $request->id_pasien)
            ->where('status', '!=', 'Selesai')
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($cekAntrean) {
            return redirect()->back()->with('error', 'Pasien ini masih dalam antrean dan belum selesai diperiksa!');
        }

        // Bikin nomor antrean otomatis (Misal: A-001, A-002)
        $jumlahAntreanHariIni = Antrean::whereDate('created_at', Carbon::today())->count();
        $nomorBaru = 'A-' . str_pad($jumlahAntreanHariIni + 1, 3, '0', STR_PAD_LEFT);

        Antrean::create([
            'id_pasien' => $request->id_pasien,
            'id_dokter' => $request->id_dokter,
            'nomor_antrean' => $nomorBaru,
            'status' => 'Menunggu' // Default status dari resepsionis
        ]);

        return redirect()->route('resepsionis.antrean')->with('success', 'Antrean berhasil dibuat dengan nomor: ' . $nomorBaru);
    }

    // BATALKAN (HAPUS) ANTREAN
    public function destroy($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->delete();

        return redirect()->route('resepsionis.antrean')->with('success', 'Antrean berhasil dibatalkan.');
    }
}