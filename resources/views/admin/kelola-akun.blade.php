<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Kelola Akun (Admin)</title>
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
            <p class="text-teal-200 text-sm mt-1">Peran: Administrator</p>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-chart-pie mr-3 w-5"></i> Dasbor
            </a>
            <a href="{{ route('admin.kelola-akun') }}" class="block px-4 py-3 rounded-lg bg-teal-900 text-white font-semibold transition-colors">
                <i class="fa-solid fa-users-cog mr-3 w-5"></i> Kelola Akun
            </a>
            <a href="{{ route('admin.pasien') }}" class="block px-4 py-3 rounded-lg hover:bg-teal-700 transition-colors">
                <i class="fa-solid fa-hospital-user mr-3 w-5"></i> Data Pasien
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
                <h2 class="text-xl font-semibold text-gray-700">Kelola Akun Pengguna</h2>
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
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0">
    <a href="{{ route('admin.akun.create') }}" class="w-full sm:w-auto bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
        + Tambah Akun
    </a>
    
    <form action="{{ route('admin.kelola-akun') }}" method="GET" class="relative w-full sm:w-auto flex">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama/email..." class="w-full sm:w-auto border border-gray-300 rounded-l-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500">
        <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400"></i>
        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-r-lg hover:bg-teal-700">Cari</button>
    </form>
</div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50 text-gray-600 text-sm uppercase">
                                <th class="p-4 w-16">No.</th>
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">Peran</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($users as $index => $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-4 text-gray-500 font-medium">{{ $index + 1 }}</td>
                                <td class="p-4 font-semibold text-gray-800">{{ $user->nama }}</td>
                                <td class="p-4">{{ $user->email }}</td>
                                <td class="p-4">
                                    @if($user->role == 'admin')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs font-semibold">Admin</span>
                                    @elseif($user->role == 'dokter')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">Dokter</span>
                                    @else
                                        <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-semibold">Resepsionis</span>
                                    @endif
                                </td>
                                <td class="p-4 flex justify-center space-x-2">
    <a href="{{ route('admin.akun.edit', $user->id_user) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition-colors">Ubah</a>
    
    @if($user->role != 'admin')
    <form action="{{ route('admin.akun.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin mau hapus akun ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors">Hapus</button>
    </form>
    @endif
</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-end">
                    <span class="text-sm text-gray-500">Menampilkan total {{ $users->count() }} data</span>
                </div>
            </div>
        </div>
    </main>

</body>
</html>