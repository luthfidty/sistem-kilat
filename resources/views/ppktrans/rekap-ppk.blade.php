<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Mingguan - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        .header-wrapper > div, .header-wrapper > header, .header-wrapper > nav {
            max-width: 100% !important;
            margin-left: 0 !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; border: 1px solid #e2e8f0; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="min-h-screen flex text-gray-800 overflow-x-hidden w-full">
    
    <!-- 1. Memanggil Sidebar -->
    @include('layouts.sidebar')

    <!-- 2. Area Konten Utama -->
    <div class="flex-1 pl-[72px] peer-hover:pl-64 flex flex-col min-h-screen transition-all duration-300 min-w-0">
        
        @include('layouts.header')

        <main class="flex-1 p-5 md:p-8 animate-fade-in flex flex-col bg-gray-50/50 min-w-0 w-full">
            
            @php
                // Menerima data dari Controller (Atau nilai default jika kosong)
                $mingguAktif = request('minggu', 'M1');
                $bulanAktif = request('bulan', 'Juli');
                $tahunAktif = request('tahun', '2026');

                // LOGIKA ROLE AKSES
                $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
                $isPusatPpk = in_array($userRole, ['SUPERADMIN', 'PPK TRANS']);

                $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $daftarMinggu = ['M1', 'M2', 'M3', 'M4'];
                $daftarSatker = [
                    'Ses Ditjen PPK Trans',
                    'Dit. Perencanaan Perwujudan Kawasan Transmigrasi',
                    'Dit. Pembangunan Kawasan Transmigrasi',
                    'Dit. Fasilitasi Penataan Persebaran Penduduk di Kawasan Transmigrasi',
                    'Dit. Pengembangan Satuan Permukiman dan Pusat Satuan Kawasan Pengembangan',
                    'Dit. Pengembangan Kawasan Transmigrasi'
                ];
            @endphp

            <!-- Judul & Tombol Kembali -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('ppktrans.input') }}" class="w-11 h-11 bg-white border border-gray-200 rounded-2xl flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition-all shadow-sm cursor-pointer group shrink-0">
                        <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        @php
                            $teksJudul = '';
                            if($bulanAktif == '1 Tahun') {
                                $teksJudul = "1 TAHUN KESELURUHAN ({$tahunAktif})";
                            } elseif($mingguAktif == 'Semua Minggu') {
                                $teksJudul = "BULAN " . strtoupper($bulanAktif) . " {$tahunAktif}";
                            } else {
                                $teksJudul = "{$mingguAktif} BULAN " . strtoupper($bulanAktif) . " {$tahunAktif}";
                            }
                        @endphp
                        <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight uppercase">
                            REKAPITULASI - {{ $teksJudul }}
                        </h1>
                        <p class="text-sm text-gray-500 mt-1 font-medium">Data realisasi khusus untuk {{ $mingguAktif }} bulan {{ $bulanAktif }} tahun {{ $tahunAktif }} di seluruh Satuan Kerja.</p>
                    </div>
                </div>
            </div>

            <!-- Toolbar: Filter Atas (Style Berkelas) -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6 bg-white p-3 rounded-2xl shadow-sm border border-gray-100">
                
                <!-- Filter Group (Unified Pill UI) -->
                <div class="inline-flex flex-col sm:flex-row items-center bg-gray-50/50 border border-gray-200 rounded-xl overflow-hidden shadow-inner">
                    
                    <!-- FILTER MINGGU (Disable & Meredup jika 1 Tahun) -->
                    <div class="flex items-center gap-2 px-4 py-2.5 border-b sm:border-b-0 sm:border-r border-gray-200 hover:bg-white transition-colors w-full sm:w-auto {{ $bulanAktif == '1 Tahun' ? 'bg-gray-100 opacity-60' : '' }}">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Minggu</span>
                        <select id="filterMinggu" onchange="terapkanFilter()" 
                            class="bg-transparent text-blue-700 font-extrabold text-sm focus:outline-none outline-none {{ $bulanAktif == '1 Tahun' ? 'cursor-not-allowed' : 'cursor-pointer' }}" 
                            {{ $bulanAktif == '1 Tahun' ? 'disabled' : '' }}>
                            <option value="Semua Minggu" {{ $mingguAktif == 'Semua Minggu' ? 'selected' : '' }}>Semua Minggu</option>
                            @foreach($daftarMinggu as $m)
                                <option value="{{ $m }}" {{ $mingguAktif == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- FILTER BULAN -->
                    <div class="flex items-center gap-2 px-4 py-2.5 border-b sm:border-b-0 sm:border-r border-gray-200 hover:bg-white transition-colors w-full sm:w-auto">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bulan</span>
                        <select id="filterBulan" onchange="terapkanFilter()" class="bg-transparent text-gray-800 font-bold text-sm focus:outline-none cursor-pointer outline-none">
                            <option value="1 Tahun" {{ $bulanAktif == '1 Tahun' ? 'selected' : '' }}>1 Tahun (Full)</option>
                            @foreach($daftarBulan as $b)
                                <option value="{{ $b }}" {{ $bulanAktif == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- FILTER TAHUN -->
                    <div class="flex items-center gap-2 px-4 py-2.5 hover:bg-white transition-colors w-full sm:w-auto">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Thn</span>
                        <select id="filterTahun" onchange="terapkanFilter()" class="bg-transparent text-gray-800 font-bold text-sm focus:outline-none cursor-pointer outline-none">
                            <option value="2026" {{ $tahunAktif == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ $tahunAktif == '2025' ? 'selected' : '' }}>2025</option>
                        </select>
                    </div>

                </div>

                <!-- TOMBOL EXPORT (Animasi Hover Berkelas) -->
                <div class="shrink-0 w-full xl:w-auto">
                    <button class="w-full xl:w-auto flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export Excel
                    </button>
                </div>

            </div>

            <!-- Wadah Utama Tabel Rekapitulasi -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden w-full flex flex-col">
                <div class="overflow-x-auto custom-scrollbar w-full">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        
                        <!-- HEADER TABEL -->
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th rowspan="2" class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle w-12">No</th>
                                <th rowspan="2" class="px-4 py-3 text-left font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle min-w-[250px]">Satker (Satuan Kerja)</th>
                                <th rowspan="2" class="px-4 py-3 text-right font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle">Pagu Anggaran (Rp)</th>
                                
                                <th colspan="2" class="px-4 py-2.5 text-center font-extrabold text-[10px] uppercase tracking-widest border-r border-b border-gray-700 text-emerald-300 bg-gray-750">Realisasi Anggaran</th>
                                
                                <th rowspan="2" class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle w-[120px]">Realisasi Fisik (%)</th>
                                <th rowspan="2" class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider align-middle w-[100px]">Deviasi (%)</th>
                            </tr>
                            <tr class="bg-gray-700 text-gray-200">
                                <th class="px-3 py-2 text-center font-semibold text-[10px] uppercase tracking-wider border-r border-gray-600 w-[140px]">(Rp)</th>
                                <th class="px-3 py-2 text-center font-semibold text-[10px] uppercase tracking-wider border-r border-gray-600 w-[80px]">(%)</th>
                            </tr>
                        </thead>

                        <!-- BODY TABEL -->
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @php $noUrut = 1; @endphp
                            @foreach($daftarSatker as $index => $satker)
                                
                                <!-- KODE FILTER: Hanya muncul jika pusat ATAU jika rolenya sesuai dengan satker ini -->
                                @if($isPusatPpk || $userRole === strtoupper($satker))
                                
                                @php
                                    // Membuat data dummy yang bervariasi
                                    $pagu = 1004101000 + ($index * 150000000);
                                    
                                    // Asumsi Rencana untuk menghitung deviasi
                                    $rencanaPersen = 11.39 + ($index * 1.5);

                                    $realisasiRp = $pagu * (0.1378 + ($index * 0.02)); 
                                    $realisasiPersen = 13.78 + ($index * 2.1);
                                    $realisasiFisik = $realisasiPersen; 
                                    
                                    $deviasi = $realisasiPersen - $rencanaPersen;
                                    
                                    $deviasiColor = $deviasi >= 0 ? 'text-emerald-600' : 'text-red-500';
                                    $deviasiSign = $deviasi > 0 ? '+' : '';
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3.5 text-center text-xs font-semibold text-gray-700 border-r border-gray-200">
                                        {{ $noUrut++ }}
                                    </td>
                                    <td class="px-4 py-3.5 text-xs font-bold text-gray-800 border-r border-gray-200 leading-relaxed">
                                        {{ $satker }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right text-xs font-semibold text-gray-700 border-r border-gray-200">
                                        {{ number_format($pagu, 0, ',', '.') }}
                                    </td>
                                    
                                    <!-- Realisasi -->
                                    <td class="px-3 py-3.5 text-right text-xs font-bold text-emerald-600 border-r border-gray-200 bg-emerald-50/30">
                                        {{ number_format($realisasiRp, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-3.5 text-center text-xs font-bold text-emerald-600 border-r border-gray-200 bg-emerald-50/30">
                                        {{ number_format($realisasiPersen, 2, ',', '.') }}%
                                    </td>
                                    
                                    <td class="px-4 py-3.5 text-center text-xs font-bold text-gray-700 border-r border-gray-200">
                                        {{ number_format($realisasiFisik, 2, ',', '.') }}%
                                    </td>
                                    <td class="px-4 py-3.5 text-center text-xs font-bold {{ $deviasiColor }}">
                                        {{ $deviasiSign }}{{ number_format($deviasi, 2, ',', '.') }}%
                                    </td>
                                </tr>
                                
                                @endif
                                
                            @endforeach
                        </tbody>

                        <!-- FOOTER TABEL (REKAP TOTAL) -->
                        <!-- KODE FILTER: Hanya muncul jika pusat/Superadmin -->
                        @if($isPusatPpk)
                        <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-center text-sm font-extrabold text-gray-800 uppercase tracking-widest border-r border-gray-300">
                                    TOTAL KESELURUHAN
                                </td>
                                <td class="px-4 py-4 text-right text-xs font-extrabold text-gray-900 border-r border-gray-300">
                                    10.524.606.000
                                </td>
                                
                                <td class="px-3 py-4 text-right text-xs font-extrabold text-emerald-700 border-r border-gray-300 bg-emerald-100/50">
                                    1.984.300.000
                                </td>
                                <td class="px-3 py-4 text-center text-xs font-extrabold text-emerald-700 border-r border-gray-300 bg-emerald-100/50">
                                    18.85%
                                </td>
                                
                                <td class="px-4 py-4 text-center text-xs font-extrabold text-gray-900 border-r border-gray-300">
                                    18.85%
                                </td>
                                <td class="px-4 py-4 text-center text-xs font-extrabold text-emerald-600">
                                    +4.48%
                                </td>
                            </tr>
                        </tfoot>
                        @endif

                    </table>
                </div>
            </div>

        </main>
        
        @include('layouts.footer')
    </div>

    <!-- SCRIPT FILTER TABEL REKAPITULASI -->
    <script>
        function terapkanFilter() {
            let minggu = document.getElementById('filterMinggu').value;
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            
            // LOGIKA PENGUNCIAN: Jika Bulan diubah menjadi 1 Tahun, paksa Minggu ke Semua Minggu
            if (bulan === '1 Tahun') {
                minggu = 'Semua Minggu';
            }
            
            // Reload halaman dan lempar parameter ke URL saat select diubah
            const url = new URL(window.location.href);
            url.searchParams.set('minggu', minggu);
            url.searchParams.set('bulan', bulan);
            url.searchParams.set('tahun', tahun);
            
            window.location.href = url.toString();
        }
    </script>
</body>
</html>