<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\RekamMedisController;
use App\Models\Antrean;
use App\Models\Dokter;
use Carbon\Carbon;

// Redirect awal ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dasbor utama (Bisa diakses semua role yang udah login, kontennya menyesuaikan)
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role == 'admin') {
        return view('admin.dashboard');
    } elseif ($user->role == 'resepsionis') {
        return view('resepsionis.dashboard');
    } elseif ($user->role == 'dokter') {
        // Cari ID Dokter si User ini
        $dokter = Dokter::where('id_user', $user->id_user)->first();
        
        // Ngitung statistik khusus hari ini & khusus buat dokter ini aja
        $totalPasien = Antrean::where('id_dokter', $dokter->id_dokter)->whereDate('created_at', Carbon::today())->count();
        $menunggu = Antrean::where('id_dokter', $dokter->id_dokter)->where('status', 'Menunggu')->whereDate('created_at', Carbon::today())->count();
        $selesai = Antrean::where('id_dokter', $dokter->id_dokter)->where('status', 'Selesai')->whereDate('created_at', Carbon::today())->count();

        return view('dokter.dashboard', compact('dokter', 'totalPasien', 'menunggu', 'selesai'));
    }

    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// 1. AREA KHUSUS ADMIN (Pakai Gembok 'role:admin')
// ==========================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/kelola-akun', [UserController::class, 'index'])->name('admin.kelola-akun');
    Route::get('/admin/kelola-akun/tambah', [UserController::class, 'create'])->name('admin.akun.create');
    Route::post('/admin/kelola-akun', [UserController::class, 'store'])->name('admin.akun.store');
    Route::get('/admin/kelola-akun/{id}/edit', [UserController::class, 'edit'])->name('admin.akun.edit');
    Route::put('/admin/kelola-akun/{id}', [UserController::class, 'update'])->name('admin.akun.update');
    Route::delete('/admin/kelola-akun/{id}', [UserController::class, 'destroy'])->name('admin.akun.destroy');
    
    Route::get('/admin/pasien', [PasienController::class, 'index'])->name('admin.pasien');
    Route::get('/admin/pasien/tambah', [PasienController::class, 'create'])->name('admin.pasien.create');
    Route::post('/admin/pasien', [PasienController::class, 'store'])->name('admin.pasien.store');
    Route::get('/admin/pasien/{id}/edit', [PasienController::class, 'edit'])->name('admin.pasien.edit');
    Route::put('/admin/pasien/{id}', [PasienController::class, 'update'])->name('admin.pasien.update');
    Route::delete('/admin/pasien/{id}', [PasienController::class, 'destroy'])->name('admin.pasien.destroy');
});


// ==========================================
// 2. AREA KHUSUS RESEPSIONIS (Pakai Gembok 'role:resepsionis')
// ==========================================
Route::middleware(['auth', 'role:resepsionis'])->group(function () {
    Route::get('/resepsionis/pasien', [PasienController::class, 'index'])->name('resepsionis.pasien');
    Route::get('/resepsionis/pasien/tambah', [PasienController::class, 'create'])->name('resepsionis.pasien.create');
    Route::post('/resepsionis/pasien', [PasienController::class, 'store'])->name('resepsionis.pasien.store');
    Route::get('/resepsionis/pasien/{id}/edit', [PasienController::class, 'edit'])->name('resepsionis.pasien.edit');
    Route::put('/resepsionis/pasien/{id}', [PasienController::class, 'update'])->name('resepsionis.pasien.update');
    Route::delete('/resepsionis/pasien/{id}', [PasienController::class, 'destroy'])->name('resepsionis.pasien.destroy');
    
    Route::get('/resepsionis/antrean', [AntreanController::class, 'index'])->name('resepsionis.antrean');
    Route::get('/resepsionis/antrean/tambah', [AntreanController::class, 'create'])->name('resepsionis.antrean.create');
    Route::post('/resepsionis/antrean', [AntreanController::class, 'store'])->name('resepsionis.antrean.store');
    Route::delete('/resepsionis/antrean/{id}', [AntreanController::class, 'destroy'])->name('resepsionis.antrean.destroy');
});


// ==========================================
// 3. AREA KHUSUS DOKTER (Pakai Gembok 'role:dokter')
// ==========================================
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dokter/antrean', [DokterController::class, 'antrean'])->name('dokter.antrean');
    Route::put('/dokter/antrean/{id}/panggil', [DokterController::class, 'panggil'])->name('dokter.antrean.panggil');
    
    Route::get('/dokter/rekam-medis', [RekamMedisController::class, 'index'])->name('dokter.rekammedis');
    Route::get('/dokter/rekam-medis/{id_antrean}/isi', [RekamMedisController::class, 'create'])->name('dokter.rekammedis.create');
    Route::post('/dokter/rekam-medis/{id_antrean}', [RekamMedisController::class, 'store'])->name('dokter.rekammedis.store');
    Route::get('/dokter/rekam-medis/detail/{id_rm}', [RekamMedisController::class, 'show'])->name('dokter.rekammedis.show');
});


// ==========================================
// 4. AREA UMUM (Semua role bisa edit profil)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';