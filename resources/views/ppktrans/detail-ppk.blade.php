<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Matriks - KILAT</title>
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
            
            <!-- Judul & Tombol Kembali -->
            <div class="flex items-center gap-4 mb-6">
                <!-- Tombol Back -->
                <a href="#" onclick="history.back(); return false;" class="w-11 h-11 bg-white border border-gray-200 rounded-2xl flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition-all shadow-sm cursor-pointer group">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <!-- Nama Satker (Dinamis nantinya) -->
                    <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">{{ request('satker', 'Ses Ditjen PPK Trans') }}</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Kelola rincian kegiatan dan realisasi anggaran untuk bulan 2026.</p>
                </div>
            </div>

            <!-- Toolbar: Tabs Minggu & Filter Bulan/Tahun -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6 bg-white p-2.5 rounded-2xl shadow-sm border border-gray-200">
                
                <!-- TABS MINGGU -->
                <!-- Tambahkan id="tabs-container" di sini -->
                <div id="tabs-container" class="flex items-center gap-1 overflow-x-auto custom-scrollbar pr-2">
                    <button onclick="switchTab('m1')" id="tab-m1" class="tab-minggu px-5 py-2.5 bg-blue-50/80 text-blue-700 font-extrabold text-sm rounded-xl whitespace-nowrap border border-blue-100 transition-all cursor-pointer">Minggu Ke-1 (M1)</button>
                    <button onclick="switchTab('m2')" id="tab-m2" class="tab-minggu px-5 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-semibold text-sm rounded-xl whitespace-nowrap transition-all border border-transparent cursor-pointer">Minggu Ke-2 (M2)</button>
                    <button onclick="switchTab('m3')" id="tab-m3" class="tab-minggu px-5 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-semibold text-sm rounded-xl whitespace-nowrap transition-all border border-transparent cursor-pointer">Minggu Ke-3 (M3)</button>
                    <button onclick="switchTab('m4')" id="tab-m4" class="tab-minggu px-5 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-semibold text-sm rounded-xl whitespace-nowrap transition-all border border-transparent cursor-pointer">Minggu Ke-4 (M4)</button>
                    
                    <!-- TOMBOL TAMBAH MINGGU BARU (+) -->
                    <button id="btn-tambah-minggu" onclick="tambahMinggu()" class="flex items-center justify-center min-w-[40px] w-10 h-10 ml-1 rounded-xl bg-gray-100 hover:bg-emerald-100 text-gray-500 hover:text-emerald-600 border border-dashed border-gray-300 hover:border-emerald-300 transition-all cursor-pointer shadow-sm" title="Tambah Minggu Baru">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
                
                <!-- FILTER & EXPORT -->
                <div class="flex items-center gap-3 px-2">
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Thn:</span>
                        <select class="bg-transparent text-gray-800 font-bold text-sm focus:outline-none cursor-pointer outline-none">
                            <option>2026</option>
                            <option>2025</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Bulan:</span>
                        <select class="bg-transparent text-gray-800 font-bold text-sm focus:outline-none cursor-pointer outline-none">
                            <option>Juli</option>
                            <option>Agustus</option>
                        </select>
                    </div>

                    <button class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors shadow-sm ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Excel
                    </button>
                </div>
            </div>

            <!-- Wadah Utama Tabel Detail -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden w-full flex flex-col">
                <div class="overflow-x-auto custom-scrollbar w-full">
                    <table id="tabel-detail" class="w-full text-left border-collapse min-w-[1500px]">
                        
                        <!-- HEADER TABEL -->
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-12">No</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[200px]">Program</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[250px]">Komponen Kegiatan</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[150px]">Lokasi</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[120px]">Latitude</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[120px]">Longitude</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[100px]">Vol/Satuan</th>
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[120px]">Metode</th>
                                
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[140px]">Waktu (Start - End)</th>
                                
                                <th class="px-3 py-3 text-center font-extrabold text-[10px] text-blue-200 uppercase tracking-wider border-r border-gray-700">Pagu (Rp)</th>
                                <th class="px-3 py-3 text-center font-extrabold text-[10px] text-emerald-200 uppercase tracking-wider border-r border-gray-700">Realisasi (Rp)</th>
                                <th class="px-3 py-3 text-center font-extrabold text-[10px] text-emerald-200 uppercase tracking-wider border-r border-gray-700">Realisasi (%)</th>
                                <th class="px-3 py-3 text-center font-extrabold text-[10px] text-emerald-200 uppercase tracking-wider border-r border-gray-700">Fisik (%)</th>
                                <th class="px-3 py-3 text-center font-extrabold text-[10px] text-orange-200 uppercase tracking-wider border-r border-gray-700">Deviasi (%)</th>
                                
                                <th class="px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider border-r border-gray-700 w-[140px]">Dokumentasi & Laporan</th>
                                <th class="aksi-col hidden px-4 py-3 text-center font-bold text-[10px] uppercase tracking-wider w-[60px]">Aksi</th>
                            </tr>
                        </thead>

                        <!-- TBODY MINGGU KE-1 (M1) -->
                        <tbody id="tbody-m1" class="tbody-minggu divide-y divide-gray-200 bg-white">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-center text-xs font-semibold text-gray-700 border-r border-gray-200">1</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-6.2088</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">106.8456</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-[11px] font-bold text-gray-700 border-r border-gray-200 bg-gray-50/50">E-Purchasing</td>
                                
                                <td class="px-4 py-3 text-center text-[10px] font-semibold text-gray-600 border-r border-gray-200" data-start="2026-07-01" data-end="2026-07-07">
                                    01 Jul - 07 Jul 2026
                                </td>
                                
                                <td class="px-3 py-3 text-right text-xs font-bold text-blue-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-emerald-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-gray-800 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                
                                <td class="px-4 py-3 text-center border-r border-gray-200" data-foto="" data-laporan="">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link foto">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </a>
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link laporan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="aksi-col hidden px-2 py-3 text-center">
                                    <button onclick="hapusBaris(this.closest('tr'))" class="text-red-500 hover:text-white bg-red-50 hover:bg-red-500 p-2 rounded-lg transition-all shadow-sm" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="15" class="px-4 py-16 text-center border-b border-gray-200 bg-gray-50/30"></td></tr>
                        </tbody>

                        <!-- TBODY MINGGU KE-2 (M2) -->
                        <tbody id="tbody-m2" class="tbody-minggu divide-y divide-gray-200 bg-white hidden">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-center text-xs font-semibold text-gray-700 border-r border-gray-200">1</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">Data Program M2</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">Data Komponen M2</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-[11px] font-bold text-gray-700 border-r border-gray-200 bg-gray-50/50">E-Purchasing</td>
                                <td class="px-4 py-3 text-center text-[10px] font-semibold text-gray-600 border-r border-gray-200" data-start="2026-07-08" data-end="2026-07-14">08 Jul - 14 Jul 2026</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-blue-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-emerald-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-gray-800 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200" data-foto="" data-laporan="">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link foto"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></a>
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link laporan"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a>
                                    </div>
                                </td>
                                <td class="aksi-col hidden px-2 py-3 text-center">
                                    <button onclick="hapusBaris(this.closest('tr'))" class="text-red-500 hover:text-white bg-red-50 hover:bg-red-500 p-2 rounded-lg transition-all shadow-sm" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="15" class="px-4 py-16 text-center border-b border-gray-200 bg-gray-50/30"></td></tr>
                        </tbody>

                        <!-- TBODY MINGGU KE-3 (M3) -->
                        <tbody id="tbody-m3" class="tbody-minggu divide-y divide-gray-200 bg-white hidden">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-center text-xs font-semibold text-gray-700 border-r border-gray-200">1</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">Data Program M3</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">Data Komponen M3</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-[11px] font-bold text-gray-700 border-r border-gray-200 bg-gray-50/50">E-Purchasing</td>
                                <td class="px-4 py-3 text-center text-[10px] font-semibold text-gray-600 border-r border-gray-200" data-start="2026-07-15" data-end="2026-07-21">15 Jul - 21 Jul 2026</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-blue-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-emerald-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-gray-800 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200" data-foto="" data-laporan="">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link foto"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></a>
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link laporan"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a>
                                    </div>
                                </td>
                                <td class="aksi-col hidden px-2 py-3 text-center">
                                    <button onclick="hapusBaris(this.closest('tr'))" class="text-red-500 hover:text-white bg-red-50 hover:bg-red-500 p-2 rounded-lg transition-all shadow-sm" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="15" class="px-4 py-16 text-center border-b border-gray-200 bg-gray-50/30"></td></tr>
                        </tbody>

                        <!-- TBODY MINGGU KE-4 (M4) -->
                        <tbody id="tbody-m4" class="tbody-minggu divide-y divide-gray-200 bg-white hidden">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-center text-xs font-semibold text-gray-700 border-r border-gray-200">1</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">Data Program M4</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">Data Komponen M4</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200">-</td>
                                <td class="px-4 py-3 text-center text-[11px] font-bold text-gray-700 border-r border-gray-200 bg-gray-50/50">E-Purchasing</td>
                                <td class="px-4 py-3 text-center text-[10px] font-semibold text-gray-600 border-r border-gray-200" data-start="2026-07-22" data-end="2026-07-31">22 Jul - 31 Jul 2026</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-blue-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-right text-xs font-bold text-emerald-700 border-r border-gray-200">0</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-gray-800 border-r border-gray-200">0.00%</td>
                                <td class="px-3 py-3 text-center text-xs font-bold text-emerald-600 border-r border-gray-200">0.00%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200" data-foto="" data-laporan="">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link foto"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></a>
                                        <a href="javascript:void(0)" class="text-gray-300 cursor-not-allowed" title="Belum ada link laporan"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a>
                                    </div>
                                </td>
                                <td class="aksi-col hidden px-2 py-3 text-center">
                                    <button onclick="hapusBaris(this.closest('tr'))" class="text-red-500 hover:text-white bg-red-50 hover:bg-red-500 p-2 rounded-lg transition-all shadow-sm" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="15" class="px-4 py-16 text-center border-b border-gray-200 bg-gray-50/30"></td></tr>
                        </tbody>
                        
                        <!-- FOOTER TABEL (REKAP TOTAL) -->
                        <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                            <tr>
                                <td colspan="9" id="label-total" class="px-4 py-4 text-center text-xs font-extrabold text-gray-800 uppercase tracking-widest border-r border-gray-200 bg-gray-100/80">TOTAL M1</td>
                                <td class="px-3 py-4 text-right text-xs font-extrabold text-blue-800 border-r border-gray-200 bg-blue-50/40">0</td>
                                <td class="px-3 py-4 text-right text-xs font-extrabold text-blue-800 border-r border-gray-200 bg-blue-50/40">0</td>
                                <td class="px-3 py-4 text-center text-xs font-extrabold text-emerald-700 border-r border-gray-200 bg-emerald-50/30">0.00%</td>
                                <td class="px-3 py-4 text-center text-xs font-extrabold text-blue-800 border-r border-gray-200 bg-blue-50/30">0.00%</td>
                                <td class="px-3 py-4 text-center text-xs font-extrabold text-emerald-700 border-r border-gray-200 bg-emerald-50/30">0.00%</td>
                                
                                <!-- Kolom Kosong Untuk Area Dokumentasi -->
                                <td class="px-4 py-4 border-r border-gray-200 bg-gray-100/80"></td>
                                <!-- Kolom Kosong Untuk Area Aksi -->
                                <td class="aksi-col hidden px-4 py-4 bg-gray-100/80"></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>

            <!-- Panel Aksi Bawah (Edit Data) -->
            <div class="bg-white border border-gray-200 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm mb-8">
                <p class="text-sm text-gray-500 font-medium">Menampilkan data <span id="teks-menampilkan" class="font-extrabold text-gray-800">M1</span>. Klik tombol edit untuk mengubah data.</p>
                
                <div class="flex items-center gap-2">
                    <!-- Tombol Hapus (Disembunyikan default, hanya muncul saat di Tab M5) -->
                    <button id="btn-hapus-minggu" onclick="hapusMinggu()" class="hidden items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2.5 rounded-xl text-sm font-bold transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus M5
                    </button>
                    
                    <button id="btn-edit-data" onclick="toggleEditMode()" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md group">
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Data M1
                    </button>
                </div>
            </div>

            

        </main>
        @include('layouts.footer')
    </div>

