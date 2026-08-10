<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PPK Trans - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        
        .header-wrapper > div, .header-wrapper > header, .header-wrapper > nav {
            max-width: 100% !important;
            margin-left: 0 !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .circle-bg { fill: none; stroke: #f1f5f9; }
        .circle-progress { fill: none; stroke-linecap: round; transition: stroke-dashoffset 1s ease-in-out; }
        
        .card-shadow { box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); }
    </style>
</head>

<body class="min-h-screen flex text-gray-800 overflow-x-hidden w-full">
    
    @include('layouts.sidebar')

    <div class="flex-1 pl-[72px] peer-hover:pl-64 flex flex-col min-h-screen transition-all duration-300 min-w-0">
        
        @include('layouts.header')

        <main class="flex-1 p-5 md:p-8 animate-fade-in flex flex-col min-w-0 w-full">
            
            @php
                // 1. Ambil role user saat ini dan ubah ke KAPITAL
                $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
                
                // 2. Kunci Master: Superadmin & PPK Trans Pusat bisa melihat semua
                $isPusatPpk = in_array($userRole, ['SUPERADMIN', 'PPK TRANS']);

                // Master Data Terpadu PPK Trans (Menjaga teks asli 100% utuh)
                $allData = [
                    [
                        'match' => 'SES DITJEN PPK TRANS', 'name_short' => 'Sesditjen PPK Trans', 'name_table' => 'Sekretariat Direktorat Jenderal Pembangunan dan Pengembangan Kawasan Transmigrasi', 
                        'pagu' => 95, 'realisasi' => 50, 'fisik' => 50, 'deviasi' => -5,
                        'pagu_rp' => '440.507.265.000', 'real_rp' => '151.274.294.987', 'preal' => '34,34%', 'fis' => '34,34%', 'dev' => '-1,41%',
                        'top_pagu' => 'Rp 440,5 M', 'top_real' => 'Rp 151,3 M', 'color' => '#1e293b', 'pie_pct' => '35%'
                    ],
                    [
                        'match' => 'PERENCANAAN PERWUJUDAN', 'name_short' => 'Dit. P2KT', 'name_table' => 'Direktorat Perencanaan Perwujudan Kawasan Transmigrasi', 
                        'pagu' => 85, 'realisasi' => 35, 'fisik' => 35, 'deviasi' => 2,
                        'pagu_rp' => '11.238.317.000', 'real_rp' => '4.255.307.165', 'preal' => '37,86%', 'fis' => '37,86%', 'dev' => '-1,36%',
                        'top_pagu' => 'Rp 11,2 M', 'top_real' => 'Rp 4,2 M', 'color' => '#334155', 'pie_pct' => '20%'
                    ],
                    [
                        'match' => 'PEMBANGUNAN KAWASAN', 'name_short' => 'Dit. PKT', 'name_table' => 'Direktorat Pembangunan Kawasan Transmigrasi', 
                        'pagu' => 90, 'realisasi' => 25, 'fisik' => 25, 'deviasi' => -1,
                        'pagu_rp' => '473.696.208.000', 'real_rp' => '26.660.439.755', 'preal' => '5,62%', 'fis' => '5,62%', 'dev' => '+0,17%',
                        'top_pagu' => 'Rp 473,6 M', 'top_real' => 'Rp 26,6 M', 'color' => '#475569', 'pie_pct' => '15%'
                    ],
                    [
                        'match' => 'FASILITASI PENATAAN', 'name_short' => 'Dit. FP3KT', 'name_table' => 'Direktorat Fasilitasi Penataan Persebaran Penduduk di Kawasan Transmigrasi', 
                        'pagu' => 80, 'realisasi' => 45, 'fisik' => 45, 'deviasi' => 4,
                        'pagu_rp' => '313.372.526.000', 'real_rp' => '10.683.419.868', 'preal' => '3,40%', 'fis' => '3,40%', 'dev' => '-0,88%',
                        'top_pagu' => 'Rp 313,3 M', 'top_real' => 'Rp 10,6 M', 'color' => '#64748b', 'pie_pct' => '12%'
                    ],
                    [
                        'match' => 'PENGEMBANGAN SATUAN', 'name_short' => 'Dit. PSP-PSKP', 'name_table' => 'Direktorat Pengembangan Satuan Permukiman dan Pusat Satuan Kawasan Pengembangan', 
                        'pagu' => 88, 'realisasi' => 65, 'fisik' => 65, 'deviasi' => -3,
                        'pagu_rp' => '313.372.526.000', 'real_rp' => '10.683.419.868', 'preal' => '3,40%', 'fis' => '3,40%', 'dev' => '-0,88%',
                        'top_pagu' => 'Rp 313,3 M', 'top_real' => 'Rp 10,6 M', 'color' => '#94a3b8', 'pie_pct' => '10%'
                    ],
                    [
                        'match' => 'PENGEMBANGAN KAWASAN', 'name_short' => 'Dit. PKTrans', 'name_table' => 'Direktorat Pengembangan Kawasan Transmigrasi', 
                        'pagu' => 92, 'realisasi' => 55, 'fisik' => 55, 'deviasi' => 1,
                        'pagu_rp' => '313.372.526.000', 'real_rp' => '10.683.419.868', 'preal' => '3,40%', 'fis' => '3,40%', 'dev' => '-0,88%',
                        'top_pagu' => 'Rp 313,3 M', 'top_real' => 'Rp 10,6 M', 'color' => '#cbd5e1', 'pie_pct' => '8%'
                    ],
                ];

                // Proses Filter Otomatis
                $activeData = $isPusatPpk ? $allData : array_filter($allData, function($item) use ($userRole) {
                    return str_contains($userRole, $item['match']);
                });
                
                // Reset index array agar mudah diakses
                $activeData = array_values($activeData);
                $isSingle = count($activeData) === 1; // Penanda jika hanya 1 satker
                
                // Variabel untuk Top Cards
                $topPagu = $isPusatPpk ? 'Rp 440,5 M' : ($activeData[0]['top_pagu'] ?? 'Rp 0');
                $topReal = $isPusatPpk ? 'Rp 151,3 M' : ($activeData[0]['top_real'] ?? 'Rp 0');
                $topPreal = $isPusatPpk ? '34.36%' : ($activeData[0]['preal'] ?? '0%');
                $topDev = $isPusatPpk ? '-1.40%' : ($activeData[0]['dev'] ?? '0%');
                $topLabel = $isPusatPpk ? 'Ditjen PPK Trans' : ucwords(strtolower(auth()->user()->role->nama_role));
            @endphp

            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-[#1e293b] tracking-tight uppercase">DASHBOARD PPK TRANS</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Ringkasan grafik, data realisasi, fisik dan deviasi DITJEN. PPK Trans</p>
            </div>

            <!-- Filter Visualisasi -->
            <div class="bg-white rounded-2xl card-shadow p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4 border border-gray-100">
                <div class="flex items-center gap-2 text-gray-800 px-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <span class="font-extrabold text-xs uppercase tracking-widest">Filter Visualisasi</span>
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <select class="appearance-none px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none cursor-pointer hover:bg-gray-100 transition-colors w-full sm:w-auto">
                        <option>Juli</option>
                        <option>Agustus</option>
                    </select>
                    <select class="appearance-none px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none cursor-pointer hover:bg-gray-100 transition-colors w-full sm:w-auto">
                        <option>Semua Minggu</option>
                        <option>Minggu 1</option>
                    </select>
                    <select class="appearance-none px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:outline-none cursor-pointer hover:bg-gray-100 transition-colors w-full sm:w-auto">
                        <option>2026</option>
                        <option>2025</option>
                    </select>
                </div>
            </div>

            <!-- 3 Kartu Metrik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pagu -->
                <div class="bg-white rounded-[20px] card-shadow p-6 border border-gray-100 relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-slate-800 text-xs font-extrabold tracking-widest uppercase">Pagu Anggaran</h3>
                    </div>
                    <p class="text-[#1e293b] text-3xl font-extrabold tracking-tight">{{ $topPagu }}</p>
                    <p class="text-xs font-semibold text-gray-400 mt-2 uppercase tracking-wide">{{ $topLabel }}</p>
                </div>

                <!-- Realisasi -->
                <div class="bg-white rounded-[20px] card-shadow p-6 border border-gray-100 relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-slate-800 text-xs font-extrabold tracking-widest uppercase">Realisasi Anggaran</h3>
                    </div>
                    <p class="text-[#1e293b] text-3xl font-extrabold tracking-tight">{{ $topReal }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-md">{{ $topPreal }}</span>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Terserap</p>
                    </div>
                </div>

                <!-- Deviasi -->
                <div class="bg-white rounded-[20px] card-shadow p-6 border border-gray-100 relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        </div>
                        <h3 class="text-slate-800 text-xs font-extrabold tracking-widest uppercase">Deviasi</h3>
                    </div>
                    <p class="text-[#ef4444] text-3xl font-extrabold tracking-tight">{{ $topDev }}</p>
                    <p class="text-xs font-semibold text-gray-400 mt-2 uppercase tracking-wide">Terhadap Target</p>
                </div>
            </div>

            <!-- Wadah Grafik 1: Komparasi Radial -->
            <div class="bg-white rounded-[20px] card-shadow border border-gray-100 overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <!-- Judul Dinamis -->
                    <h2 class="text-slate-800 text-sm font-extrabold tracking-widest uppercase">
                        {{ $isPusatPpk ? 'Komparasi Pagu, Realisasi, Fisik & Deviasi' : 'Indikator Capaian Kinerja Unit' }}
                    </h2>
                </div>
                
                <!-- DI SINI KUNCINYA: Pakai flex wrap justify-center -->
                <div class="p-10 flex flex-wrap justify-center items-center gap-12 lg:gap-16 {{ $isSingle ? 'min-h-[300px]' : '' }}">
                    @foreach($activeData as $unit)
                        @php
                            $devStroke = $unit['deviasi'] < 0 ? 'stroke-[#ef4444]' : 'stroke-[#10b981]';
                            $devVal = abs($unit['deviasi']) * 5; 
                        @endphp
                        
                        <!-- Jika single, sedikit diperbesar (scale-125) -->
                        <div class="flex flex-col items-center justify-end group {{ $isSingle ? 'transform scale-125' : '' }} mx-auto">
                            <div class="bg-gray-50 text-slate-700 text-[10px] font-extrabold uppercase px-4 py-1.5 rounded-full mb-6 text-center min-h-[24px] flex items-center border border-gray-200">
                                {{ $unit['name_short'] }}
                            </div>
                            
                            <div class="relative w-32 h-32 transform -rotate-90 group-hover:scale-105 transition-transform duration-300">
                                <!-- Ring 1 (Luar) - Pagu -->
                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                                    <circle class="circle-bg" cx="50" cy="50" r="42" stroke-width="8"></circle>
                                    <circle class="circle-progress stroke-[#1e293b]" cx="50" cy="50" r="42" stroke-width="8" stroke-dasharray="263.89" stroke-dashoffset="{{ 263.89 - (263.89 * $unit['pagu'] / 100) }}"></circle>
                                </svg>
                                <!-- Ring 2 - Realisasi -->
                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                                    <circle class="circle-bg" cx="50" cy="50" r="32" stroke-width="8"></circle>
                                    <circle class="circle-progress stroke-[#64748b]" cx="50" cy="50" r="32" stroke-width="8" stroke-dasharray="201.06" stroke-dashoffset="{{ 201.06 - (201.06 * $unit['realisasi'] / 100) }}"></circle>
                                </svg>
                                <!-- Ring 3 - Fisik -->
                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                                    <circle class="circle-bg" cx="50" cy="50" r="22" stroke-width="8"></circle>
                                    <circle class="circle-progress stroke-[#94a3b8]" cx="50" cy="50" r="22" stroke-width="8" stroke-dasharray="138.23" stroke-dashoffset="{{ 138.23 - (138.23 * $unit['fisik'] / 100) }}"></circle>
                                </svg>
                                <!-- Ring 4 (Dalam) - Deviasi -->
                                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100">
                                    <circle class="circle-bg" cx="50" cy="50" r="12" stroke-width="8"></circle>
                                    <circle class="circle-progress {{ $devStroke }}" cx="50" cy="50" r="12" stroke-width="8" stroke-dasharray="75.39" stroke-dashoffset="{{ 75.39 - (75.39 * $devVal / 100) }}"></circle>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="px-6 py-4 flex flex-wrap justify-center gap-6 pb-6 mt-4 border-t border-gray-50 pt-6">
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-[#1e293b]"></div><span class="text-[11px] font-extrabold text-gray-700 uppercase tracking-widest">Pagu</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-[#64748b]"></div><span class="text-[11px] font-extrabold text-gray-700 uppercase tracking-widest">Realisasi</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-[#94a3b8]"></div><span class="text-[11px] font-extrabold text-gray-700 uppercase tracking-widest">Fisik</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-[#ef4444]"></div><span class="text-[11px] font-extrabold text-gray-700 uppercase tracking-widest">Deviasi</span></div>
                </div>
            </div>

            <!-- Wadah Grafik 2: Proporsi Realisasi -->
            <div class="bg-white rounded-[20px] card-shadow border border-gray-100 overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <!-- Judul Dinamis -->
                    <h2 class="text-slate-800 text-sm font-extrabold tracking-widest uppercase">
                        {{ $isPusatPpk ? 'Proporsi Realisasi Anggaran Terhadap Pagu' : 'Status Proporsi Anggaran' }}
                    </h2>
                </div>
                <div class="p-10 flex flex-col lg:flex-row items-center justify-center gap-12 lg:gap-24">
                    
                    <!-- Dinamis Pie Chart: Jika Satker, tampilkan Donut Chart. Jika Pusat, tampilkan pie full sesuai warna asli -->
                    <div class="relative w-64 h-64 rounded-full shadow-lg border-[8px] border-white shrink-0 flex items-center justify-center" 
                         style="background: {{ $isPusatPpk ? 'conic-gradient(#1e293b 0% 35%, #334155 35% 55%, #475569 55% 70%, #64748b 70% 82%, #94a3b8 82% 92%, #cbd5e1 92% 100%)' : $activeData[0]['color'] }};">
                         
                         @if($isSingle)
                            <!-- Bulatan putih di tengah (Donut Hole) -->
                            <div class="absolute inset-0 m-8 bg-white rounded-full shadow-inner flex flex-col items-center justify-center">
                                <span class="text-3xl font-extrabold" style="color: {{ $activeData[0]['color'] }}">100%</span>
                                <span class="text-[9px] font-bold text-gray-400 tracking-widest uppercase mt-1">Porsi Unit</span>
                            </div>
                         @endif
                    </div>
                    
                    <div class="flex flex-wrap justify-center {{ $isPusatPpk ? 'grid grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-8 w-full max-w-2xl' : 'flex-col gap-6 w-full max-w-xs' }}">
                        @foreach($activeData as $unit)
                        <div class="{{ $isSingle ? 'bg-gray-50 px-8 py-6 rounded-2xl border border-gray-100 shadow-sm text-center' : '' }}">
                            <div class="flex items-center {{ $isSingle ? 'justify-center' : '' }} gap-2 mb-2">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $unit['color'] }}"></div>
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ $unit['name_short'] }}</span>
                            </div>
                            <div class="text-2xl font-extrabold {{ $isSingle ? '' : 'pl-5' }}" style="color: {{ $unit['color'] }}">
                                {{ $isPusatPpk ? $unit['pie_pct'] : 'Data Penuh' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tabel Data Rekapitulasi -->
            <div class="bg-white rounded-[20px] card-shadow border border-gray-100 overflow-hidden w-full flex flex-col mb-8">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2 bg-white">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <h2 class="text-slate-800 text-sm font-extrabold tracking-widest uppercase">Rekapitulasi Unit Kerja Eselon II</h2>
                </div>
                <div class="overflow-x-auto custom-scrollbar w-full p-4">
                    <table class="w-full text-left border-collapse rounded-xl overflow-hidden min-w-[1000px]">
                        <thead>
                            <tr class="bg-[#1e293b] text-white">
                                <th class="px-5 py-4 font-extrabold text-xs uppercase tracking-widest w-[300px] rounded-tl-xl">Unit Kerja</th>
                                <th class="px-4 py-4 text-right font-extrabold text-xs uppercase tracking-widest">Pagu (Rp)</th>
                                <th class="px-4 py-4 text-right font-extrabold text-xs uppercase tracking-widest">Realisasi (Rp)</th>
                                <th class="px-4 py-4 text-center font-extrabold text-xs uppercase tracking-widest w-[120px]">Realisasi (%)</th>
                                <th class="px-4 py-4 text-center font-extrabold text-xs uppercase tracking-widest w-[120px]">Fisik (%)</th>
                                <th class="px-4 py-4 text-center font-extrabold text-xs uppercase tracking-widest w-[150px] rounded-tr-xl">Deviasi (+/-)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($activeData as $row)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-5 py-4 text-xs font-bold text-slate-800 leading-relaxed">{{ $row['name_table'] }}</td>
                                    <td class="px-4 py-4 text-right text-xs font-bold text-slate-600">{{ $row['pagu_rp'] }}</td>
                                    <td class="px-4 py-4 text-right text-xs font-bold text-slate-600">{{ $row['real_rp'] }}</td>
                                    <td class="px-4 py-4 text-center text-xs font-bold text-emerald-600">{{ $row['preal'] }}</td>
                                    <td class="px-4 py-4 text-center text-xs font-bold text-blue-600">{{ $row['fis'] }}</td>
                                    <td class="px-4 py-4 text-center text-xs font-bold {{ str_contains($row['dev'], '-') ? 'text-red-500' : 'text-emerald-500' }}">{{ $row['dev'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        
        @include('layouts.footer')
    </div>

</body>
</html>