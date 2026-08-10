<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matriks PPK Trans - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .header-wrapper > div, .header-wrapper > header, .header-wrapper > nav { max-width: 100% !important; margin-left: 0 !important; padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .sticky-shadow { box-shadow: 4px 0 8px -2px rgba(0, 0, 0, 0.08); }
    </style>
</head>
<body class="min-h-screen flex text-gray-800 overflow-x-hidden w-full">
    @include('layouts.sidebar')
    
    <div class="flex-1 pl-[72px] peer-hover:pl-64 flex flex-col min-h-screen transition-all duration-300 min-w-0">
        @include('layouts.header')
        
        <main class="flex-1 p-5 md:p-8 animate-fade-in flex flex-col bg-gray-50/50 min-w-0 w-full">
            @php
                // 1. Ambil role user & jadikan KAPITAL (Persiapan untuk Role Satker nanti)
                $userRole = auth()->check() && auth()->user()->role ? strtoupper(auth()->user()->role->nama_role) : '';
                // 2. Kunci Master: Superadmin & PPK Trans Pusat tetap bisa lihat SEMUA baris
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
            
            <!-- Judul & Filter Atas -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Matriks PPK Trans</h1>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Kelola data realisasi mingguan Satuan Kerja Ditjen. Pembangunan dan Pengembangan Kawasan Transmigrasi.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <select id="filterBulan" onchange="filterTabelBulan()" class="appearance-none bg-white border border-gray-200 text-gray-700 font-bold py-2 pl-4 pr-10 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300 cursor-pointer text-sm transition-all hover:bg-gray-50">
                            <option value="1 Tahun (Full)">1 Tahun (Full)</option>
                            @foreach($daftarBulan as $bln)<option value="{{ $bln }}">{{ $bln }}</option>@endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                    </div>
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-200 text-gray-700 font-bold py-2 pl-4 pr-10 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300 cursor-pointer text-sm transition-all hover:bg-gray-50"><option>2026</option><option>2025</option></select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div>
                    </div>
                </div>
            </div>

            <!-- Wadah Utama Matriks -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden relative w-full transition-all duration-300">
                <div class="overflow-x-auto custom-scrollbar w-full">
                    <table class="w-full text-left border-collapse transition-all duration-300 min-w-[1200px]">
                        <thead>
                            <tr class="bg-gray-100">
                                <th rowspan="3" class="px-4 py-3 font-bold text-gray-700 border-r border-b border-gray-200 align-middle uppercase text-[11px] min-w-[260px] max-w-[260px] sticky left-0 bg-gray-100 z-20 sticky-shadow leading-relaxed">
                                    Satker (Satuan Kerja)
                                </th>
                                @foreach($daftarBulan as $bulan)
                                    <!-- PERUBAHAN: colspan menjadi 15 untuk menampung Total Bulanan -->
                                    <th colspan="15" data-bulan="{{ $bulan }}" class="col-bulan px-0 py-0 text-center font-extrabold text-gray-700 uppercase tracking-widest text-[10px] border-r border-b border-gray-200 bg-gray-50 transition-all hover:bg-blue-50 cursor-pointer group">
                                        <a href="{{ route('ppktrans.rekap', ['bulan' => $bulan, 'minggu' => 'Semua Minggu', 'tahun' => '2026']) }}" class="block w-full py-2 group-hover:text-blue-600 transition-colors">{{ $bulan }}</a>
                                    </th>
                                @endforeach
                                <th colspan="3" rowspan="2" class="col-rekap px-0 py-0 text-center font-extrabold text-blue-900 uppercase tracking-widest text-[10px] border-b border-gray-200 bg-blue-50/80 transition-all hover:bg-blue-100 cursor-pointer group">
                                    <a href="{{ route('ppktrans.rekap', ['bulan' => '1 Tahun', 'minggu' => 'Semua Minggu', 'tahun' => '2026']) }}" class="block w-full h-full py-4 group-hover:text-blue-700 transition-colors">Rekap Total (1 Tahun)</a>
                                </th>
                            </tr>
                            <tr class="bg-gray-50/50">
                                @foreach($daftarBulan as $bulan)
                                    <!-- Kolom M1 s.d. M4 -->
                                    @foreach($daftarMinggu as $minggu)
                                        <th colspan="3" data-bulan="{{ $bulan }}" class="col-bulan px-0 py-0 text-center font-bold text-gray-600 uppercase tracking-wider text-[9px] border-r border-b border-gray-200 transition-all hover:bg-blue-50 cursor-pointer group">
                                            @php $mText = explode(' ', $minggu)[0]; @endphp
                                            <a href="{{ route('ppktrans.rekap', ['bulan' => $bulan, 'minggu' => $mText, 'tahun' => '2026']) }}" class="block w-full py-1.5 group-hover:text-blue-600 transition-colors">{{ $minggu }}</a>
                                        </th>
                                    @endforeach
                                    <!-- PERUBAHAN: Header Total Bulan -->
                                    <th colspan="3" data-bulan="{{ $bulan }}" class="col-bulan px-2 py-1.5 text-center font-extrabold text-slate-700 uppercase tracking-wider text-[9px] border-r border-b border-slate-200 bg-slate-100 transition-all">
                                        Total {{ $bulan }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="bg-white">
                                @foreach($daftarBulan as $bulan)
                                    <!-- Rincian Pagu, Realisasi, Deviasi M1 s.d. M4 -->
                                    @foreach($daftarMinggu as $minggu)
                                        <th data-bulan="{{ $bulan }}" class="col-bulan px-1.5 py-1.5 text-center text-[9px] font-bold text-blue-600 uppercase tracking-wider border-r border-b border-gray-200">Pagu</th>
                                        <th data-bulan="{{ $bulan }}" class="col-bulan px-1.5 py-1.5 text-center text-[9px] font-bold text-emerald-600 uppercase tracking-wider border-r border-b border-gray-200">Realisasi</th>
                                        <th data-bulan="{{ $bulan }}" class="col-bulan px-1.5 py-1.5 text-center text-[9px] font-bold text-orange-600 uppercase tracking-wider border-r border-b border-gray-200">Deviasi</th>
                                    @endforeach
                                    <!-- Rincian Pagu, Realisasi, Deviasi untuk TOTAL BULANAN -->
                                    <th data-bulan="{{ $bulan }}" class="col-bulan px-2 py-1.5 text-center text-[9px] font-extrabold text-blue-700 uppercase tracking-wider border-r border-b border-slate-200 bg-slate-50 min-w-[60px]">Pagu</th>
                                    <th data-bulan="{{ $bulan }}" class="col-bulan px-2 py-1.5 text-center text-[9px] font-extrabold text-emerald-700 uppercase tracking-wider border-r border-b border-slate-200 bg-slate-50 min-w-[60px]">Realisasi</th>
                                    <th data-bulan="{{ $bulan }}" class="col-bulan px-2 py-1.5 text-center text-[9px] font-extrabold text-orange-700 uppercase tracking-wider border-r border-b border-slate-200 bg-slate-50 min-w-[60px]">Deviasi</th>
                                @endforeach
                                <th class="col-rekap px-2 py-1.5 text-center text-[9px] font-extrabold text-blue-700 uppercase tracking-wider border-r border-b border-blue-200 bg-blue-50/50 min-w-[70px]">Total Pagu</th>
                                <th class="col-rekap px-2 py-1.5 text-center text-[9px] font-extrabold text-emerald-700 uppercase tracking-wider border-r border-b border-blue-200 bg-blue-50/50 min-w-[70px]">Tot. Realisasi</th>
                                <th class="col-rekap px-2 py-1.5 text-center text-[9px] font-extrabold text-orange-700 uppercase tracking-wider border-b border-blue-200 bg-blue-50/50 min-w-[70px]">Tot. Deviasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($daftarSatker as $satker)
                                
                                <!-- KODE PENYARING: Baris ini hanya dirender jika user adalah Pusat, ATAU rolenya sama dengan nama Satker -->
                                @if($isPusatPpk || $userRole === strtoupper($satker))
                                
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <!-- Kolom Sticky (Nama Satker) -->
                                    <td class="px-4 py-2.5 font-semibold text-[11px] text-gray-800 border-r border-gray-200 leading-relaxed sticky left-0 bg-white z-10 sticky-shadow group-hover:bg-gray-50 transition-colors">
                                        <a href="{{ route('ppktrans.detail', ['satker' => $satker]) }}" class="block w-full hover:text-blue-600 hover:underline transition-colors">{{ $satker }}</a>
                                    </td>
                                    
                                    @foreach($daftarBulan as $bulan)
                                        <!-- Data M1 s.d. M4 -->
                                        @foreach($daftarMinggu as $minggu)
                                            <td data-bulan="{{ $bulan }}" class="col-bulan px-1.5 py-2.5 text-center font-medium text-[11px] text-gray-600 border-r border-gray-200">10.0%</td>
                                            <td data-bulan="{{ $bulan }}" class="col-bulan px-1.5 py-2.5 text-center font-medium text-[11px] text-gray-600 border-r border-gray-200">8.5%</td>
                                            <td data-bulan="{{ $bulan }}" class="col-bulan px-1.5 py-2.5 text-center font-bold text-[11px] text-red-500 bg-red-50/40 border-r border-gray-200">-1.5%</td>
                                        @endforeach
                                        <!-- Data Total Bulan Ini -->
                                        <td data-bulan="{{ $bulan }}" class="col-bulan px-2 py-2.5 text-center font-bold text-[11px] text-blue-700 bg-slate-50/80 border-r border-slate-200">40.0%</td>
                                        <td data-bulan="{{ $bulan }}" class="col-bulan px-2 py-2.5 text-center font-bold text-[11px] text-emerald-700 bg-slate-50/80 border-r border-slate-200">34.0%</td>
                                        <td data-bulan="{{ $bulan }}" class="col-bulan px-2 py-2.5 text-center font-bold text-[11px] text-red-600 bg-red-50/60 border-r border-slate-200">-6.0%</td>
                                    @endforeach
                                    
                                    <!-- Rekap 1 Tahun Penuh -->
                                    <td class="col-rekap px-2 py-2.5 text-center font-bold text-[11px] text-blue-700 bg-blue-50/30 border-r border-blue-100">120.0%</td>
                                    <td class="col-rekap px-2 py-2.5 text-center font-bold text-[11px] text-emerald-700 bg-blue-50/30 border-r border-blue-100">102.0%</td>
                                    <td class="col-rekap px-2 py-2.5 text-center font-bold text-[11px] text-red-600 bg-red-50/60">-18.0%</td>
                                </tr>
                                
                                @endif
                                <!-- AKHIR KODE PENYARING -->
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Box Informasi -->
            <div class="bg-gray-100 border border-gray-200 rounded-2xl p-5 md:p-6 flex flex-col sm:flex-row gap-4 mb-8">
                <div class="text-gray-400 shrink-0 mt-0.5"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div>
                    <h4 class="text-gray-700 font-bold text-sm mb-2 uppercase tracking-wide">Informasi Penggunaan Matriks</h4>
                    <ul class="list-disc list-outside ml-4 text-[13px] text-gray-600 space-y-1.5 leading-relaxed">
                        <li>Silakan klik pada nama <span class="font-bold text-gray-800">Satuan Kerja</span> pada kolom pertama untuk melakukan pengisian rincian kegiatan per Satker.</li>
                        <li>Silakan klik pada judul kolom <span class="font-bold text-gray-800">Minggu</span> atau <span class="font-bold text-gray-800">Bulan</span> di atas tabel untuk melihat rekapitulasi data.</li>
                        <li>Saat Anda memilih satu bulan tertentu dari filter, tabel akan memunculkan rekapitulasi <strong>Total Bulan Ini</strong> di kolom paling kanan sebelum rekap tahunan.</li>
                    </ul>
                </div>
            </div>
        </main>
        @include('layouts.footer')
    </div>
    <script>
        function filterTabelBulan() {
            const bulanPilihan = document.getElementById('filterBulan').value;
            const semuaKolomBulan = document.querySelectorAll('.col-bulan');
            const semuaKolomRekap = document.querySelectorAll('.col-rekap');

            if (bulanPilihan === '1 Tahun (Full)') {
                // Tampilkan semua
                semuaKolomBulan.forEach(k => k.style.display = '');
                semuaKolomRekap.forEach(k => k.style.display = '');
            } else {
                // Filter hanya bulan yang dipilih (minggu 1-4 & total bulanannya akan ikut muncul)
                semuaKolomBulan.forEach(k => {
                    k.style.display = (k.getAttribute('data-bulan') === bulanPilihan) ? '' : 'none';
                });
                // Sembunyikan rekap total 1 tahun
                semuaKolomRekap.forEach(k => k.style.display = 'none');
            }
        }
        document.addEventListener('DOMContentLoaded', filterTabelBulan);
    </script>
</body>
</html>