<!-- SCRIPT UNTUK SWITCH TAB MINGGU & EDIT DATA -->
<script>
    let currentTab = 'm1';
    let isEditMode = false;

    // Fungsi Pembantu: Format "2026-07-01" -> "01 Jul 2026"
    function formatTanggalIndo(dateStr) {
        if (!dateStr) return '';
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const d = new Date(dateStr);
        if (isNaN(d)) return '';
        return `${String(d.getDate()).padStart(2, '0')} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

    function switchTab(minggu) {
        if (isEditMode) toggleEditMode(); // Matikan mode edit jika pindah tab

        currentTab = minggu;

        // 1. Reset & Aktifkan Tab
        document.querySelectorAll('.tab-minggu').forEach(btn => {
            btn.className = 'tab-minggu px-5 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-semibold text-sm rounded-xl whitespace-nowrap transition-all border border-transparent';
        });
        const activeTab = document.getElementById('tab-' + minggu);
        if(activeTab) {
            activeTab.className = 'tab-minggu px-5 py-2.5 bg-blue-50/80 text-blue-700 font-extrabold text-sm rounded-xl whitespace-nowrap border border-blue-100 transition-all';
        }

        // 2. Sembunyikan & Tampilkan Tbody
        document.querySelectorAll('.tbody-minggu').forEach(tbody => tbody.classList.add('hidden'));
        const activeTbody = document.getElementById('tbody-' + minggu);
        if(activeTbody) activeTbody.classList.remove('hidden');

        // 3. Update teks footer
        const labelMinggu = minggu.toUpperCase();
        document.getElementById('label-total').innerText = 'TOTAL ' + labelMinggu;
        document.getElementById('teks-menampilkan').innerText = labelMinggu;
        
        updateButtonVisual(false);

        // 4. Logika Tombol Hapus (Hanya muncul jika tab M5 aktif)
        const btnHapus = document.getElementById('btn-hapus-minggu');
        if (btnHapus) {
            if(minggu === 'm5') {
                btnHapus.classList.remove('hidden');
                btnHapus.classList.add('flex');
            } else {
                btnHapus.classList.add('hidden');
                btnHapus.classList.remove('flex');
            }
        }
    }

    function toggleEditMode() { 
            isEditMode = !isEditMode; 
            const tb = document.getElementById('tbody-' + currentTab); 
            document.querySelectorAll('.aksi-col').forEach(c => isEditMode ? c.classList.remove('hidden') : c.classList.add('hidden')); 
            Array.from(tb.children).filter(tr => !tr.querySelector('td[colspan]') && tr.id !== 'tr-tambah-baris').forEach(r => { 
                // Indeks diubah memasukkan angka 7 (Lokasi & urutan baru), Waktu jadi 8, Dokumen jadi 14
                [1,2,3,4,5,6,7,9,10,11,12,13].forEach(i => { 
                    const c = r.children[i]; 
                    if(isEditMode) { 
                        c.setAttribute('contenteditable','true'); 
                        c.classList.add('bg-yellow-50','border','border-yellow-400','cursor-text','focus:ring-2','focus:ring-yellow-500','focus:outline-none','shadow-inner'); 
                    } else { 
                        c.removeAttribute('contenteditable'); 
                        c.classList.remove('bg-yellow-50','border','border-yellow-400','cursor-text','focus:ring-2','focus:ring-yellow-500','focus:outline-none','shadow-inner'); 
                    } 
                }); 
                const wt = r.children[8]; // Waktu geser ke index 8
                if(isEditMode) { 
                    wt.classList.add('bg-yellow-50'); 
                    wt.innerHTML = `<div class="flex flex-col gap-1.5 p-1"><input type="date" class="start-date text-[10px] p-1 border border-yellow-400 bg-white rounded" value="${wt.getAttribute('data-start')||''}"><input type="date" class="end-date text-[10px] p-1 border border-yellow-400 bg-white rounded" value="${wt.getAttribute('data-end')||''}"></div>`; 
                } else { 
                    wt.classList.remove('bg-yellow-50'); 
                    const s = wt.querySelector('.start-date'), e = wt.querySelector('.end-date'); 
                    if(s && e) { wt.setAttribute('data-start', s.value); wt.setAttribute('data-end', e.value); } 
                    const ns = wt.getAttribute('data-start'), ne = wt.getAttribute('data-end'); 
                    wt.innerHTML = (ns&&ne) ? `${formatTanggalIndo(ns)} - ${formatTanggalIndo(ne)}` : '-'; 
                } 
                const dok = r.children[14]; // Dokumen geser ke index 14
                if(isEditMode) { 
                    dok.classList.add('bg-yellow-50'); 
                    dok.innerHTML = `<div class="flex flex-col gap-1.5 p-1"><input type="url" class="link-foto text-[10px] p-1 border border-yellow-400 bg-white" placeholder="URL Foto" value="${dok.getAttribute('data-foto')||''}"><input type="url" class="link-laporan text-[10px] p-1 border border-yellow-400 bg-white" placeholder="URL Laporan" value="${dok.getAttribute('data-laporan')||''}"></div>`; 
                } else { 
                    dok.classList.remove('bg-yellow-50'); 
                    const f = dok.querySelector('.link-foto'), l = dok.querySelector('.link-laporan'); 
                    if(f && l) { dok.setAttribute('data-foto', f.value.trim()); dok.setAttribute('data-laporan', l.value.trim()); } 
                    const ff = dok.getAttribute('data-foto'), fl = dok.getAttribute('data-laporan'); 
                    dok.innerHTML = `<div class="flex items-center justify-center gap-3"><a href="${ff||'javascript:void(0)'}" class="${ff?'text-blue-500 hover:text-blue-700':'text-gray-300 cursor-not-allowed'}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></a><a href="${fl||'javascript:void(0)'}" class="${fl?'text-emerald-500 hover:text-emerald-700':'text-gray-300 cursor-not-allowed'}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></a></div>`; 
                } 
            }); 
            if(isEditMode) { 
                const sp = Array.from(tb.children).find(tr => tr.querySelector('td[colspan]') && tr.id !== 'tr-tambah-baris'); 
                const ad = document.createElement('tr'); 
                ad.id = 'tr-tambah-baris'; 
                ad.className = 'group cursor-pointer hover:bg-blue-50/50 transition-colors'; 
                ad.onclick = tambahBarisInline; 
                // Colspan diubah jadi 15 (karena nambah kolom lokasi)
                ad.innerHTML = `<td class="px-4 py-3 text-center border-r border-gray-200"><div class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg></div></td><td colspan="15" class="px-4 py-3 text-xs font-bold text-blue-600 border-dashed border-2 border-transparent group-hover:border-blue-200">Tambah baris data baru...</td>`; 
                if(sp) tb.insertBefore(ad, sp); else tb.appendChild(ad); 
            } else { 
                const ad = document.getElementById('tr-tambah-baris'); 
                if(ad) ad.remove(); 
            } 
            updateButtonVisual(isEditMode); 
        }

    // FUNGSI UNTUK MENGHAPUS BARIS
    function hapusBaris(rowElement) {
        if(confirm('Apakah Anda yakin ingin menghapus baris data ini?')) {
            rowElement.remove();
            urutkanNomor(); // Panggil fungsi re-numbering
        }
    }

    // FUNGSI UNTUK MENGURUTKAN KEMBALI NOMOR SAAT DITAMBAH/DIHAPUS
    function urutkanNomor() {
        const activeTbody = document.getElementById('tbody-' + currentTab);
        const dataRows = Array.from(activeTbody.children).filter(tr => 
            !tr.querySelector('td[colspan]') && tr.id !== 'tr-tambah-baris'
        );

        dataRows.forEach((tr, index) => {
            tr.children[0].innerText = index + 1; // Ubah teks pada kolom 'No'
        });
    }

    // FUNGSI UNTUK MENAMBAH BARIS DATA BARU (SUDAH DIPISAH KOLOMNYA)
    function tambahBarisInline() { const tb = document.getElementById('tbody-' + currentTab), ad = document.getElementById('tr-tambah-baris'), tr = document.createElement('tr'); tr.className = 'hover:bg-gray-50'; const ec = "px-4 py-3 text-center text-xs font-medium text-gray-600 border-r border-gray-200 bg-yellow-50 border border-yellow-400 cursor-text focus:ring-2 focus:ring-yellow-500 focus:outline-none shadow-inner"; tr.innerHTML = `<td class="px-4 py-3 text-center text-xs font-semibold border-r">-</td><td class="${ec}" contenteditable="true">-</td><td class="${ec}" contenteditable="true">-</td><td class="${ec}" contenteditable="true">-</td><td class="${ec}" contenteditable="true">-</td><td class="${ec}" contenteditable="true">-</td><td class="${ec}" contenteditable="true">-</td><td class="${ec}" contenteditable="true">E-Purchasing</td><td class="px-2 py-2 border-r bg-yellow-50"><div class="flex flex-col gap-1.5 p-1"><input type="date" class="start-date text-[10px] p-1 border border-yellow-400"><input type="date" class="end-date text-[10px] p-1 border border-yellow-400"></div></td><td class="${ec} text-right text-blue-700 font-bold" contenteditable="true">0</td><td class="${ec} text-right text-emerald-700 font-bold" contenteditable="true">0</td><td class="${ec} text-emerald-600 font-bold" contenteditable="true">0.00%</td><td class="${ec} text-gray-800 font-bold" contenteditable="true">0.00%</td><td class="${ec} text-emerald-600 font-bold" contenteditable="true">0.00%</td><td class="px-2 py-2 border-r bg-yellow-50"><div class="flex flex-col gap-1.5 p-1"><input type="url" class="link-foto text-[10px] p-1.5 border border-yellow-400"><input type="url" class="link-laporan text-[10px] p-1.5 border border-yellow-400"></div></td><td class="aksi-col px-2 py-3 text-center"><button onclick="hapusBaris(this.closest('tr'))" class="text-red-500 hover:text-white bg-red-50 hover:bg-red-500 p-2 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button></td>`; tb.insertBefore(tr, ad); urutkanNomor(); tr.children[1].focus(); }
    
    function updateButtonVisual(isEditing) {
        const btnEdit = document.getElementById('btn-edit-data');
        const labelMinggu = currentTab.toUpperCase();

        if (isEditing) {
            btnEdit.innerHTML = `
                <svg class="w-4 h-4 text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Data ${labelMinggu}
            `;
            btnEdit.className = "flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md group";
        } else {
            btnEdit.innerHTML = `
                <svg class="w-4 h-4 text-gray-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Data ${labelMinggu}
            `;
            btnEdit.className = "flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md group";
        }
    }

    // Simpan jumlah minggu bawaan (dimulai dari 4)
    let totalMinggu = 4;
    const MAKSIMAL_MINGGU = 5;

    function tambahMinggu() {
        if (totalMinggu >= MAKSIMAL_MINGGU) return; // Batasi maksimal 5

        // 1. Tambah Counter
        totalMinggu++;
        let idBaru = 'm' + totalMinggu;
        let labelBaru = `Minggu Ke-${totalMinggu} (${idBaru.toUpperCase()})`;

        // 2. Buat Tab Button Baru
        let containerTab = document.getElementById('tabs-container');
        let btnPlus = document.getElementById('btn-tambah-minggu');
        
        let tabBaru = document.createElement('button');
        tabBaru.id = 'tab-' + idBaru;
        tabBaru.className = 'tab-minggu px-5 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-semibold text-sm rounded-xl whitespace-nowrap transition-all border border-transparent cursor-pointer';
        tabBaru.innerText = labelBaru;
        tabBaru.onclick = function() { switchTab(idBaru); };
        
        containerTab.insertBefore(tabBaru, btnPlus);

        // 3. Clone (Gandakan) Tabel Tbody
        let tabelDetail = document.getElementById('tabel-detail');
        let tbodyM1 = document.getElementById('tbody-m1'); 
        
        let tbodyBaru = tbodyM1.cloneNode(true);
        tbodyBaru.id = 'tbody-' + idBaru;
        tbodyBaru.classList.add('hidden');
        
        let cells = tbodyBaru.querySelectorAll('td');
        cells.forEach(cell => {
            if(cell.innerText !== '1' && !cell.innerHTML.includes('<svg')) {
                if(cell.innerText.includes('%')) cell.innerText = '0.00%';
                else if(cell.innerText === '0' || !isNaN(cell.innerText)) cell.innerText = '0';
                else cell.innerText = '-';
            }
        });

        let tfoot = tabelDetail.querySelector('tfoot');
        tabelDetail.insertBefore(tbodyBaru, tfoot);

        // Sembunyikan tombol (+) jika sudah mencapai batas maksimal
        if (totalMinggu === MAKSIMAL_MINGGU) {
            btnPlus.style.display = 'none';
        }

        // 4. Pindah ke tab yang baru dibuat secara otomatis
        switchTab(idBaru);

        alert(`${labelBaru} berhasil ditambahkan!`);
    }

    function hapusMinggu() {
        if (totalMinggu <= 4) return; // M1-M4 tidak bisa dihapus
        
        if(confirm(`Apakah Anda yakin ingin menghapus Minggu Ke-${totalMinggu}?`)) {
            let idHapus = 'm' + totalMinggu;
            
            // Hapus Element Tab HTML
            let tab = document.getElementById('tab-' + idHapus);
            if(tab) tab.remove();
            
            // Hapus Element Tbody HTML
            let tbody = document.getElementById('tbody-' + idHapus);
            if(tbody) tbody.remove();
            
            totalMinggu--;
            
            // Munculkan kembali tombol (+)
            let btnPlus = document.getElementById('btn-tambah-minggu');
            if(btnPlus) btnPlus.style.display = 'flex';
            
            // Pindah otomatis kembali ke tab sebelumnya
            switchTab('m' + totalMinggu);
        }
    }
</script>
</body>
</html>