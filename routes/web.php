<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasienController;

Route::resource('antrean', AntreanController::class)->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role; // Cek rolenya apa di database

    if ($role == 'admin') {
        return view('admin.dashboard');
    } elseif ($role == 'resepsionis') {
        return view('resepsionis.dashboard'); // Belum dibikin, biarin aja dulu
    } elseif ($role == 'dokter') {
        return view('dokter.dashboard'); // Belum dibikin, biarin aja dulu
    }

    // Kalau rolenya ga jelas, lempar ke dashboard default
    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
