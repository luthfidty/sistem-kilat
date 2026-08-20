<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggaran</title>
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

        .sidebar-aware-header {
            left: 72px;
            width: calc(100% - 72px);
        }

        /* Sidebar expanded */
        aside:hover ~ .sidebar-aware-header {
            left: 256px;
            width: calc(100% - 256px);
        }
        [x-cloak] {
        display: none !important;
            }

        /* =========================================================
        HEADER
        ========================================================= */

        .sidebar-aware-header {
            left: 72px;
            width: calc(100% - 72px);
            transition:
                left 300ms ease-in-out,
                width 300ms ease-in-out;
        }

        /* Saat sidebar dibuka */
        aside:hover ~ .sidebar-aware-header {
            left: 256px;
            width: calc(100% - 256px);
        }


        /* =========================================================
        MAIN CONTENT
        ========================================================= */

        .sidebar-aware-content {
            margin-left: 72px;
            width: calc(100% - 72px);
            padding-top: 88px;

            transition:
                margin-left 300ms ease-in-out,
                width 300ms ease-in-out;
        }

        /* Saat sidebar dibuka */
        aside:hover ~ .sidebar-aware-content {
            margin-left: 256px;
            width: calc(100% - 256px);
        }


        /* =========================================================
        BODY
        ========================================================= */

        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-[#e2e6eb] min-h-screen font-sans text-gray-800 relative overflow-x-hidden" x-data="{ showEwsModal: true }">
    
    @include('layouts.sidebar')
    @include('layouts.header')
        {{-- CONTENT --}}
        <main class="sidebar-aware-content min-h-screen bg-slate-100">

        <div class="p-6">

            {{-- =====================================================
                 HEADER
            ====================================================== --}}

            <div class="flex flex-col md:flex-row md:items-center
                        md:justify-between gap-4 mb-6">

                <div>

                    <h1 class="text-2xl font-bold text-slate-800">
                        Dashboard Anggaran & Realisasi
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Rekapitulasi seluruh Surat Tugas tahun {{ $tahun }}
                    </p>

                </div>


                <button
                    onclick="document
                        .getElementById('modalAnggaran')
                        .classList.remove('hidden')"
                    class="px-4 py-2.5
                           bg-blue-600 hover:bg-blue-700
                           text-white rounded-lg
                           text-sm font-semibold"
                >

                    + Atur Anggaran RKP

                </button>

            </div>


            {{-- =====================================================
                 SUCCESS
            ====================================================== --}}

            @if(session('success'))

                <div
                    class="mb-5 p-4 rounded-lg
                           bg-green-50 border border-green-200
                           text-green-700 text-sm"
                >

                    {{ session('success') }}

                </div>

            @endif


            {{-- =====================================================
                 RINGKASAN
            ====================================================== --}}

            <div class="grid grid-cols-1 md:grid-cols-2
                        xl:grid-cols-4 gap-5 mb-6">


                {{-- TOTAL ANGGARAN --}}

                <div class="bg-white rounded-xl
                            border border-slate-200 p-5">

                    <p class="text-sm text-slate-500">
                        Total Anggaran RKP
                    </p>

                    <h2 class="text-xl font-bold
                               text-slate-800 mt-2">

                        Rp {{ number_format(
                            $totalAnggaran,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h2>

                </div>


                {{-- UANG MUKA --}}

                <div class="bg-white rounded-xl
                            border border-slate-200 p-5">

                    <p class="text-sm text-slate-500">
                        Realisasi Uang Muka 75%
                    </p>

                    <h2 class="text-xl font-bold
                               text-slate-800 mt-2">

                        Rp {{ number_format(
                            $totalUangMuka,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Berdasarkan biaya seluruh Surat Tugas
                    </p>

                </div>


                {{-- SPJ --}}

                <div class="bg-white rounded-xl
                            border border-slate-200 p-5">

                    <p class="text-sm text-slate-500">
                        Realisasi SPJ 100%
                    </p>

                    <h2 class="text-xl font-bold
                               text-slate-800 mt-2">

                        Rp {{ number_format(
                            $totalSPJ,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h2>

                </div>


                {{-- SISA --}}

                <div class="bg-white rounded-xl
                            border border-slate-200 p-5">

                    <p class="text-sm text-slate-500">
                        Sisa Anggaran
                    </p>

                    <h2 class="text-xl font-bold
                               text-slate-800 mt-2">

                        Rp {{ number_format(
                            $sisaAnggaran,
                            0,
                            ',',
                            '.'
                        ) }}

                    </h2>

                </div>

            </div>


            {{-- =====================================================
                 DONUT
            ====================================================== --}}

            <div class="bg-white rounded-xl
                        border border-slate-200 p-6 mb-6">


                <div class="flex items-center
                            justify-between mb-5">

                    <div>

                        <h2 class="text-lg font-bold
                                   text-slate-800">

                            Rekapitulasi Anggaran & Realisasi

                        </h2>

                        <p class="text-sm text-slate-500">
                            Akumulasi seluruh Surat Tugas
                        </p>

                    </div>


                    <span class="px-3 py-1
                                 bg-blue-50 text-blue-600
                                 rounded-full text-sm font-semibold">

                        {{ number_format(
                            $persentaseRealisasi,
                            2
                        ) }}% Realisasi

                    </span>

                </div>


                <div class="max-w-md mx-auto">

                    <canvas id="anggaranChart"></canvas>

                </div>


                <div class="grid grid-cols-2 gap-4 mt-6">

                    <div class="text-center">

                        <p class="text-sm text-slate-500">
                            Realisasi SPJ
                        </p>

                        <p class="font-bold text-slate-800">

                            Rp {{ number_format(
                                $totalSPJ,
                                0,
                                ',',
                                '.'
                            ) }}

                        </p>

                    </div>


                    <div class="text-center">

                        <p class="text-sm text-slate-500">
                            Sisa Anggaran
                        </p>

                        <p class="font-bold text-slate-800">

                            Rp {{ number_format(
                                max($sisaAnggaran, 0),
                                0,
                                ',',
                                '.'
                            ) }}

                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 TABEL SURAT TUGAS
            ====================================================== --}}

            <div class="bg-white rounded-xl
                        border border-slate-200 overflow-hidden">

                <div class="p-6 border-b border-slate-200">

                    <h2 class="text-lg font-bold text-slate-800">
                        Rekapitulasi Per Surat Tugas
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Detail biaya pemeriksaan dan realisasi SPJ
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-[#0d2f52] text-white">

                            <tr>

                                <th class="px-4 py-4 text-left">
                                    No.
                                </th>

                                <th class="px-4 py-4 text-left">
                                    Surat Tugas
                                </th>

                                <th class="px-4 py-4 text-right">
                                    Jumlah Pemeriksa
                                </th>

                                <th class="px-4 py-4 text-right">
                                    Total Biaya
                                </th>

                                <th class="px-4 py-4 text-right">
                                    Uang Muka 75%
                                </th>

                                <th class="px-4 py-4 text-right">
                                    SPJ 100%
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($suratTugas as $index => $st)

                                <tr
                                    class="border-b border-slate-200
                                           hover:bg-slate-50"
                                >

                                    {{-- NO --}}

                                    <td class="px-4 py-4">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- SURAT TUGAS --}}

                                    <td class="px-4 py-4">

                                        <div class="font-semibold
                                                    text-slate-800">

                                            {{ $st->nomor_st }}

                                        </div>

                                        <div class="text-xs
                                                    text-slate-400">

                                            Tahun {{ $st->tahun }}

                                        </div>

                                    </td>


                                    {{-- PEMERIKSA --}}

                                    <td class="px-4 py-4 text-right">

                                        {{ $st->timPemeriksa->count() }}

                                        orang

                                    </td>


                                    {{-- TOTAL BIAYA --}}

                                    <td class="px-4 py-4 text-right
                                               font-semibold">

                                        Rp {{ number_format(
                                            $st->total_biaya,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>


                                    {{-- UANG MUKA --}}

                                    <td class="px-4 py-4 text-right">

                                        Rp {{ number_format(
                                            $st->uang_muka,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>


                                    {{-- SPJ --}}

                                    <td class="px-4 py-4 text-right">

                                        Rp {{ number_format(
                                            $st->total_spj,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-4 py-10
                                               text-center
                                               text-slate-400"
                                    >

                                        Belum ada Surat Tugas
                                        untuk tahun {{ $tahun }}.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>


    {{-- =========================================================
         MODAL ANGGARAN RKP
    ========================================================== --}}

    <div
        id="modalAnggaran"
        class="hidden fixed inset-0 z-50
               flex items-center justify-center p-4"
    >

        <div
            onclick="closeModal('modalAnggaran')"
            class="absolute inset-0 bg-black/50"
        ></div>


        <div
            class="relative bg-white rounded-xl
                   shadow-xl w-full max-w-md p-6"
        >

            <h2 class="text-lg font-bold
                       text-slate-800 mb-1">

                Input Anggaran RKP

            </h2>

            <p class="text-sm text-slate-500 mb-5">

                Masukkan total anggaran berdasarkan RKP.

            </p>


            <form
                action="{{ route('anggaran.storeAnggaran') }}"
                method="POST"
            >

                @csrf


                <div class="mb-4">

                    <label class="block text-sm
                                  font-semibold
                                  text-slate-700 mb-2">

                        Tahun

                    </label>

                    <input
                        type="number"
                        name="tahun"
                        value="{{ $tahun }}"
                        required
                        class="w-full rounded-lg
                               border border-slate-300
                               px-3 py-2.5"
                    >

                </div>


                <div class="mb-5">

                    <label class="block text-sm
                                  font-semibold
                                  text-slate-700 mb-2">

                        Total Anggaran RKP

                    </label>

                    <input
                        type="text"
                        name="total_anggaran"
                        id="total_anggaran"
                        value="{{ number_format($totalAnggaran ?? 0, 0, ',', '.') }}"
                        inputmode="numeric"
                        required
                        class="w-full rounded-lg
                            border border-slate-300
                            px-3 py-2.5"
                        placeholder="Contoh: 10.000.000.000"
                    >

                    <p class="text-xs text-slate-400 mt-1">
                        Masukkan jumlah anggaran.
                    </p>

                </div>


                <div class="flex justify-end gap-3">

                    <button
                        type="button"
                        onclick="closeModal('modalAnggaran')"
                        class="px-4 py-2.5
                               rounded-lg
                               border border-slate-300
                               text-sm"
                    >

                        Batal

                    </button>


                    <button
                        type="submit"
                        class="px-4 py-2.5
                               rounded-lg
                               bg-blue-600
                               hover:bg-blue-700
                               text-white text-sm
                               font-semibold"
                    >

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>

        const inputAnggaran = document.getElementById('total_anggaran');

        inputAnggaran.addEventListener('input', function () {
            let angka = this.value.replace(/\D/g, '');

            if (angka) {
                this.value = new Intl.NumberFormat('id-ID').format(angka);
            } else {
                this.value = '';
            }
        });

        function closeModal(id)
        {
            document
                .getElementById(id)
                .classList.add('hidden');
        }




        /*
        |--------------------------------------------------------------------------
        | DONUT CHART
        |--------------------------------------------------------------------------
        */

        const ctx =
            document
                .getElementById('anggaranChart');


        new Chart(ctx, {

            type: 'doughnut',

            data: {

                labels: [
                    'Realisasi SPJ',
                    'Sisa Anggaran'
                ],

                datasets: [{
                    data: [
                        {{ max($totalSPJ, 0) }},
                        {{ max($sisaAnggaran, 0) }}
                    ],

                    backgroundColor: [
                        '#2563EB', // Realisasi SPJ
                        '#10B981'  // Sisa Anggaran
                    ],

                    borderWidth: 0
                }]

            },

            options: {

                responsive: true,

                cutout: '70%',

                plugins: {

                    legend: {
                        position: 'bottom'
                    }

                }

            }

        });

    </script>

</body>

</html>