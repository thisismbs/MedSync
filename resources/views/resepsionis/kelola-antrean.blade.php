<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Kelola Antrean (Resepsionis)</title>
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
        <div class="p-4 border-t border-teal-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-center bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                    <i class="fa-solid fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto">
        <header class="bg-white shadow-sm px-4 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-700">Kelola Antrean Pasien Hari Ini</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium hidden sm:block">Halo, {{ Auth::user()->nama }}</span>
                <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 font-bold">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('resepsionis.antrean.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-block">
                        + Tambah Antrean
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-sm uppercase">
                                <th class="p-4 w-16">No.</th>
                                <th class="p-4">Nama Pasien</th>
                                <th class="p-4">Dokter Tujuan</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($antreans as $antrean)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-4 text-gray-500 font-medium">{{ $antrean->nomor_antrean }}</td>
                                <td class="p-4 font-semibold text-gray-800">{{ optional($antrean->pasien)->nama ?? 'Pasien Dihapus' }}</td>
                                <td class="p-4">Dr. {{ optional(optional($antrean->dokter)->user)->nama ?? 'Dokter Dihapus' }}</td>
                                <td class="p-4 text-center">
                                    @if($antrean->status == 'Selesai')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Selesai</span>
                                    @elseif($antrean->status == 'Diperiksa')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Diperiksa</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu</span>
                                    @endif
                                </td>
                                <td class="p-4 flex justify-center space-x-2">
                                    @if($antrean->status == 'Menunggu')
                                    <form action="{{ route('resepsionis.antrean.destroy', $antrean->id_antrean) }}" method="POST" onsubmit="return confirm('Yakin batalkan antrean ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors" title="Batalkan Antrean">
                                            <i class="fa-solid fa-xmark mr-1"></i> Batal
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-gray-400 text-xs italic">- Tidak ada aksi -</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Belum ada antrean untuk hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>