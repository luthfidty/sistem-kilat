@php
    $isDashboard = Request::is('dashboard') || Request::is('/');
@endphp

<header 
    @if($isDashboard)
        x-data="{ atTop: true }" 
        @scroll.window="atTop = (window.pageYOffset > 20) ? false : true"
        :class="atTop ? 'bg-transparent border-transparent shadow-none py-6' : 'bg-gray-800/90 backdrop-blur-xl border-b border-white/20 shadow-sm py-3'"
        class="w-full fixed top-0 z-[99999] transition-all duration-300"
    @else
        class="w-full sticky top-0 z-[99999] bg-gray-800/90 backdrop-blur-xl border-b border-white/20 shadow-sm py-3 transition-all duration-300"
    @endif
>
    <!-- PERBAIKAN DI SINI: Mengganti 'container mx-auto' menjadi 'w-full' -->
    <div class="w-full px-6 flex items-center justify-between">
        
        <!-- Sisi Kiri: Logo & Judul -->
        <a href="/dashboard" class="flex items-center gap-4 group cursor-pointer">
            <img src="https://id.wikipedia.org/wiki/Special:FilePath/BPK_insignia.svg" 
                 class="w-10 h-10 object-contain filter drop-shadow-lg transition-transform duration-300 group-hover:scale-110" alt="Logo">
                 
            <div class="text-white flex flex-col justify-center drop-shadow-md group-hover:opacity-90 transition-opacity">
                <span class="text-[10px] tracking-[0.25em] font-medium text-gray-200 uppercase leading-none mb-1">KILAT</span>
                <span class="text-sm font-extrabold tracking-[0.15em] uppercase leading-none">Kementrans</span>
            </div>
        </a>
        
        <!-- Sisi Kanan: Tombol Input & Profil User -->
        <div class="flex items-center gap-4 md:gap-6">
            
            <button type="button" onclick="openModalInput()" class="hidden md:flex items-center gap-2 bg-white/10 hover:bg-white/25 backdrop-blur-md border border-white/30 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-sm group cursor-pointer">
                <svg class="w-4 h-4 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                KILAT Input
            </button>
            
            <div class="h-8 w-px bg-white/30 hidden md:block"></div>

            <!-- AREA PROFIL -->
            <div class="relative">
                <button type="button" id="btn-profil" onclick="toggleProfileMenu(event)" class="flex items-center gap-3 focus:outline-none text-left group cursor-pointer relative z-[100000]">
                    <div class="hidden md:block text-right drop-shadow-md">
                        <!-- Memanggil kolom username dari tabel users -->
                        <p class="text-sm font-bold text-gray-100 leading-none mb-1 group-hover:text-white transition-colors">
                            {{ auth()->user()->username ?? 'Nama Pengguna' }}
                        </p>
                        <!-- Memanggil kolom nama_role dari relasi tabel role -->
                        <p class="text-[10px] text-gray-300 uppercase tracking-widest font-semibold">
                            Role: {{ auth()->user()->role->nama_role ?? 'Tidak ada role' }}
                        </p>
                    </div>
                    
                    <!-- Mengambil 2 huruf pertama dari username untuk inisial (Otomatis Kapital) -->
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md border border-white/40 flex items-center justify-center text-white font-bold text-sm shadow-[0_0_15px_rgba(255,255,255,0.15)] group-hover:bg-white/30 transition-colors pointer-events-none">
                        {{ strtoupper(substr(auth()->user()->username ?? 'US', 0, 2)) }}
                    </div>
                    
                    <svg id="panah-profil" class="w-4 h-4 text-gray-200 transition-transform duration-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- Isi Dropdown Menu -->
                <div id="menu-profil" class="absolute right-0 mt-4 w-56 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-[100000] overflow-hidden transition-all duration-200 opacity-0 pointer-events-none translate-y-2">
                    
                    @php
                        $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
                    @endphp

                    <!-- JIKA ROLE ADALAH SUPERADMIN, TAMPILKAN MENU MANAJEMEN AKUN -->
                    @if($userRole === 'SUPERADMIN')
                        <a href="{{ route('manajemen-akun.index') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-gray-800 hover:bg-gray-50 font-bold transition-colors">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Manajemen Akun
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 font-extrabold transition-colors text-left cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</header>

<!-- MEMANGGIL FILE MODAL-INPUT.BLADE.PHP -->
@include('modal-input')

<!-- SCRIPT UNTUK MODAL DAN PROFIL -->
<script>
    function toggleProfileMenu(event) {
        event.stopPropagation(); 
        const menu = document.getElementById('menu-profil');
        const panah = document.getElementById('panah-profil');
        const isHidden = menu.classList.contains('opacity-0');
        
        if (isHidden) {
            menu.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-2');
            menu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
            panah.classList.add('rotate-180');
        } else {
            menu.classList.add('opacity-0', 'pointer-events-none', 'translate-y-2');
            menu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
            panah.classList.remove('rotate-180');
        }
    }

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('menu-profil');
        const btn = document.getElementById('btn-profil');
        const panah = document.getElementById('panah-profil');
        if (menu && btn && !btn.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('opacity-0', 'pointer-events-none', 'translate-y-2');
            menu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
            panah.classList.remove('rotate-180');
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const modalOverlay = document.getElementById('modalInputOverlay');
        const modalBox = document.getElementById('modalContent');

        if(modalOverlay && modalBox) {
            window.openModalInput = function() {
                modalOverlay.classList.remove('hidden');
                modalOverlay.classList.add('flex');
                setTimeout(() => {
                    modalOverlay.classList.remove('opacity-0');
                    modalBox.classList.remove('scale-95');
                    modalBox.classList.add('scale-100');
                }, 10);
            };

            window.closeModalInput = function() {
                modalOverlay.classList.add('opacity-0');
                modalBox.classList.remove('scale-100');
                modalBox.classList.add('scale-95');
                setTimeout(() => {
                    modalOverlay.classList.add('hidden');
                    modalOverlay.classList.remove('flex');
                }, 300);
            };

            modalOverlay.addEventListener('click', function(event) {
                if (event.target === modalOverlay) {
                    closeModalInput();
                }
            });
        }
    });
</script>