<!-- Hapus script JS onmouseenter/leave, dan pastikan ada class "peer" -->
<aside class="fixed inset-y-0 left-0 bg-[#1e293b] border-r border-[#2f3f56] text-white flex flex-col z-[99999] shadow-2xl transition-all duration-300 w-[72px] hover:w-64 group peer overflow-hidden">
    
    <div class="h-20 flex items-center px-4 border-b border-white/10 w-64 shrink-0">
        <!-- Logo menyesuaikan route aktif, bisa diarahkan ke / jika ada Dashboard Utama -->
        <a href="{{ url('/') }}" class="flex items-center cursor-pointer">
            <img src="https://id.wikipedia.org/wiki/Special:FilePath/BPK_insignia.svg" class="w-10 h-10 shrink-0 filter drop-shadow-md" alt="Logo">
            <div class="flex flex-col ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                <span class="text-[10px] tracking-[0.2em] font-medium text-gray-400 uppercase leading-none mb-1">KILAT</span>
                <span class="text-sm font-extrabold tracking-wider uppercase leading-none">Kementrans</span>
            </div>
        </a>
    </div>

    <!-- Navigasi Menu Kontekstual -->
    <nav class="flex-1 py-6 space-y-1.5 w-64 px-3 overflow-x-hidden overflow-y-auto custom-scrollbar">
        
        @php
            $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
            $isSuperadmin = ($userRole === 'SUPERADMIN');
            
            $rolesPpk = [
                'PPK TRANS',
                'SES DITJEN PPK TRANS',
                'DIT. PERENCANAAN PERWUJUDAN KAWASAN TRANSMIGRASI',
                'DIT. PEMBANGUNAN KAWASAN TRANSMIGRASI',
                'DIT. FASILITASI PENATAAN PERSEBARAN PENDUDUK DI KAWASAN TRANSMIGRASI',
                'DIT. PENGEMBANGAN SATUAN PERMUKIMAN DAN PUSAT SATUAN KAWASAN PENGEMBANGAN',
                'DIT. PENGEMBANGAN KAWASAN TRANSMIGRASI'
            ];

            $rolesPemt = [
                'PEMT',
                'SES. DITJEN PEMT',
                'DIT. PERENCANAAN TEKNIS PENGEMBANGAN EKONOMI DAN PEMBERDAYAAN MASYARAKAT TRANSMIGRASI',
                'DIT. PENGEMBANGAN PRODUK UNGGULAN TRANSMIGRASI',
                'DIT. PENGEMBANGAN KELEMBAGAAN EKONOMI TRANSMIGRASI',
                'DIT. PROMOSI DAN PEMASARAN PRODUK UNGGULAN TRANSMIGRASI',
                'DIT. PEMBERDAYAAN MASYARAKAT TRANSMIGRASI'
            ];

            $aksesPpk = $isSuperadmin || in_array($userRole, $rolesPpk);
            $aksesPemt = $isSuperadmin || in_array($userRole, $rolesPemt);
        @endphp

        <!-- MENU HOME UTAMA
        <a href="{{ url('/') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('/') || Request::is('dashboard') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            <svg class="w-6 h-6 shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
            <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Dashboard Utama</span>
        </a> -->

        <!-- MENU MODUL PPK TRANS -->
        @if($aksesPpk)
            <div class="px-3 pt-4 pb-1 text-[10px] font-extrabold text-gray-500 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Modul PPK Trans
            </div>
            <!-- Ikon Kotak/Grid untuk Dashboard PPK -->
            <a href="{{ route('ppktrans.dashboard') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('ppk-trans/dashboard') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Dashboard</span>
            </a>
            <a href="{{ route('ppktrans.input') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('ppk-trans/input-matriks') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Matriks</span>
            </a>
            <a href="{{ route('ppktrans.rekap') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('ppk-trans/rekap') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Rekap</span>
            </a>
        @endif

        <!-- MENU MODUL PEMT -->
        @if($aksesPemt)
            <div class="px-3 pt-4 pb-1 text-[10px] font-extrabold text-gray-500 uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Modul PEMT
            </div>
            <!-- Ikon Kotak/Grid untuk Dashboard PEMT -->
            <a href="{{ route('pemt.dashboard') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('pemt/dashboard') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Dashboard</span>
            </a>
            <a href="{{ route('pemt.input') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('pemt/input-matriks') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Matriks</span>
            </a>
            <a href="{{ route('pemt.rekap') }}" class="flex items-center px-3 py-3 rounded-xl transition-all font-bold {{ Request::is('pemt/rekap') ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="ml-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Rekap</span>
            </a>
        @endif

    </nav>
</aside>