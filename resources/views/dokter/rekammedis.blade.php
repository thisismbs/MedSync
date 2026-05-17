<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Riwayat Medis (Dokter)</title>
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
        <div class="p-4 border-t border-teal-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-4 py-2 text-center bg-red-500 hover:bg-red-600 rounded-lg transition-colors text-white">
                    <i class="fa-solid fa-sign-out-alt mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto">
        <header class="bg-white shadow-sm px-4 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-700">Data Riwayat Rekam Medis</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium hidden sm:block">Halo, Dr. {{ Auth::user()->nama }}</span>
                <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 font-bold border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0">
                    <p class="text-gray-600">Cari riwayat pemeriksaan pasien sebelumnya.</p>
                    <form action="{{ route('dokter.rekammedis') }}" method="GET" class="relative w-full sm:w-72 flex">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama pasien / diagnosa..." class="w-full border border-gray-300 rounded-l-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400"></i>
                        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-r-lg hover:bg-teal-700 transition-colors">Cari</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-sm uppercase">
                                <th class="p-4 w-16">No.</th>
                                <th class="p-4">Tanggal Periksa</th>
                                <th class="p-4">Nama Pasien</th>
                                <th class="p-4">Keluhan Utama</th>
                                <th class="p-4">Diagnosa</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($riwayats as $index => $riwayat)
                            
                            @php
                                $parts = explode(' | Diagnosa: ', str_replace('Keluhan: ', '', $riwayat->diagnosa));
                                $keluhanText = $parts[0] ?? '-';
                                $diagnosaText = $parts[1] ?? $riwayat->diagnosa;
                            @endphp

                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-4 text-gray-500 font-medium">{{ $riwayats->firstItem() + $index }}</td>
                                <td class="p-4 font-semibold text-gray-700">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d M Y') }}</td>
                                <td class="p-4 font-bold text-teal-700">{{ optional($riwayat->pasien)->nama }}</td>
                                <td class="p-4 text-gray-600 truncate max-w-xs" title="{{ $keluhanText }}">{{ \Illuminate\Support\Str::limit($keluhanText, 40) }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded-full text-xs font-semibold">
                                        {{ $diagnosaText }}
                                    </span>
                                </td>
                                <td class="p-4 flex justify-center space-x-2">
                                    <a href="{{ route('dokter.rekammedis.show', $riwayat->id_rekam) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-xs transition-colors shadow-sm" title="Lihat Detail Resep & Tindakan">
                                        <i class="fa-solid fa-eye mr-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Belum ada riwayat rekam medis pasien.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 border-t pt-4">
                    {{ $riwayats->links() }}
                </div>
                
            </div>
        </div>
    </main>

</body>
</html>