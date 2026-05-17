<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Form Rekam Medis (Dokter)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden" @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-teal-800 text-white lg:translate-x-0 lg:static lg:inset-0 flex flex-col">
        <div class="p-6 border-b border-teal-700 flex flex-col items-center">
            <i class="fa-solid fa-house-medical fa-3x mb-2 text-teal-300"></i>
            <h1 class="text-2xl font-bold tracking-wider">MedSync</h1>
            <p class="text-teal-200 text-sm mt-1">Peran: Dokter</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-chart-pie mr-3 w-5"></i> Dasbor
            </a>
            <a href="{{ route('dokter.antrean') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-clipboard-list mr-3 w-5"></i> Antrean Pasien
            </a>
            <a href="{{ route('dokter.rekammedis') }}" class="block px-4 py-3 rounded-lg bg-teal-900 text-white font-semibold transition-colors">
                <i class="fa-solid fa-notes-medical mr-3 w-5"></i> Rekam Medis
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto">
        <header class="bg-white shadow-sm px-4 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-2">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <a href="{{ route('dokter.antrean') }}" class="text-gray-500 hover:text-teal-600 transition-colors">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-700">Formulir Laporan Medis</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium hidden sm:block">Halo, Dr. {{ Auth::user()->nama }}</span>
                <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <div class="bg-white rounded-xl shadow-md p-6 lg:p-8 max-w-4xl mx-auto">
                
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div class="mb-4 sm:mb-0">
                        <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">ID Antrean: #{{ str_pad($antrean->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</p>
                        <h3 class="text-xl font-bold text-blue-900">{{ optional($antrean->pasien)->nama }}</h3>
                        <p class="text-sm text-blue-700 mt-1"><i class="fa-solid fa-id-card mr-2"></i>Tgl Lahir: {{ \Carbon\Carbon::parse(optional($antrean->pasien)->tgl_lahir)->format('d F Y') }}</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm text-blue-800 font-medium">Tanggal Pemeriksaan:</p>
                        <p class="text-lg font-bold text-blue-900">{{ \Carbon\Carbon::today()->format('d F Y') }}</p>
                    </div>
                </div>
                
                <form action="{{ route('dokter.rekammedis.store', $antrean->id_antrean) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan Utama</label>
                            <textarea name="keluhan" rows="3" placeholder="Deskripsikan keluhan pasien..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diagnosa Penyakit</label>
                            <input type="text" name="diagnosa" placeholder="Contoh: Influenza" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Resep Obat & Tindakan Medis</label>
                            <textarea name="resep_tindakan" rows="4" placeholder="1. Paracetamol 500mg (3x1)&#10;2. Vitamin C (1x1)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" required></textarea>
                            <p class="text-xs text-gray-500 mt-1">*Pisahkan setiap nama obat dengan nomor atau baris baru agar rapi saat dicetak.</p>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t flex flex-col-reverse sm:flex-row justify-between items-center">
                        <p class="text-sm text-gray-500 italic mt-4 sm:mt-0 text-center sm:text-left"><i class="fa-solid fa-circle-info mr-1"></i>Menyimpan data ini otomatis mengubah status antrean menjadi <strong>Selesai</strong>.</p>
                        <div class="flex space-x-3 w-full sm:w-auto justify-end">
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