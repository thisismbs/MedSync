<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Antrean Pasien
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Munculin pesan sukses kalau antrean berhasil dibikin --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('antrean.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">ID Pasien:</label>
                        <input type="number" name="id_pasien" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 1">
                        <p class="text-xs text-red-500 mt-1">*Pastikan ID Pasien ini beneran ada di database phpMyAdmin</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">ID Dokter:</label>
                        <input type="number" name="id_dokter" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Contoh: 1">
                        <p class="text-xs text-red-500 mt-1">*Pastikan ID Dokter ini beneran ada di database phpMyAdmin</p>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Daftar Antrean
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>