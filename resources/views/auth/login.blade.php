<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSync - Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 flex h-screen items-center justify-center text-gray-800">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        
        <div class="bg-teal-800 px-8 py-10 text-center flex flex-col items-center">
            
            <i class="fa-solid fa-house-medical fa-3x mb-4 text-teal-300"></i>
            
            <h1 class="text-4xl font-bold text-white tracking-wider flex justify-center items-center">
                MedSync
            </h1>
            <p class="text-teal-200 mt-2 text-sm">Sistem Informasi Klinik</p>
        </div>

        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Masuk ke Akun Anda</h2>
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-start">
                    <i class="fa-solid fa-circle-exclamation mt-0.5 mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors" required autofocus>
                    </div>
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" placeholder="••••••••" 
                            class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors" required>
                        
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-teal-600 focus:outline-none">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-lg transition-colors shadow-md hover:shadow-lg mt-4 flex justify-center items-center">
                    MASUK <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                </button>
            </form>

        </div>
    </div>

</body>
</html>