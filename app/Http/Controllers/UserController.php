<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokter; // Panggil model Dokter

class UserController extends Controller
{
    // TAMPILIN DATA & SEARCH
    public function index(Request $request)
    {
        $search = $request->search;
        
        // Kalau ada pencarian, filter datanya. Kalau nggak ada, tampilin semua.
        $users = User::when($search, function($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->get();

        return view('admin.kelola-akun', compact('users', 'search'));
    }

    // TAMPILIN FORM TAMBAH
    public function create()
    {
        return view('admin.form-akun');
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => strtolower($request->role),
        ]);

        // Kalau rolenya Dokter, otomatis masukin ke tabel dokter
        if (strtolower($request->role) == 'dokter') {
            Dokter::create([
                'id_user' => $user->id_user,
                'spesialisasi' => $request->spesialisasi ?? 'Poli Umum'
            ]);
        }

        return redirect()->route('admin.kelola-akun')->with('success', 'Akun berhasil ditambahkan!');
    }

    // TAMPILIN FORM EDIT
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $dokter = Dokter::where('id_user', $id)->first(); // Cari spesialisasi kalau dia dokter
        
        return view('admin.form-akun', compact('user', 'dokter'));
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => strtolower($request->role),
        ]);

        // Cuma update password kalau diisi
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        // Urus tabel dokter
        if (strtolower($request->role) == 'dokter') {
            Dokter::updateOrCreate(
                ['id_user' => $user->id_user],
                ['spesialisasi' => $request->spesialisasi ?? 'Poli Umum']
            );
        } else {
            // Kalau tadinya dokter tapi diubah jadi admin/resepsionis, hapus data dokternya
            Dokter::where('id_user', $user->id_user)->delete();
        }

        return redirect()->route('admin.kelola-akun')->with('success', 'Data akun berhasil diubah!');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Ini otomatis bakal ngehapus data di tabel dokter juga karena kita pakai Foreign Key Cascade

        return redirect()->route('admin.kelola-akun')->with('success', 'Akun berhasil dihapus!');
    }
}