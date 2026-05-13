<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Form Akun (Admin)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800" x-data="{ role: '{{ isset($user) ? $user->role : '' }}', showPassword: false }">

    <aside class="w-64 bg-teal-800 text-white flex flex-col hidden lg:flex">
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
    </aside>

    <main class="flex-1 flex flex-col relative h-screen overflow-y-auto">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.kelola-akun') }}" class="text-gray-500 hover:text-teal-600 transition-colors">
                    <i class="fa-solid fa-arrow-left fa-lg"></i>
                </a>
                <h2 class="text-xl font-semibold text-gray-700">{{ isset($user) ? 'Ubah Akun Pengguna' : 'Tambah Akun Baru' }}</h2>
            </div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-3xl mx-auto">
                
                <form action="{{ isset($user) ? route('admin.akun.update', $user->id_user) : route('admin.akun.store') }}" method="POST" class="space-y-8">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. Data Autentikasi (Sistem)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email (Username)</label>
                                <input type="email" name="email" value="{{ $user->email ?? '' }}" required placeholder="contoh@medsync.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password" {{ isset($user) ? '' : 'required' }} placeholder="{{ isset($user) ? 'Kosongkan jika tidak diubah' : 'Masukkan kata sandi...' }}" class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
                                    
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-teal-600 focus:outline-none">
                                        <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peran (Role)</label>
                            <select name="role" x-model="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none bg-gray-50">
                                <option value="" disabled {{ !isset($user) ? 'selected' : '' }}>-- Pilih Peran --</option>
                                <option value="admin">Administrator</option>
                                <option value="resepsionis">Resepsionis</option>
                                <option value="dokter">Dokter</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">2. Profil Pengguna</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ $user->nama ?? '' }}" required placeholder="Masukkan nama lengkap..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="spesialisasi" value="Poli Umum">

                    <div class="pt-6 mt-6 border-t flex justify-end space-x-3">
                        <a href="{{ route('admin.kelola-akun') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium shadow-sm">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>
</body>
</html>