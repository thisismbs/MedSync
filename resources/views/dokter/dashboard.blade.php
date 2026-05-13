<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Dasbor (Dokter)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-teal-800 text-white flex flex-col">
        <div class="p-6 border-b border-teal-700 flex flex-col items-center">
            <i class="fa-solid fa-house-medical fa-3x mb-2 text-teal-300"></i>
            <h1 class="text-2xl font-bold tracking-wider">MedSync</h1>
            <p class="text-teal-200 text-sm mt-1">Peran: Dokter</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg bg-teal-900 text-white font-semibold transition-colors">
                <i class="fa-solid fa-chart-pie mr-3 w-5"></i> Dasbor
            </a>
            <a href="{{ route('dokter.antrean') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-clipboard-list mr-3 w-5"></i> Antrean Pasien
            </a>
            <a href="{{ route('dokter.rekammedis') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-notes-medical mr-3 w-5"></i> Rekam Medis
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
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-700">Dasbor Dokter</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium">Halo, Dr. {{ Auth::user()->nama }}</span>
                <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 flex items-center border-l-4 border-blue-500">
                    <div class="p-4 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase">Total Pasien Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalPasien }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 flex items-center border-l-4 border-yellow-500">
                    <div class="p-4 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <i class="fa-solid fa-hourglass-half fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase">Menunggu Diperiksa</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $menunggu }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 flex items-center border-l-4 border-emerald-500">
                    <div class="p-4 rounded-full bg-emerald-100 text-emerald-500 mr-4">
                        <i class="fa-solid fa-check-double fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium uppercase">Selesai Diperiksa</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $selesai }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Jadwal & Informasi</h3>
                <p class="text-gray-600 mb-2">Selamat bekerja, Dr. {{ Auth::user()->nama }}. Spesialisasi Anda tercatat sebagai: <strong>{{ optional($dokter)->spesialisasi }}</strong>.</p>
                <p class="text-gray-600">Silakan pantau menu <span class="font-semibold text-teal-600">Antrean Pasien</span> untuk memanggil pasien berikutnya ke ruangan Anda.</p>
            </div>
        </div>
    </main>
</body>
</html>