<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Form Antrean (Resepsionis)</title>
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
            <p class="text-teal-200 text-sm mt-1">Peran: Resepsionis</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-chart-pie mr-3 w-5"></i> Dasbor
            </a>
            <a href="{{ route('resepsionis.pasien') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-hospital-user mr-3 w-5"></i> Data Pasien
            </a>
            <a href="{{ route('resepsionis.antrean') }}" class="block px-4 py-3 rounded-lg bg-teal-900 text-white font-semibold transition-colors">
                <i class="fa-solid fa-clipboard-list mr-3 w-5"></i> Kelola Antrean
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto">
        <header class="bg-white shadow-sm px-4 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-2">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <a href="{{ route('resepsionis.antrean') }}" class="text-gray-500 hover:text-teal-600 transition-colors">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-700">Formulir Pendaftaran Antrean</h2>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <div class="bg-white rounded-xl shadow-md p-6 lg:p-8 max-w-3xl mx-auto">
                
                @if(session('error'))
                    <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 font-bold border border-red-200">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i> {{ session('error') }}
                    </div>
                @endif

                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Informasi Antrean Periksa</h3>
                
                <form action="{{ route('resepsionis.antrean.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Pasien</label>
                            <select name="id_pasien" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none bg-white" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasiens as $pas)
                                    <option value="{{ $pas->id_pasien }}">{{ $pas->nama }} - {{ $pas->no_hp }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">*Jika pasien belum terdaftar, silakan ke menu Data Pasien.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Dokter Tujuan</label>
                            <select name="id_dokter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none bg-white" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokters as $dok)
                                    <option value="{{ $dok->id_dokter }}">Dr. {{ $dok->nama }} (Spesialis: {{ $dok->spesialisasi }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Antrean</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none" value="HARI INI" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Antrean</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-semibold cursor-not-allowed focus:outline-none" value="Menunggu" readonly>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t flex justify-end space-x-3">
                        <a href="{{ route('resepsionis.antrean') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium shadow-sm">
                            Simpan Antrean
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>

</body>
</html>