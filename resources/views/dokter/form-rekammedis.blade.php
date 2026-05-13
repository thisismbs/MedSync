<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Form Rekam Medis (Dokter)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-teal-800 text-white flex flex-col hidden lg:flex">
        <div class="p-6 border-b border-teal-700 flex flex-col items-center">
            <i class="fa-solid fa-house-medical fa-3x mb-2 text-teal-300"></i>
            <h1 class="text-2xl font-bold tracking-wider">MedSync</h1>
            <p class="text-teal-200 text-sm mt-1">Peran: Dokter</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-chart-pie mr-3 w-5"></i> Dasbor
            </a>
            <a href="{{ route('dokter.antrean') }}" class="block px-4 py-3 rounded-lg bg-teal-900 text-white font-semibold transition-colors">
                <i class="fa-solid fa-clipboard-list mr-3 w-5"></i> Antrean Pasien
            </a>
            <a href="{{ route('dokter.rekammedis') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-notes-medical mr-3 w-5"></i> Rekam Medis
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dokter.antrean') }}" class="text-gray-500 hover:text-teal-600 transition-colors">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-700">Formulir Pemeriksaan Medis</h2>
            </div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-4xl mx-auto">
                
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-8 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Pasien Saat Ini (No: {{ $antrean->nomor_antrean }})</p>
                        <h3 class="text-xl font-bold text-blue-900">{{ optional($antrean->pasien)->nama }}</h3>
                        <p class="text-sm text-blue-700 mt-1"><i class="fa-solid fa-cake-candles mr-2"></i>Lahir: {{ \Carbon\Carbon::parse(optional($antrean->pasien)->tgl_lahir)->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-blue-800 font-medium">Tanggal Pemeriksaan:</p>
                        <p class="text-lg font-bold text-blue-900">{{ \Carbon\Carbon::today()->format('d M Y') }}</p>
                    </div>
                </div>
                
                <form action="{{ route('dokter.rekammedis.store', $antrean->id_antrean) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan Utama</label>
                            <textarea name="keluhan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosa Penyakit</label>
                            <input type="text" name="diagnosa" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Resep Obat & Tindakan</label>
                            <textarea name="resep_tindakan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required></textarea>
                            <p class="text-xs text-gray-500 mt-1">*Pisahkan setiap nama obat dengan koma atau baris baru.</p>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t flex justify-between items-center">
                        <p class="text-sm text-gray-500 italic"><i class="fa-solid fa-circle-info mr-1"></i>Menyimpan data ini otomatis mengubah status antrean menjadi <strong>Selesai</strong>.</p>
                        <div class="flex space-x-3">
                            <a href="{{ route('dokter.antrean') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium shadow-sm flex items-center">
                                <i class="fa-solid fa-check mr-2"></i> Simpan & Selesaikan
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>

</body>
</html>