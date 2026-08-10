<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi PEMT - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .header-wrapper > div, .header-wrapper > header, .header-wrapper > nav { max-width: 100% !important; margin-left: 0 !important; padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .card-shadow { box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="min-h-screen flex text-gray-800 overflow-x-hidden w-full">
    @include('layouts.sidebar')

    <div class="flex-1 pl-[72px] peer-hover:pl-64 flex flex-col min-h-screen transition-all duration-300 min-w-0">
        @include('layouts.header')

        <main class="flex-1 p-5 md:p-8 animate-fade-in flex flex-col min-w-0 w-full">
            @php
                $mingguAktif = request('minggu', 'M1');
                $bulanAktif = request('bulan', 'Juli');
                $tahunAktif = request('tahun', '2026');

                // LOGIKA ROLE AKSES
                $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
                $isPusatPemt = in_array($userRole, ['SUPERADMIN', 'PEMT']);

                $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $daftarMinggu = ['M1', 'M2', 'M3', 'M4'];
                $daftarSatker = [
                    'Ses. Ditjen PEMT',
                    'Dit. Perencanaan Teknis Pengembangan Ekonomi dan Pemberdayaan Masyarakat Transmigrasi',
                    'Dit. Pengembangan Produk Unggulan Transmigrasi',
                    'Dit. Pengembangan Kelembagaan Ekonomi Transmigrasi',
                    'Dit. Promosi dan Pemasaran Produk Unggulan Transmigrasi',
                    'Dit. Pemberdayaan Masyarakat Transmigrasi'
                ];

                $teksJudul = '';
                if($bulanAktif == '1 Tahun') {
                    $teksJudul = "1 TAHUN KESELURUHAN ({$tahunAktif})";
                } elseif($mingguAktif == 'Semua Minggu') {
                    $teksJudul = "BULAN " . strtoupper($bulanAktif) . " {$tahunAktif}";
                } else {
                    $teksJudul = "{$mingguAktif} BULAN " . strtoupper($bulanAktif) . " {$tahunAktif}";
                }
            @endphp

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('pemt.input') }}" class="w-11 h-11 bg-white border border-gray-200 rounded-2xl flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition-all shadow-sm cursor-pointer group shrink-0">
                        <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-extrabold text-[#1e293b] tracking-tight uppercase">REKAPITULASI - {{ $teksJudul }}</h1>
                        <p class="text-sm text-gray-500 mt-1 font-medium">Data realisasi di seluruh Satuan Kerja PEMT pada periode yang dipilih.</p>
                    </div>
                </div>
            </div>

            <!-- Filter Visualisasi Modern -->
            <div class="bg-white rounded-2xl card-shadow p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4 border border-gray-100">
                <div class="inline-flex flex-col sm:flex-row items-center bg-gray-50/50 border border-gray-200 rounded-xl overflow-hidden shadow-inner w-full md:w-auto">
                    <!-- MINGGU -->
                    <div class="flex items-center gap-2 px-4 py-2.5 border-b sm:border-b-0 sm:border-r border-gray-200 hover:bg-white transition-colors w-full sm:w-auto {{ $bulanAktif == '1 Tahun' ? 'bg-gray-100 opacity-60' : '' }}">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Minggu</span>
                        <select id="filterMinggu" onchange="terapkanFilter()" class="bg-transparent text-blue-700 font-extrabold text-sm focus:outline-none outline-none {{ $bulanAktif == '1 Tahun' ? 'cursor-not-allowed' : 'cursor-pointer' }}" {{ $bulanAktif == '1 Tahun' ? 'disabled' : '' }}>
                            <option value="Semua Minggu" {{ $mingguAktif == 'Semua Minggu' ? 'selected' : '' }}>Semua Minggu</option>
                            @foreach($daftarMinggu as $m)<option value="{{ $m }}" {{ $mingguAktif == $m ? 'selected' : '' }}>{{ $m }}</option>@endforeach
                        </select>
                    </div>
                    <!-- BULAN -->
                    <div class="flex items-center gap-2 px-4 py-2.5 border-b sm:border-b-0 sm:border-r border-gray-200 hover:bg-white transition-colors w-full sm:w-auto">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bulan</span>
                        <select id="filterBulan" onchange="terapkanFilter()" class="bg-transparent text-gray-800 font-bold text-sm focus:outline-none cursor-pointer outline-none">
                            <option value="1 Tahun" {{ $bulanAktif == '1 Tahun' ? 'selected' : '' }}>1 Tahun (Full)</option>
                            @foreach($daftarBulan as $b)<option value="{{ $b }}" {{ $bulanAktif == $b ? 'selected' : '' }}>{{ $b }}</option>@endforeach
                        </select>
                    </div>
                    <!-- TAHUN -->
                    <div class="flex items-center gap-2 px-4 py-2.5 hover:bg-white transition-colors w-full sm:w-auto">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Thn</span>
                        <select id="filterTahun" onchange="terapkanFilter()" class="bg-transparent text-gray-800 font-bold text-sm focus:outline-none cursor-pointer outline-none">
                            <option value="2026" {{ $tahunAktif == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ $tahunAktif == '2025' ? 'selected' : '' }}>2025</option>
                        </select>
                    </div>
                </div>
                <div class="shrink-0 w-full xl:w-auto">
                    <button class="w-full xl:w-auto flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Export Excel
                    </button>
                </div>
            </div>

            <!-- Tabel Rekapitulasi -->
            <div class="bg-white rounded-[20px] card-shadow border border-gray-100 overflow-hidden w-full flex flex-col mb-8">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-2 bg-white">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <h2 class="text-slate-800 text-sm font-extrabold tracking-widest uppercase">Rekapitulasi Unit Kerja Eselon II (PEMT)</h2>
                </div>
                <div class="overflow-x-auto custom-scrollbar w-full p-4">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead>
                            <tr class="bg-[#1e293b] text-white">
                                <th rowspan="2" class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle w-12 rounded-tl-xl">No</th>
                                <th rowspan="2" class="px-4 py-3 text-left font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle min-w-[250px]">Satker (Satuan Kerja)</th>
                                <th rowspan="2" class="px-4 py-3 text-right font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle">Pagu Anggaran (Rp)</th>
                                <th colspan="2" class="px-4 py-2.5 text-center font-extrabold text-[10px] uppercase tracking-widest border-r border-b border-gray-700 text-emerald-300">Realisasi Anggaran</th>
                                <th rowspan="2" class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 align-middle w-[120px]">Realisasi Fisik (%)</th>
                                <th rowspan="2" class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider align-middle w-[100px] rounded-tr-xl">Deviasi (%)</th>
                            </tr>
                            <tr class="bg-gray-700 text-gray-200">
                                <th class="px-3 py-2 text-center font-semibold text-[10px] uppercase tracking-wider border-r border-gray-600 w-[140px]">(Rp)</th>
                                <th class="px-3 py-2 text-center font-semibold text-[10px] uppercase tracking-wider border-r border-gray-600 w-[80px]">(%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @php $noUrut = 1; @endphp
                            @foreach($daftarSatker as $index => $satker)
                                
                                <!-- KODE FILTER: Hanya muncul jika pusat ATAU jika rolenya sesuai dengan satker ini -->
                                @if($isPusatPemt || $userRole === strtoupper($satker))
                                
                                @php
                                    $multiplier = ($bulanAktif == '1 Tahun') ? 48 : (($mingguAktif == 'Semua Minggu') ? 4 : 1);
                                    $pagu = 1004101000 + ($index * 150000000);
                                    $realisasiPersen = (1.5 + ($index * 0.2)) * $multiplier; 
                                    $realisasiRp = $pagu * ($realisasiPersen / 100); 
                                    $deviasi = $realisasiPersen - ($multiplier * 1.2);
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3.5 text-center text-xs font-semibold text-gray-700 border-r border-gray-200">
                                        {{ $noUrut++ }}
                                    </td>
                                    <td class="px-4 py-3.5 text-xs font-bold text-gray-800 border-r border-gray-200">{{ $satker }}</td>
                                    <td class="px-4 py-3.5 text-right text-xs font-semibold text-gray-700 border-r border-gray-200">{{ number_format($pagu, 0, ',', '.') }}</td>
                                    <td class="px-3 py-3.5 text-right text-xs font-bold text-emerald-600 border-r border-gray-200 bg-emerald-50/30">{{ number_format($realisasiRp, 0, ',', '.') }}</td>
                                    <td class="px-3 py-3.5 text-center text-xs font-bold text-emerald-600 border-r border-gray-200 bg-emerald-50/30">{{ number_format($realisasiPersen, 2, ',', '.') }}%</td>
                                    <td class="px-4 py-3.5 text-center text-xs font-bold text-gray-700 border-r border-gray-200">{{ number_format($realisasiPersen, 2, ',', '.') }}%</td>
                                    <td class="px-4 py-3.5 text-center text-xs font-bold {{ $deviasi >= 0 ? 'text-emerald-600' : 'text-red-500' }}">{{ $deviasi > 0 ? '+' : '' }}{{ number_format($deviasi, 2, ',', '.') }}%</td>
                                </tr>
                                
                                @endif
                                
                            @endforeach
                        </tbody>
                        
                        <!-- OPTIONAL FOOTER: Hanya muncul jika pusat/Superadmin yang login -->
                        @if($isPusatPemt)
                        <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-center text-sm font-extrabold text-gray-800 uppercase tracking-widest border-r border-gray-300">
                                    TOTAL KESELURUHAN
                                </td>
                                <td class="px-4 py-4 text-right text-xs font-extrabold text-gray-900 border-r border-gray-300">
                                    8.274.606.000
                                </td>
                                <td class="px-3 py-4 text-right text-xs font-extrabold text-emerald-700 border-r border-gray-300 bg-emerald-100/50">
                                    1.284.300.000
                                </td>
                                <td class="px-3 py-4 text-center text-xs font-extrabold text-emerald-700 border-r border-gray-300 bg-emerald-100/50">
                                    15.50%
                                </td>
                                <td class="px-4 py-4 text-center text-xs font-extrabold text-gray-900 border-r border-gray-300">
                                    15.50%
                                </td>
                                <td class="px-4 py-4 text-center text-xs font-extrabold text-emerald-600">
                                    +3.50%
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

    <script>
        function terapkanFilter() {
            let minggu = document.getElementById('filterMinggu').value;
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            if (bulan === '1 Tahun') { minggu = 'Semua Minggu'; }
            const url = new URL(window.location.href);
            url.searchParams.set('minggu', minggu); url.searchParams.set('bulan', bulan); url.searchParams.set('tahun', tahun);
            window.location.href = url.toString();
        }
    </script>
</body>
</html>