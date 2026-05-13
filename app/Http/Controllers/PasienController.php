<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // Panggil model Pasien

class PasienController extends Controller
{
    // TAMPILIN DATA & SEARCH
    public function index(Request $request)
    {
        $search = $request->search;
        
        // Cari berdasarkan nama atau no HP
        $pasiens = Pasien::when($search, function($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('no_hp', 'like', "%{$search}%");
        })->get();

        // Cek Role buat nentuin view mana yang dibuka
        if (auth()->user()->role == 'admin') {
            return view('admin.kelola-pasien', compact('pasiens', 'search'));
        } else {
            return view('resepsionis.kelola-pasien', compact('pasiens', 'search'));
        }
    }

    // TAMPILIN FORM TAMBAH
    public function create()
    {
        if (auth()->user()->role == 'admin') {
            return view('admin.form-pasien');
        } else {
            return view('resepsionis.form-pasien');
        }
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'tgl_lahir' => 'required|date'
        ]);

        Pasien::create($request->all());

        // Cek Role buat nentuin redirect rutenya ke mana abis nge-save
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil ditambahkan!');
        } else {
            return redirect()->route('resepsionis.pasien')->with('success', 'Data pasien berhasil ditambahkan!');
        }
    }

    // TAMPILIN FORM EDIT
    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        
        if (auth()->user()->role == 'admin') {
            return view('admin.form-pasien', compact('pasien'));
        } else {
            return view('resepsionis.form-pasien', compact('pasien'));
        }
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'tgl_lahir' => 'required|date'
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());

        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil diubah!');
        } else {
            return redirect()->route('resepsionis.pasien')->with('success', 'Data pasien berhasil diubah!');
        }
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.pasien')->with('success', 'Data pasien berhasil dihapus!');
        } else {
            return redirect()->route('resepsionis.pasien')->with('success', 'Data pasien berhasil dihapus!');
        }
    }
}