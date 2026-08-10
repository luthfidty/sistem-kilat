<!-- ========================================== -->
<!-- MODAL PILIH UNIT KERJA (KILAT INPUT)       -->
<!-- ========================================== -->
<div id="modalInputOverlay" class="fixed inset-0 z-[100] hidden bg-gray-900/60 items-center justify-center transition-opacity duration-300 opacity-0">
    <div id="modalContent" class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md p-8 transform scale-95 transition-transform duration-300 relative mx-4">
        
        <button type="button" onclick="closeModalInput()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-700 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="text-center mb-8 mt-2">
            <h3 class="text-lg font-extrabold text-gray-800 uppercase tracking-widest mb-2">Pilih Unit Kerja</h3>
            <p class="text-xs text-gray-500 font-medium">Silakan pilih direktori input data untuk melanjutkan.</p>
        </div>

        @php
            $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
            $isSuperadmin = ($userRole === 'SUPERADMIN');
            
            // DAFTAR ROLE PPK TRANS
            $rolesPpk = [
                'PPK TRANS',
                'SES DITJEN PPK TRANS',
                'DIT. PERENCANAAN PERWUJUDAN KAWASAN TRANSMIGRASI',
                'DIT. PEMBANGUNAN KAWASAN TRANSMIGRASI',
                'DIT. FASILITASI PENATAAN PERSEBARAN PENDUDUK DI KAWASAN TRANSMIGRASI',
                'DIT. PENGEMBANGAN SATUAN PERMUKIMAN DAN PUSAT SATUAN KAWASAN PENGEMBANGAN',
                'DIT. PENGEMBANGAN KAWASAN TRANSMIGRASI'
            ];

            // DAFTAR ROLE PEMT
            $rolesPemt = [
                'PEMT',
                'SES. DITJEN PEMT',
                'DIT. PERENCANAAN TEKNIS PENGEMBANGAN EKONOMI DAN PEMBERDAYAAN MASYARAKAT TRANSMIGRASI',
                'DIT. PENGEMBANGAN PRODUK UNGGULAN TRANSMIGRASI',
                'DIT. PENGEMBANGAN KELEMBAGAAN EKONOMI TRANSMIGRASI',
                'DIT. PROMOSI DAN PEMASARAN PRODUK UNGGULAN TRANSMIGRASI',
                'DIT. PEMBERDAYAAN MASYARAKAT TRANSMIGRASI'
            ];

            // Cek apakah role terdaftar di array
            $aksesPpk = $isSuperadmin || in_array($userRole, $rolesPpk);
            $aksesPemt = $isSuperadmin || in_array($userRole, $rolesPemt);
        @endphp

        <div class="grid grid-cols-1 gap-4">
            
            <!-- Tombol PPK Trans -->
            @if($aksesPpk)
                <a href="{{ route('ppktrans.input') }}" class="block p-4 border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gray-100 text-gray-600 rounded-lg group-hover:bg-white group-hover:shadow-sm transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-800 text-sm">Ditjen. PPK Trans</h4>
                            <p class="text-[10px] text-gray-500 font-bold tracking-widest uppercase mt-0.5">Input Form Progres</p>
                        </div>
                    </div>
                </a>
            @endif

            <!-- Tombol PEMT -->
            @if($aksesPemt)
                <a href="{{ route('pemt.input') }}" class="block p-4 border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gray-100 text-gray-600 rounded-lg group-hover:bg-white group-hover:shadow-sm transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-gray-800 text-sm">Ditjen. PEMT</h4>
                            <p class="text-[10px] text-gray-500 font-bold tracking-widest uppercase mt-0.5">Input Form Progres</p>
                        </div>
                    </div>
                </a>
            @endif

        </div>
    </div>
</div>