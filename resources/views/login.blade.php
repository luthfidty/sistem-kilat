<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col font-sans relative bg-gray-900" 
      style="background-image: url('https://images.unsplash.com/photo-1588614959060-4d144f28b207?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;">
    
    <!-- Dark overlay agar teks tetap terbaca -->
    <div class="absolute inset-0 bg-black/50 z-0"></div>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center p-6 lg:p-12 z-10 relative">
        
        <!-- Wadah Flex Kiri Kanan -->
        <div class="w-full max-w-6xl flex flex-col md:flex-row items-center justify-between gap-12">
            
            <!-- Sisi Kiri: Teks -->
            <div class="md:w-1/2 text-left text-white drop-shadow-lg">
                <h1 class="text-6xl font-extrabold mb-3 tracking-tight">KILAT</h1>
                <h2 class="text-xl font-semibold mb-5 text-gray-200">Sistem Informasi Geotagging & Pantauan<br>Transmigrasi</h2>
                
                <!-- Garis Pemisah Putih -->
                <div class="w-12 h-1 bg-white mb-6 rounded-full opacity-80"></div>
                
                <p class="text-gray-300 text-[15px] leading-relaxed max-w-md font-medium">
                    Platform terintegrasi Unit Kerja Eselon 1, PPKTrans,<br>
                    dan PEMT untuk pemantauan pekerjaan fisik secara<br>
                    presisi.
                </p>
            </div>

            <!-- Sisi Kanan: Card Form Login -->
            <!-- BAGIAN YANG DIEDIT: max-w-[640px] dan px-16 -->
            <div class="md:w-auto w-full flex justify-center">
                <div class="bg-gray-50 px-16 py-14 rounded-[20px] shadow-2xl w-full max-w-[640px] text-center border border-gray-200">
                    
                    <!-- Logo BPK RI -->
                    <img src="{{ asset('KILAT.png') }}" class="w-[240px] h-auto mx-auto mb-8 object-contain drop-shadow-sm" alt="Logo BPK RI">
                    
                    <!-- Judul Card -->
                    <h3 class="text-[22px] font-extrabold text-black mb-10 tracking-wide">KILAT KEMENTRANS</h3>
                    
                    <form action="{{ route('login.post') }}" method="POST" class="text-left">
                        @csrf
                        
                        <!-- Notifikasi Error jika Username/Password Salah -->
                        @if($errors->any())
                            <div class="mb-5 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px] font-bold rounded-r shadow-sm">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        
                        <div class="mb-6">
                            <label class="block text-black text-[13px] font-bold mb-2.5" for="username">
                                Username
                            </label>
                            <!-- Input Field (Ditambahkan name="username", value, dan required) -->
                            <input name="username" value="{{ old('username') }}" class="w-full px-5 py-4 rounded-md border border-gray-200 text-gray-800 placeholder-gray-400 focus:border-gray-500 focus:ring-1 focus:ring-gray-500 focus:outline-none transition-colors bg-white shadow-sm text-sm" id="username" type="text" placeholder="Enter Username" required>
                        </div>
                        
                        <div class="mb-8">
                            <label class="block text-black text-[13px] font-bold mb-2.5" for="password">
                                Password
                            </label>
                            <!-- Input Field (Ditambahkan name="password" dan required) -->
                            <input name="password" class="w-full px-5 py-4 rounded-md border border-gray-200 text-gray-800 placeholder-gray-400 focus:border-gray-500 focus:ring-1 focus:ring-gray-500 focus:outline-none transition-colors bg-white shadow-sm text-sm" id="password" type="password" placeholder="Enter Password" required>
                        </div>
                        
                        <div class="flex items-center mb-10">
                            <label class="flex items-center cursor-pointer group">
                                <!-- Checkbox (Ditambahkan name="remember") -->
                                <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-gray-800 border-gray-300 rounded bg-white focus:ring-gray-800 shadow-sm">
                                <span class="ml-2 text-[13px] text-black font-bold group-hover:text-gray-700 transition-colors">Remember me</span>
                            </label>
                        </div>
                        
                        <!-- Tombol Sign In -->
                        <button class="bg-[#1f2328] hover:bg-black text-white font-bold py-3 px-10 rounded-full transition-colors shadow-md text-sm tracking-wide w-auto mx-auto inline-block" type="submit">
                            Sign In
                        </button>
                        
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Memanggil Footer -->
    @include('layouts.footer')

</body>
</html>