<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Detail Rekam Medis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        @media print {
            body { background-color: white !important; }
            .print-hide { display: none !important; }
            .print-content { 
                box-shadow: none !important; 
                border: none !important; 
                padding: 0 !important; 
                max-width: 100% !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden print-hide" @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-teal-800 text-white lg:translate-x-0 lg:static lg:inset-0 flex flex-col print-hide">
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

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto print:overflow-visible">
        
        <header class="bg-white shadow-sm px-4 lg:px-8 py-4 flex justify-between items-center print-hide">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-2">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <a href="{{ route('dokter.rekammedis') }}" class="text-gray-500 hover:text-teal-600 transition-colors">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-700">Rincian Rekam Medis</h2>
            </div>
        </header>

        <div class="p-4 lg:p-8 print:p-0">
            <div class="bg-white rounded-xl shadow-md p-6 lg:p-8 max-w-4xl mx-auto border-t-4 border-teal-600 print-content print:border-t-0">
                
                <div class="hidden print:block text-center border-b-2 border-gray-800 pb-4 mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-widest uppercase">KLINIK MEDSYNC</h1>
                    <p class="text-sm text-gray-600 mt-1">Jl. Kesehatan No. 123, Semarang, Jawa Tengah</p>
                    <p class="text-sm text-gray-600">Telp: (021) 1234567 | Email: info@medsync.com</p>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-start border-b-2 border-gray-100 pb-6 mb-6">
                    <div class="mb-4 sm:mb-0">
                        <h3 class="text-2xl font-bold text-gray-800">Laporan Rekam Medis</h3>
                        <p class="text-sm text-gray-500 mt-1">ID Pemeriksaan: #RM-{{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('Ymd') }}-{{ str_pad($rekamMedis->id_rekam, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm text-gray-500 font-medium">Tanggal Pemeriksaan</p>
                        <p class="text-lg font-bold text-teal-700">{{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d F Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 print:bg-white print:border-gray-800">
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2 print:text-gray-800">Data Pasien</p>
                        <h4 class="text-lg font-bold text-gray-800">{{ optional($rekamMedis->pasien)->nama }}</h4>
                        <p class="text-sm text-gray-600 mt-1"><i class="fa-solid fa-phone mr-2 w-4 print:hidden"></i>No HP: {{ optional($rekamMedis->pasien)->no_hp }}</p>
                        <p class="text-sm text-gray-600 mt-1"><i class="fa-solid fa-id-card mr-2 w-4 print:hidden"></i>Lahir: {{ \Carbon\Carbon::parse(optional($rekamMedis->pasien)->tgl_lahir)->format('d F Y') }}</p>
                    </div>
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 print:bg-white print:border-gray-800">
                        <p class="text-xs text-blue-500 font-bold uppercase tracking-wider mb-2 print:text-gray-800">Dokter Pemeriksa</p>
                        <h4 class="text-lg font-bold text-blue-900 print:text-gray-800">Dr. {{ optional(optional($rekamMedis->dokter)->user)->nama }}</h4>
                        <p class="text-sm text-blue-700 mt-1 print:text-gray-600"><i class="fa-solid fa-user-doctor mr-2 w-4 print:hidden"></i>Poli Umum</p>
                    </div>
                </div>

                @php
                    $parts = explode(' | Diagnosa: ', str_replace('Keluhan: ', '', $rekamMedis->diagnosa));
                    $keluhanText = $parts[0] ?? '-';
                    $diagnosaText = $parts[1] ?? $rekamMedis->diagnosa;
                @endphp

                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 uppercase border-b pb-2 mb-3 print:border-gray-800">Keluhan Utama</h4>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 text-gray-700 text-sm leading-relaxed print:border-none print:p-0">
                            {{ $keluhanText }}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 uppercase border-b pb-2 mb-3 print:border-gray-800">Diagnosa</h4>
                        <div class="inline-block px-4 py-2 bg-red-50 border border-red-200 text-red-700 font-bold rounded-lg print:bg-white print:border-none print:text-gray-900 print:p-0">
                            {{ $diagnosaText }}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 uppercase border-b pb-2 mb-3 print:border-gray-800">Resep Obat & Tindakan</h4>
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-gray-800 text-sm leading-relaxed whitespace-pre-wrap print:bg-white print:border-none print:p-0">{{ $rekamMedis->tindakan }}</div>
                    </div>
                </div>

                <div class="hidden print:flex justify-end mt-16 pt-8">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-16">Dokter Pemeriksa,</p>
                        <p class="text-md font-bold text-gray-800 border-b border-gray-800 pb-1 inline-block px-4">Dr. {{ optional(optional($rekamMedis->dokter)->user)->nama }}</p>
                        <p class="text-xs text-gray-500 mt-1">SIP: -</p>
                    </div>
                </div>

                <div class="pt-8 mt-8 border-t border-gray-200 flex justify-end space-x-3 print-hide">
                    <button type="button" onclick="window.print()" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium shadow-sm flex items-center">
                        <i class="fa-solid fa-print mr-2"></i> Cetak Dokumen
                    </button>
                    <a href="{{ route('dokter.rekammedis') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>