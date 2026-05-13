<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien; // <--- Ini kunci biar nggak "Class Not Found"

class PasienController extends Controller
{
    // TAMPILIN DAFTAR PASIEN
    public function index(Request $request)
    {
        $search = $request->search;

        $pasiens = Pasien::when($search, function($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        // Cek siapa yang login biar view-nya nggak nyasar
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

    // SIMPAN DATA KE DATABASE
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        Pasien::create($request->all());

        // Lempar balik ke rute yang bener
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

    // UPDATE DATA DI DATABASE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required'
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

        return redirect()->back()->with('success', 'Data pasien berhasil dihapus!');
    }
}