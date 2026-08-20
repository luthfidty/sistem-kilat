<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Chart.js untuk Diagram -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Sembunyikan atribusi Leaflet bawaan agar UI bersih */
        .leaflet-control-attribution { display: none !important; }
        
        /* Hilangkan focus outline biru pada Leaflet saat di-klik */
        .leaflet-container:focus { outline: none; }

        /* OVERRIDE STYLE POPUP LEAFLET AGAR MODERN */
        .leaflet-popup-content-wrapper {
            padding: 0 !important; 
            border-radius: 1rem !important; 
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        .leaflet-popup-content {
            margin: 0 !important; 
            width: auto !important;
        }
        .leaflet-popup-close-button {
            margin-top: 8px !important;
            margin-right: 8px !important;
            color: #9ca3af !important;
        }
        .leaflet-popup-close-button:hover {
            color: #1f2937 !important;
        }
        .leaflet-popup-tip {
            box-shadow: none !important; 
        }

        /* TAMPILAN KHUSUS SAAT PRINT DOCUMENT (CTRL+P) */
        @media print {
            body * {
                visibility: hidden;
            }
            #area-cetak-laporan, #area-cetak-laporan * {
                visibility: visible;
            }
            #area-cetak-laporan {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none !important;
            }
            .no-print {
                display: none !important;
            }
            /* Hilangkan background abu-abu saat print modal */
            #modalLaporanContent {
                box-shadow: none !important;
                max-width: 100% !important;
            }
        }
        .sidebar-aware-header {
            left: 72px;
            width: calc(100% - 72px);
        }

        /* Sidebar expanded */
        aside:hover ~ .sidebar-aware-header {
            left: 256px;
            width: calc(100% - 256px);
        }
        .dashboard-content {
            margin-left: 72px;
            width: calc(100% - 72px);
            transition: 
                margin-left 300ms ease-in-out,
                width 300ms ease-in-out;
        }

        /* Sidebar sedang terbuka */
        aside:hover ~ .dashboard-content {
            margin-left: 256px;
            width: calc(100% - 256px);
        }
    </style>
