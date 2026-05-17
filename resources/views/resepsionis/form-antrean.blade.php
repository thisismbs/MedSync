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
                        
                        <div x-data="{
                            open: false,
                            search: '',
                            selectedId: '',
                            selectedName: '-- Cari / Pilih Pasien --',
                            items: [
                                @foreach($pasiens as $pas)
                                    { id: '{{ $pas->id_pasien }}', name: '{{ addslashes($pas->nama) }} - {{ $pas->no_hp }}' },
                                @endforeach
                            ],
                            get filteredItems() {
                                if (this.search === '') return this.items;
                                return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            selectItem(item) {
                                this.selectedId = item.id;
                                this.selectedName = item.name;
                                this.open = false;
                            }
                        }" @click.away="open = false" class="relative"> <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Pasien</label>
                            
                            <input type="hidden" name="id_pasien" :value="selectedId" required>
                            
                            <div @click="open = !open" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer flex justify-between items-center focus:ring-2 focus:ring-teal-500">
                                <span x-text="selectedName" :class="selectedId === '' ? 'text-gray-500' : 'text-gray-800'" class="truncate"></span>
                                <i class="fa-solid fa-chevron-down text-gray-400"></i>
                            </div>

                            <div x-show="open" x-transition class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <div class="p-2 sticky top-0 bg-white border-b">
                                    <input type="text" x-model="search" placeholder="Ketik nama pasien..." class="w-full px-3 py-1.5 border border-gray-200 rounded focus:outline-none focus:border-teal-500 text-sm">
                                </div>
                                <ul>
                                    <template x-for="item in filteredItems" :key="item.id">
                                        <li @click="selectItem(item)" class="px-4 py-2 hover:bg-teal-50 cursor-pointer text-sm text-gray-700 transition-colors" x-text="item.name"></li>
                                    </template>
                                    <li x-show="filteredItems.length === 0" class="px-4 py-2 text-sm text-gray-500 text-center">Data tidak ditemukan</li>
                                </ul>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">*Jika pasien belum ada, ke menu Data Pasien.</p>
                        </div>

                        <div x-data="{
                            open: false,
                            search: '',
                            selectedId: '',
                            selectedName: '-- Cari / Pilih Dokter --',
                            items: [
                                @foreach($dokters as $dok)
                                    { id: '{{ $dok->id_dokter }}', name: 'Dr. {{ addslashes($dok->nama) }}' },
                                @endforeach
                            ],
                            get filteredItems() {
                                if (this.search === '') return this.items;
                                return this.items.filter(item => item.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            selectItem(item) {
                                this.selectedId = item.id;
                                this.selectedName = item.name;
                                this.open = false;
                            }
                        }" @click.away="open = false" class="relative"> <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Dokter Tujuan</label>
                            
                            <input type="hidden" name="id_dokter" :value="selectedId" required>
                            
                            <div @click="open = !open" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer flex justify-between items-center focus:ring-2 focus:ring-teal-500">
                                <span x-text="selectedName" :class="selectedId === '' ? 'text-gray-500' : 'text-gray-800'" class="truncate"></span>
                                <i class="fa-solid fa-chevron-down text-gray-400"></i>
                            </div>

                            <div x-show="open" x-transition class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <div class="p-2 sticky top-0 bg-white border-b">
                                    <input type="text" x-model="search" placeholder="Ketik nama dokter..." class="w-full px-3 py-1.5 border border-gray-200 rounded focus:outline-none focus:border-teal-500 text-sm">
                                </div>
                                <ul>
                                    <template x-for="item in filteredItems" :key="item.id">
                                        <li @click="selectItem(item)" class="px-4 py-2 hover:bg-teal-50 cursor-pointer text-sm text-gray-700 transition-colors" x-text="item.name"></li>
                                    </template>
                                    <li x-show="filteredItems.length === 0" class="px-4 py-2 text-sm text-gray-500 text-center">Data tidak ditemukan</li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Antrean</label>
                            <div class="relative">
                                <i class="fa-regular fa-calendar absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 font-medium cursor-not-allowed focus:outline-none" value="{{ \Carbon\Carbon::today()->format('d-m-Y') }}" readonly>
                            </div>
                        </div>
                        
                        <input type="hidden" name="status" value="Menunggu">
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