<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Dasbor (Resepsionis)</title>
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
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg bg-teal-900 text-white font-semibold transition-colors">
                <i class="fa-solid fa-chart-pie mr-3 w-5"></i> Dasbor
            </a>
            <a href="{{ route('resepsionis.pasien') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-hospital-user mr-3 w-5"></i> Data Pasien
            </a>
            <a href="{{ route('resepsionis.antrean') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
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
                <h2 class="text-xl font-semibold text-gray-700">Dasbor Resepsionis</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium hidden sm:block">Halo, {{ Auth::user()->nama }}</span>
                <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6 flex items-center">
                    <div class="p-4 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase">Total Pasien Klinik</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Pasien::count() }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 flex items-center">
                    <div class="p-4 rounded-full bg-emerald-100 text-emerald-500 mr-4">
                        <i class="fa-solid fa-clipboard-list fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase">Antrean Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Antrean::whereDate('created_at', \Carbon\Carbon::today())->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                 <h3 class="text-lg font-semibold text-gray-700 mb-4">Pemberitahuan Sistem</h3>
                 <p class="text-gray-600">Selamat datang di MedSync. Silakan gunakan menu <b>Data Pasien</b> untuk mengelola identitas pasien, atau <b>Kelola Antrean</b> untuk mengatur pendaftaran pasien ke ruang periksa.</p>
            </div>
        </div>
    </main>

</body>
</html>