</head>
<body class="bg-[#e2e6eb] min-h-screen font-sans text-gray-800 relative overflow-x-hidden" x-data="{ showEwsModal: true }">
    
    @include('layouts.sidebar')
    <div class="dashboard-content">
        @include('layouts.header')
    <!-- ========================================== -->
    <!-- BAGIAN 1: PETA FULL SCREEN (HERO SECTION)  -->
    <!-- ========================================== -->
    <div class="relative w-full h-[calc(100vh-76px)] z-0 no-print">
        <div id="map" class="w-full h-full"></div>

        <div class="absolute inset-x-0 bottom-0 h-48 
                    bg-gradient-to-t from-[#e2e6eb] to-transparent 
                    z-10 pointer-events-none">
        </div>

        <div class="absolute bottom-32 left-6 z-10 
                    bg-black/60 border border-white/20 text-white 
                    px-5 py-2.5 rounded-full flex items-center 
                    shadow-[0_4px_15px_rgba(0,0,0,0.5)] 
                    pointer-events-none">

            <span class="w-3 h-3 rounded-full bg-red-500 animate-ping mr-3"></span>
            <span class="w-3 h-3 rounded-full bg-red-500 absolute mr-3"></span>

            <span class="text-xs font-bold uppercase tracking-widest ml-4">
                Live Geotagging
            </span>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- BAGIAN 2: KONTEN DASHBOARD (SCROLL BAWAH)  -->
    <!-- ========================================== -->
    <main class="container mx-auto px-6 relative z-20 -mt-32 pb-16 no-print">
        
        <!-- Header Judul Halaman -->
        <div class="bg-white/60 border border-white/80 p-6 rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.08)] mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight drop-shadow-sm">Dashboard KILAT</h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-600 text-xs font-bold bg-white/80 px-3 py-1.5 rounded-md border border-white shadow-sm uppercase tracking-wide">Monitoring Anggaran & Pemeriksaan</span>
                </div>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="flex items-center gap-3">
                <!-- Tombol Preview Laporan (Document View) -->
                <button type="button" onclick="bukaModalLaporan()" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1 text-sm flex items-center gap-2 border border-red-500 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Preview Laporan
                </button>
                <!-- Tombol Input Rincian -->
                <button type="button" onclick="openModalInput()" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3.5 px-8 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1 text-sm flex items-center gap-2 border border-gray-700 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Input
                </button>
            </div>
        </div>

        <!-- Grid Informasi Bawah (Pagu & Pantauan) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Box Pagu Anggaran -->
            <div class="bg-white/50 border border-white/80 p-8 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)] lg:col-span-1 flex flex-col justify-between group hover:bg-white/70 transition-colors relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-gradient-to-br from-gray-200 to-white rounded-full mix-blend-overlay filter opacity-60"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="bg-white/80 p-3 rounded-xl shadow-sm border border-white">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-sm font-extrabold text-gray-700 uppercase tracking-widest">Pagu Anggaran Pemeriksaan</h2>
                    </div>
                    <p class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">Rp 15.5 M</p>
                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Sisa Anggaran: Rp 4.2 M</p>
                </div>
                
                <div class="mt-8 flex items-center text-xs font-bold bg-white/70 w-max px-4 py-2 rounded-full border border-white shadow-sm relative z-10">
                    <span class="w-2.5 h-2.5 rounded-full bg-gray-800 mr-2 animate-pulse"></span>
                    <span class="text-gray-800 uppercase tracking-wide">Tersedia T.A. {{ date('Y') }}</span>
                </div>
            </div>

            <!-- Box Things To Do / TAF Pantauan -->
            <div class="bg-white/50 border border-white/80 p-8 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)] lg:col-span-2">
                <h2 class="text-sm font-extrabold text-gray-700 uppercase tracking-widest mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Tugas & Pantauan TAF (Tentative Audit Finding)
                </h2>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-4 bg-white/60 hover:bg-white transition-colors p-5 rounded-2xl border border-white shadow-sm">
                        <div class="mt-0.5">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600 font-bold text-xs">!</span>
                        </div>
                        <div>
                            <p class="text-base text-gray-900 font-extrabold mb-1">Arahan Pimpinan Dibutuhkan</p>
                            <p class="text-sm text-gray-600 font-medium">Temuan pengadaan barang di Kaltim (Potensi kerugian Rp 1.2M).</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 bg-white/60 hover:bg-white transition-colors p-5 rounded-2xl border border-white shadow-sm">
                        <div class="mt-0.5">
                            <input type="checkbox" class="w-6 h-6 text-gray-900 border-gray-400 rounded-md focus:ring-gray-900 cursor-pointer bg-white">
                        </div>
                        <div>
                            <p class="text-base text-gray-900 font-extrabold mb-1">Klarifikasi Tim Pemeriksa Luar Kota</p>
                            <p class="text-sm text-gray-600 font-medium">Tim Audit B belum menyampaikan TAF mingguan.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- BAGIAN 3: FILTER & DIAGRAM                 -->
        <!-- ========================================== -->
        <div class="bg-white/60 border border-white/80 p-5 rounded-2xl shadow-[0_10px_30px_rgb(0,0,0,0.05)] mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Visualisasi
            </h2>
            <div class="flex gap-3 w-full sm:w-auto">
                <select id="filterMinggu" class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-gray-800 focus:border-gray-800 block w-full sm:w-auto p-2.5 font-semibold cursor-pointer transition-all">
                    <option value="all" selected>Semua Minggu</option>
                    <option value="1">Minggu Ke-1</option>
                    <option value="2">Minggu Ke-2</option>
                    <option value="3">Minggu Ke-3</option>
                    <option value="4">Minggu Ke-4</option>
                </select>
                <select id="filterBulan" class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-gray-800 focus:border-gray-800 block w-full sm:w-auto p-2.5 font-semibold cursor-pointer">
                    <option value="all">Sepanjang Tahun (12 Bulan)</option>
                    <option value="7" selected>Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                </select>
                <select id="filterTahun" class="bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-gray-800 focus:border-gray-800 block w-full sm:w-auto p-2.5 font-semibold cursor-pointer">
                    <option value="2026" selected>2026</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>

       <!-- Grid Diagram (Line & Gabungan 2 Pie) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Diagram Garis -->
            <div class="bg-white/50 border border-white/80 p-8 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)] flex flex-col">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h3 class="text-xs font-bold text-gray-600 uppercase tracking-widest">
                        Grafik Progres Capaian
                    </h3>
                    <div class="inline-flex p-1 bg-gray-200/60 rounded-xl text-xs font-semibold">
                        <button onclick="updateLineChart('gabungan')" id="btn-gabungan" class="px-3 py-1.5 rounded-lg bg-white shadow-sm text-gray-800 transition-all">Gabungan</button>
                        <button onclick="updateLineChart('ppk')" id="btn-ppk" class="px-3 py-1.5 rounded-lg text-gray-500 hover:text-gray-800 transition-all">PPK Trans</button>
                        <button onclick="updateLineChart('pemt')" id="btn-pemt" class="px-3 py-1.5 rounded-lg text-gray-500 hover:text-gray-800 transition-all">PEMT</button>
                    </div>
                </div>
                <div class="relative w-full flex-grow min-h-[250px]">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            
            <!-- 2 Diagram Pie -->
            <div class="bg-white/50 border border-white/80 p-8 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)] flex flex-col">
                <h3 class="text-xs font-bold text-gray-600 uppercase tracking-widest mb-6 text-center">
                    Komparasi Pagu, Realisasi, Fisik & Deviasi
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 flex-grow items-center">
                    <div class="flex flex-col items-center">
                        <span class="bg-gray-100/80 border border-gray-200 text-gray-600 px-4 py-1.5 rounded-full text-[10px] font-bold tracking-wider mb-4 shadow-sm">
                            DITJEN. PPK TRANS
                        </span>
                        <div class="relative w-full flex justify-center h-[200px]">
                            <canvas id="pieChartPpkTrans"></canvas>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="bg-gray-100/80 border border-gray-200 text-gray-600 px-4 py-1.5 rounded-full text-[10px] font-bold tracking-wider mb-4 shadow-sm">
                            DITJEN. PEMT
                        </span>
                        <div class="relative w-full flex justify-center h-[200px]">
                            <canvas id="pieChartPemt"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- BAGIAN 4 & 5: KILAT DASHBOARD KHUSUS AUDIT & PEMERIKSAAN -->
        <!-- ======================================================== -->
        
        <div class="mt-12 mb-6 flex items-center justify-between border-b border-gray-300 pb-4">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Rincian Modul KILAT (Audit)</h2>
        </div>

        <!-- Modul 2 & 3: Grid Tindak Lanjut & Kerugian Negara -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/60 border border-white/80 p-6 rounded-3xl shadow-[0_10px_30px_rgb(0,0,0,0.05)] relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-green-100 rounded-bl-[100px] opacity-50"></div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Tindak Lanjut Selesai</h3>
                <p class="text-3xl font-extrabold text-gray-900 mb-2">68%</p>
                <p class="text-xs text-gray-600 font-medium">Status 1 & 4 (Total: 145 Rekomendasi)</p>
            </div>
            <div class="bg-white/60 border border-white/80 p-6 rounded-3xl shadow-[0_10px_30px_rgb(0,0,0,0.05)] relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-100 rounded-bl-[100px] opacity-50"></div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Proses & Belum TL</h3>
                <p class="text-3xl font-extrabold text-gray-900 mb-2">32%</p>
                <p class="text-xs text-gray-600 font-medium">Status 2 & 3 (Total: 68 Rekomendasi)</p>
            </div>
            <div class="bg-white/60 border border-white/80 p-6 rounded-3xl shadow-[0_10px_30px_rgb(0,0,0,0.05)] relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-red-100 rounded-bl-[100px] opacity-50"></div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Kerugian Negara (Sisa)</h3>
                <p class="text-2xl font-extrabold text-gray-900 mb-2">Rp 4.5 M</p>
                <p class="text-xs text-gray-600 font-medium">Dari Total 12 Kasus Berjalan</p>
            </div>
            <div class="bg-white/60 border border-white/80 p-6 rounded-3xl shadow-[0_10px_30px_rgb(0,0,0,0.05)] relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-100 rounded-bl-[100px] opacity-50"></div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Telah Dipulihkan/Lunas</h3>
                <p class="text-2xl font-extrabold text-gray-900 mb-2">Rp 12.1 M</p>
                <p class="text-xs text-gray-600 font-medium">73% Persentase Pemulihan</p>
            </div>
        </div>

        <!-- Modul 1 & 4 Row -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
            <!-- Modul 1: Monitoring Tim Pemeriksa & TAF -->
            <div class="bg-white/50 border border-white/80 p-8 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest">Modul 1: Tim Pemeriksa & TAF</h2>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase">5 Tim Aktif</span>
                </div>
                
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-50 uppercase bg-gray-800 rounded-t-xl">
                            <tr>
                                <th scope="col" class="px-4 py-3 rounded-tl-xl">Tim & Pemeriksa</th>
                                <th scope="col" class="px-4 py-3">Lokasi (Durasi)</th>
                                <th scope="col" class="px-4 py-3">Serapan Anggaran</th>
                                <th scope="col" class="px-4 py-3 rounded-tr-xl">Status TAF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white/60 border-b border-gray-200/50 hover:bg-white/90">
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900">Tim Audit Alpha</p>
                                    <p class="text-[10px] text-gray-500">ST-092/2026</p>
                                </td>
                                <td class="px-4 py-3">Luar Kota <br><span class="text-xs font-semibold text-gray-500">14 Hari</span></td>
                                <td class="px-4 py-3"><span class="text-emerald-600 font-bold">Aman</span></td>
                                <td class="px-4 py-3"><span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded font-bold">Klarifikasi</span></td>
                            </tr>
                            <tr class="bg-white/60 border-b border-gray-200/50 hover:bg-white/90">
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900">Tim Audit Bravo</p>
                                    <p class="text-[10px] text-gray-500">ST-095/2026</p>
                                </td>
                                <td class="px-4 py-3">Dalam Kota <br><span class="text-xs font-semibold text-gray-500">7 Hari</span></td>
                                <td class="px-4 py-3"><span class="text-red-600 font-bold">Deviasi > 10%</span></td>
                                <td class="px-4 py-3"><span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded font-bold">Arahan Pimpinan</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modul 4: Database Entitas Pemeriksaan (DEP) -->
            <div class="bg-white/50 border border-white/80 p-8 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)]">
                <h2 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest mb-6">Modul 4: Database Entitas Pemeriksaan (DEP)</h2>
                <div class="space-y-3" x-data="{ active: null }">
                    <div class="bg-white/80 border border-gray-200 rounded-2xl overflow-hidden">
                        <button @click="active = active === 1 ? null : 1" class="w-full px-5 py-4 text-left flex justify-between items-center focus:outline-none">
                            <span class="font-extrabold text-gray-900 text-sm">Entitas: KEMENTERIAN TRANSMIGRASI (Pusdatin)</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{'rotate-180': active === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="active === 1" x-collapse class="px-5 pb-4 text-sm text-gray-700" style="display: none;">
                            <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-3 mt-1">
                                <div><span class="block text-[10px] font-bold text-gray-400 uppercase">Pejabat Kunci</span><p class="font-semibold">Bpk. Menteri / Kepala Badan</p></div>
                                <div><span class="block text-[10px] font-bold text-gray-400 uppercase">Kendaraan Politik</span><span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-xs font-bold">Non-Partisan</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Memanggil Footer -->
    @include('layouts.footer')

    <!-- ========================================== -->
    <!-- MODAL PREVIEW LAPORAN (TAMPILAN DOKUMEN A4)-->
    <!-- ========================================== -->
    <div id="modalLaporanOverlay" class="fixed inset-0 z-[110] hidden items-start justify-center p-4 sm:p-10 bg-gray-900/80 backdrop-blur-sm overflow-y-auto transition-opacity duration-300 opacity-0">
        
        <!-- Toolbar Atas Kertas -->
        <div class="fixed top-4 right-8 z-[120] flex gap-3 no-print">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Dokumen
            </button>
            <button onclick="tutupModalLaporan()" class="bg-white hover:bg-gray-100 text-gray-800 font-bold py-2.5 px-5 rounded-xl shadow-lg transition-colors border border-gray-200">
                Tutup Laporan
            </button>
        </div>

        <!-- Kertas Laporan / A4 Format -->
        <div id="modalLaporanContent" class="bg-white w-full max-w-4xl min-h-[1056px] my-10 p-10 sm:p-16 rounded-sm shadow-2xl transform transition-transform duration-300 scale-95 relative mx-auto font-serif text-gray-900">
            
            <div id="area-cetak-laporan" class="w-full h-full flex flex-col justify-between">
                <div>
                    <!-- KOP SURAT -->
                    <div class="flex flex-col items-center justify-center border-b-4 border-black pb-4 mb-8 text-center">
                        <h2 class="text-xl sm:text-2xl font-black uppercase tracking-wide">Kementerian Transmigrasi Republik Indonesia</h2>
                        <h3 class="text-lg sm:text-xl font-bold uppercase mt-1">Pusat Data dan Informasi (Pusdatin)</h3>
                        <p class="text-sm mt-2 font-sans text-gray-700">Gedung Kementerian, Jl. TMP Kalibata No.17, Jakarta Selatan</p>
                    </div>

                    <!-- JUDUL DOKUMEN -->
                    <div class="text-center mb-10">
                        <h4 class="text-lg font-bold underline uppercase">Laporan Monitoring Anggaran dan Pemeriksaan KILAT</h4>
                        <p class="text-sm mt-1">Periode Pantauan: Bulan Berjalan T.A. 2026</p>
                    </div>

                    <!-- ISI RINGKASAN DATA -->
                    <div class="space-y-6 text-sm sm:text-base leading-relaxed text-justify mb-10">
                        <p>
                            Berdasarkan hasil pantauan sistem *Dashboard KILAT* (Modul Monitoring Anggaran & Pemeriksaan), berikut disampaikan rincian perkembangan realisasi tugas dan anggaran:
                        </p>
                        
                        <div class="pl-4">
                            <p class="font-bold mb-2">1. Rangkuman Anggaran dan Realisasi (Modul 1)</p>
                            <ul class="list-disc pl-6 space-y-1 mb-4">
                                <li><strong>Pagu Tersedia:</strong> Rp 15.500.000.000,-</li>
                                <li><strong>Sisa Anggaran:</strong> Rp 4.200.000.000,-</li>
                                <li><strong>Status Tim:</strong> Terdapat 5 Tim Pemeriksa yang sedang bertugas di dalam dan luar kota.</li>
                            </ul>

                            <p class="font-bold mb-2">2. Status Tindak Lanjut dan Kerugian Negara (Modul 2 & 3)</p>
                            <ul class="list-disc pl-6 space-y-1 mb-4">
                                <li><strong>Tindak Lanjut:</strong> 68% rekomendasi telah diselesaikan, sementara 32% masih dalam proses.</li>
                                <li><strong>Pemulihan Kerugian:</strong> Dana senilai Rp 12.100.000.000,- telah berhasil dipulihkan (73% rasio pemulihan).</li>
                                <li><strong>Sisa Kasus:</strong> Terdapat potensi sisa kerugian berjalan sebesar Rp 4.500.000.000,- yang sedang didalami oleh Tim Audit.</li>
                            </ul>
                        </div>
                        
                        <p>
                            Laporan rekapitulasi data ini digenerasikan secara sistem dan telah divalidasi kebenarannya untuk dapat dipergunakan sebagaimana mestinya sebagai bahan pertimbangan pimpinan.
                        </p>
                    </div>
                </div>

                <!-- LEMBAR PENGESAHAN / TANGGUNG JAWAB (TETAP DI BAGIAN BAWAH) -->
                <div class="mt-16 flex flex-col sm:flex-row justify-between text-sm sm:text-base">
                    <div class="text-center w-full sm:w-1/2 mb-10 sm:mb-0">
                        <p>Mengetahui,</p>
                        <p class="font-bold">Kepala Pusat Data dan Informasi</p>
                        <div class="h-24"></div> <!-- Jarak TTD -->
                        <p class="font-bold underline">(...................................................)</p>
                        <p>NIP. ...............................................</p>
                    </div>
                    
                    <div class="text-center w-full sm:w-1/2">
                        <p>Jakarta, 10 Agustus 2026</p>
                        <p class="font-bold">Penanggung Jawab Sistem / Pelapor</p>
                        <div class="h-24"></div> <!-- Jarak TTD -->
                        <p class="font-bold underline">M. Luthfi Aditya Gunandi</p>
                        <p>Web Developer & Pengelola Pusdatin</p>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- MODAL POP UP EWS (TETAP) -->
    <div x-show="showEwsModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 no-print" style="display: none;" x-cloak>
        <div class="absolute inset-0 bg-gray-900/60" @click="showEwsModal = false"></div>
        <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl max-w-md w-full relative z-10 text-center transform transition-all">
            <h3 class="text-2xl font-extrabold text-gray-900 mb-3 tracking-tight">Peringatan Realisasi</h3>
            <button @click="showEwsModal = false" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 px-4 rounded-2xl transition-all shadow-lg transform hover:-translate-y-1 text-sm tracking-wide">
                Mengerti & Isi Sekarang
            </button>
        </div>
    </div>
    </div>
    

    <!-- Script JavaScript Terpadu -->
    <script>
        // SCRIPT MAP LEAFLET
        var indonesiaBounds = L.latLngBounds(L.latLng(-11.0, 94.0), L.latLng(6.0, 141.0));
        var map = L.map('map', {zoomControl: false, maxBounds: indonesiaBounds, maxBoundsViscosity: 1.0, minZoom: 5}).setView([-2.0, 118.0], 5);
        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {maxZoom: 20}).addTo(map);

        var aestheticIcon = L.divIcon({className: 'custom-icon', html: '<div style="background-color: white; width: 16px; height: 16px; border-radius: 50%; border: 4px solid #1f2937; box-shadow: 0 0 10px rgba(0,0,0,0.5);"></div>', iconSize: [16, 16], iconAnchor: [8, 8]});
        var marker1 = L.marker([-6.2088, 106.8456], {icon: aestheticIcon}).addTo(map);

        // ==========================================
        // FUNGSI KONTROL MODAL DOKUMEN / LAPORAN
        // ==========================================
        function bukaModalLaporan() {
            const overlay = document.getElementById('modalLaporanOverlay');
            const content = document.getElementById('modalLaporanContent');
            
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function tutupModalLaporan() {
            const overlay = document.getElementById('modalLaporanOverlay');
            const content = document.getElementById('modalLaporanContent');

            overlay.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }, 300);
        }

        // Tutup modal jika layar hitam diklik
        document.addEventListener('DOMContentLoaded', function() {
            const overlayLaporan = document.getElementById('modalLaporanOverlay');
            if(overlayLaporan) {
                overlayLaporan.addEventListener('click', function(event) {
                    if (event.target === overlayLaporan) tutupModalLaporan();
                });
            }
        });

        // SCRIPT CHART.JS (Grafik Tetap Sesuai Permintaan)
        const chartData = {
            gabungan: { pagu: [25, 50, 75, 100], realisasi: [20, 42, 65, 85], fisik: [15, 38, 70, 92], deviasi: [-5, -8, -5, 7] },
            ppk: { pagu: [25, 50, 75, 100], realisasi: [18, 38, 60, 80], fisik: [12, 35, 65, 88], deviasi: [-7, -12, -10, 8] },
            pemt: { pagu: [25, 50, 75, 100], realisasi: [22, 46, 70, 90], fisik: [18, 41, 75, 96], deviasi: [-3, -4, 0, 6] }
        };

        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const myLineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [
                    { label: 'Pagu', data: chartData.gabungan.pagu, borderColor: '#1f2937', backgroundColor: '#1f2937', borderWidth: 2, tension: 0.4 },
                    { label: 'Realisasi', data: chartData.gabungan.realisasi, borderColor: '#4b5563', backgroundColor: '#4b5563', borderWidth: 2, tension: 0.4 },
                    { label: 'Fisik', data: chartData.gabungan.fisik, borderColor: '#9ca3af', backgroundColor: '#9ca3af', borderWidth: 2, borderDash: [5, 5], tension: 0.4 },
                    { label: 'Deviasi', data: chartData.gabungan.deviasi, borderColor: '#ef4444', backgroundColor: '#ef4444', borderWidth: 2, tension: 0.4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, plugins: { legend: { position: 'bottom' } } }
        });

        function updateLineChart(unit) {
            myLineChart.data.datasets[0].data = chartData[unit].pagu;
            myLineChart.data.datasets[1].data = chartData[unit].realisasi;
            myLineChart.data.datasets[2].data = chartData[unit].fisik;
            myLineChart.data.datasets[3].data = chartData[unit].deviasi;
            myLineChart.update();
        }

        const getLayeredDoughnutConfig = (realisasi, deviasi, fisik) => {
            const sisaRealisasi = 100 - (realisasi + deviasi);
            const sisaFisik = 100 - fisik;
            return {
                type: 'doughnut',
                data: {
                    labels: ['Tercapai', 'Deviasi', 'Sisa'], 
                    datasets: [
                        { label: 'Pagu', data: [100, 0, 0], backgroundColor: ['#1f2937', 'rgba(0,0,0,0)', 'rgba(0,0,0,0)'], borderWidth: 2, borderColor: '#ffffff' },
                        { label: 'Realisasi & Deviasi', data: [realisasi, deviasi, sisaRealisasi], backgroundColor: ['#4b5563', '#ef4444', '#f3f4f6'], borderWidth: 2, borderColor: '#ffffff' },
                        { label: 'Fisik', data: [fisik, 0, sisaFisik], backgroundColor: ['#9ca3af', 'rgba(0,0,0,0)', '#f3f4f6'], borderWidth: 2, borderColor: '#ffffff' }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '30%', plugins: { legend: { display: false } } }
            };
        };

        new Chart(document.getElementById('pieChartPpkTrans').getContext('2d'), getLayeredDoughnutConfig(40, 15, 55));
        new Chart(document.getElementById('pieChartPemt').getContext('2d'), getLayeredDoughnutConfig(60, 5, 65));
    </script>
    
    @include('modal-input')
</body>
</html>