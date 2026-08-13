<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tim Pemeriksa</title>
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
    </style>
</head>
<body class="bg-[#e2e6eb] min-h-screen font-sans text-gray-800 relative overflow-x-hidden" x-data="{ showEwsModal: true }">
    
    @include('layouts.sidebar')
    @include('layouts.header')
        {{-- CONTENT --}}
        <main class="min-h-[calc(100vh-88px)] bg-slate-100">

            <div class="py-8 px-4 sm:px-6 lg:px-8" x-data="timPemeriksa()">

                <div class="max-w-[1600px] mx-auto">
                    
                <div class="min-h-screen bg-slate-100 py-8 px-4 sm:px-6 lg:px-8" x-data="timPemeriksa()">

                <div class="max-w-7xl mx-auto">

                    {{-- =====================================================
                        HEADER HALAMAN
                    ====================================================== --}}
                    <div class="mb-8 mt-8">

                        <div class="bg-white/70backdrop-blur-xl border border-white/80 rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.06)] px-8 py-7 flex
                            flex-colmd:flex-row md:items-center md:justify-between gap-5">

                            {{-- LEFT --}}
                            <div class="flex items-center gap-5">

                                {{-- ICON --}}
                                <div class="
                                    w-14 h-14
                                    rounded-2xl
                                    bg-[#0B2A4A]
                                    flex items-center justify-center
                                    shadow-lg
                                    shrink-0
                                ">
                                    <svg
                                        class="w-7 h-7 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                </div>


                                {{-- TITLE --}}
                                <div>

                                    <h1 class="
                                        text-3xl
                                        font-extrabold
                                        text-slate-900
                                        tracking-tight
                                    ">
                                        Tim Pemeriksa
                                    </h1>

                                    <p class="
                                        mt-1.5
                                        text-sm
                                        text-slate-500
                                        font-medium
                                    ">
                                        Monitoring data tim dan biaya pemeriksaan
                                    </p>

                                </div>

                            </div>


                            {{-- RIGHT BADGE --}}
                            <div class="
                                inline-flex
                                items-center
                                gap-2
                                bg-slate-100
                                border border-slate-200
                                px-4 py-2.5
                                rounded-xl
                                shrink-0
                            ">

                                <span class="
                                    w-2.5 h-2.5
                                    rounded-full
                                    bg-[#1f5b91]
                                    animate-pulse
                                "></span>

                                <span class="
                                    text-xs
                                    font-bold
                                    text-slate-600
                                    uppercase
                                    tracking-wide
                                ">
                                    Monitoring Pemeriksaan
                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- =====================================================
                        STATE BELUM ADA DATA
                    ====================================================== --}}
                    @if (!$suratTugas || $suratTugas->timPemeriksa->isEmpty())

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                            <div class="px-6 py-5 border-b border-slate-200">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4v16m8-8H4">
                                            </path>
                                        </svg>
                                    </div>

                                    <div>
                                        <h2 class="font-bold text-slate-900">
                                            Data Tim Pemeriksa
                                        </h2>

                                        <p class="text-sm text-slate-500 mt-0.5">
                                            Kelola data pemeriksa berdasarkan Surat Tugas (ST)
                                        </p>
                                    </div>

                                </div>

                            </div>


                            {{-- EMPTY STATE --}}
                            <div class="px-6 py-16 text-center">

                                <div class="mx-auto w-20 h-20 rounded-2xl bg-slate-100 flex items-center justify-center mb-5">

                                    <svg class="w-10 h-10 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>

                                    </svg>

                                </div>

                                <h3 class="text-lg font-bold text-slate-800">
                                    Belum Ada Data Tim Pemeriksa
                                </h3>

                                <p class="text-sm text-slate-500 max-w-md mx-auto mt-2 mb-6">
                                    Silakan input data tim pemeriksa berdasarkan Surat Tugas
                                    untuk mulai melakukan monitoring.
                                </p>

                                <button
                                    @click="openModal = true"
                                    class="inline-flex items-center gap-2 px-5 py-3
                                        bg-[#0B2A4A] hover:bg-[#12395f]
                                        text-white text-sm font-semibold
                                        rounded-xl shadow-sm
                                        transition-all duration-200">

                                    <svg class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4v16m8-8H4">
                                        </path>

                                    </svg>

                                    Input Data Tim Pemeriksa

                                </button>

                            </div>

                        </div>

                    @endif


                    {{-- =====================================================
                        STATE SUDAH ADA DATA
                    ====================================================== --}}
                    @if ($suratTugas && $suratTugas->timPemeriksa->isNotEmpty())

                        <div>

                            {{-- INFO SURAT TUGAS --}}
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">

                                <div class="px-6 py-5">

                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                                        {{-- INFO --}}
                                        <div class="flex items-center gap-4">

                                            {{-- ICON --}}
                                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">

                                                <svg class="w-6 h-6 text-blue-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M7 21h10a2 2 0 002-2V7.5L14.5 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M14 3v5h5M8 13h8M8 17h5">
                                                    </path>

                                                </svg>

                                            </div>


                                            {{-- TEXT --}}
                                            <div>

                                                <div class="flex items-center gap-2 mb-1">

                                                    <span class="px-2.5 py-1 rounded-lg
                                                        bg-blue-50 text-blue-700
                                                        text-xs font-bold uppercase tracking-wide">
                                                        Surat Tugas
                                                    </span>

                                                </div>

                                                <h2 class="text-lg font-bold text-slate-900">
                                                    {{ $suratTugas->nomor_st ?? '-' }}
                                                </h2>

                                                <p class="text-sm text-slate-500 mt-1">
                                                    Data Tim Pemeriksa
                                                </p>

                                            </div>

                                        </div>


                                        {{-- ACTION --}}
                                        <div class="flex items-center gap-2">

                                            <button
                                                @click="openModal = true"
                                                class="inline-flex items-center gap-2 px-4 py-2.5
                                                    border border-slate-300
                                                    bg-white hover:bg-slate-50
                                                    text-slate-700
                                                    text-sm font-semibold
                                                    rounded-xl transition">

                                                <svg class="w-4 h-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 7.5-7.5z">
                                                    </path>

                                                </svg>

                                                Edit Data

                                            </button>


                                            <button
                                                @click="addPemeriksa()"
                                                class="inline-flex items-center gap-2 px-4 py-2.5
                                                    bg-[#0B2A4A] hover:bg-[#12395f]
                                                    text-white text-sm font-semibold
                                                    rounded-xl transition">

                                                <svg class="w-4 h-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 4v16m8-8H4">
                                                    </path>

                                                </svg>

                                                Tambah Pemeriksa

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- =================================================
                                SUMMARY CARD
                            ================================================== --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                                {{-- JUMLAH PEMERIKSA --}}
                                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                                Jumlah Pemeriksa
                                            </p>

                                            <div class="flex items-end gap-2 mt-2">

                                                <span class="text-3xl font-bold text-slate-900">
                                                    {{ $suratTugas->timPemeriksa->count() }}
                                                </span>

                                                <span class="text-sm text-slate-500 mb-1">
                                                    orang
                                                </span>

                                            </div>
                                        </div>

                                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">

                                            <svg class="w-6 h-6 text-blue-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                                </path>

                                            </svg>

                                        </div>

                                    </div>

                                </div>


                                {{-- TOTAL BIAYA --}}
                                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                                    <div class="flex items-center justify-between">

                                        <div>

                                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                                Total Biaya
                                            </p>

                                            <div class="mt-2">

                                                <span class="text-3xl font-bold text-[#0B2A4A]">
                                                    Rp {{ number_format(
                                                        $suratTugas->timPemeriksa->sum('jumlah_biaya'),
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}
                                                </span>

                                            </div>

                                        </div>


                                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">

                                            <svg class="w-6 h-6 text-[#0B2A4A]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M12 8c-2.21 0-4 1.12-4 2.5S9.79 13 12 13s4 1.12 4 2.5S14.21 18 12 18m0-10V6m0 2v10m0 0v2">
                                                </path>

                                            </svg>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                                TABEL
                            ================================================== --}}
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                                {{-- TABLE HEADER --}}
                                <div class="px-6 py-5 border-b border-slate-200">

                                    <div class="flex items-center justify-between">

                                        <div>
                                            <h2 class="font-bold text-slate-900">
                                                Susunan Tim dan Biaya Pemeriksaan
                                            </h2>

                                            <p class="text-sm text-slate-500 mt-1">
                                                Daftar pemeriksa berdasarkan Surat Tugas
                                            </p>
                                        </div>

                                    </div>

                                </div>


                                {{-- TABLE --}}
                                <div class="overflow-x-auto">

                                    <table class="w-full min-w-[1100px] border-collapse text-sm">

                                        <thead>

                                            <tr class="bg-[#0B2A4A] text-white">

                                                <th class="px-4 py-4 text-center font-bold">
                                                    No.
                                                </th>

                                                <th class="px-4 py-4 text-left font-bold">
                                                    Nama
                                                </th>

                                                <th class="px-4 py-4 text-left font-bold">
                                                    Peran
                                                </th>

                                                <th class="px-4 py-4 text-center font-bold">
                                                    DKI<br>Jakarta
                                                </th>

                                                <th class="px-4 py-4 text-center font-bold">
                                                    DI<br>Yogyakarta
                                                </th>

                                                <th class="px-4 py-4 text-center font-bold">
                                                    Jawa<br>Timur
                                                </th>

                                                <th class="px-4 py-4 text-center font-bold">
                                                    Papua<br>Selatan
                                                </th>

                                                <th class="px-4 py-4 text-center font-bold">
                                                    Total
                                                </th>

                                                <th class="px-4 py-4 text-right font-bold">
                                                    Jumlah Biaya<br>(Rp)
                                                </th>

                                                <th class="px-4 py-4 text-center font-bold">
                                                    Aksi
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @foreach ($suratTugas->timPemeriksa as $index => $tim)

                                                @php

                                                    $dki = $tim->waktuPemeriksa
                                                        ->firstWhere('provinsi.nama_provinsi', 'DKI Jakarta');

                                                    $yogyakarta = $tim->waktuPemeriksa
                                                        ->firstWhere('provinsi.nama_provinsi', 'DI Yogyakarta');

                                                    $jatim = $tim->waktuPemeriksa
                                                        ->firstWhere('provinsi.nama_provinsi', 'Jawa Timur');

                                                    $papua = $tim->waktuPemeriksa
                                                        ->firstWhere('provinsi.nama_provinsi', 'Papua Selatan');

                                                @endphp

                                                <tr class="border-b border-slate-200 hover:bg-blue-50/50 transition">

                                                    {{-- NO --}}
                                                    <td class="px-4 py-4 text-center text-slate-500">
                                                        {{ $index + 1 }}
                                                    </td>


                                                    {{-- NAMA --}}
                                                    <td class="px-4 py-4">

                                                        <div class="font-semibold text-slate-800">
                                                            {{ $tim->nama_pemeriksa }}
                                                        </div>

                                                    </td>


                                                    {{-- JABATAN --}}
                                                    <td class="px-4 py-4 text-slate-700">

                                                        {{ $tim->jabatan->nama_jabatan ?? '-' }}

                                                    </td>


                                                    {{-- DKI --}}
                                                    <td class="px-4 py-4 text-center">

                                                        {{ $dki->jumlah_hari ?? 0 }}

                                                    </td>


                                                    {{-- YOGYAKARTA --}}
                                                    <td class="px-4 py-4 text-center">

                                                        {{ $yogyakarta->jumlah_hari ?? 0 }}

                                                    </td>


                                                    {{-- JAWA TIMUR --}}
                                                    <td class="px-4 py-4 text-center">

                                                        {{ $jatim->jumlah_hari ?? 0 }}

                                                    </td>


                                                    {{-- PAPUA SELATAN --}}
                                                    <td class="px-4 py-4 text-center">

                                                        {{ $papua->jumlah_hari ?? 0 }}

                                                    </td>


                                                    {{-- TOTAL HARI --}}
                                                    <td class="px-4 py-4 text-center font-bold text-[#0B2A4A]">

                                                        {{ $tim->jangka_waktu }}

                                                    </td>


                                                    {{-- JUMLAH BIAYA --}}
                                                    <td class="px-4 py-4 text-right font-semibold">

                                                        Rp {{ number_format(
                                                            $tim->jumlah_biaya,
                                                            0,
                                                            ',',
                                                            '.'
                                                        ) }}

                                                    </td>


                                                    {{-- AKSI --}}
                                                    <td class="px-4 py-4 text-center">

                                                        <button
                                                            type="button"
                                                            class="w-8 h-8 rounded-lg
                                                                bg-red-50 hover:bg-red-100
                                                                text-red-600
                                                                inline-flex items-center justify-center
                                                                transition"
                                                        >

                                                            <svg
                                                                class="w-4 h-4"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24"
                                                            >

                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M6 7h12M10 11v6m4-6v6M9 7V4h6v3m-8 0l1 13h8l1-13"
                                                                />

                                                            </svg>

                                                        </button>

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>


                                        <tfoot>
                                            <tr class="bg-slate-50 border-t-2 border-slate-300">

                                                <td
                                                    colspan="8"
                                                    class="px-4 py-5 text-right font-bold text-slate-700"
                                                >
                                                    Jumlah
                                                </td>

                                                <td
                                                    class="px-4 py-5 text-right font-bold text-[#0B2A4A]"
                                                >
                                                    Rp {{ number_format(
                                                        $suratTugas->timPemeriksa->sum('jumlah_biaya'),
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}
                                                </td>

                                                <td></td>

                                            </tr>
                                        </tfoot>

                                    </table>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =====================================================
                        MODAL INPUT DATA
                    ====================================================== --}}
                    <div x-show="openModal" x-cloak class="fixed inset-0 z-[99999] flex items-center justify-center p-4">

                        {{-- OVERLAY --}}
                        <div
                            class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                            @click="openModal = false">
                        </div>

                        <form action="{{ route('storeTimPemeriksa') }}"
                            method="POST"
                            class="relative w-full max-w-5xl max-h-[90vh] bg-white rounded-2xl shadow-2xl overflow-hidden">

                            @csrf

                            <input type="hidden" name="surat_tugas_id" value="{{ $suratTugas->id }}">
                        {{-- MODAL --}}
                        <div
                            class="relative w-full max-w-5xl max-h-[90vh] bg-white rounded-2xl shadow-2xl overflow-hidden"
                            @click.stop>

                            {{-- MODAL HEADER --}}
                            <div class="px-6 py-5 bg-[#0B2A4A] text-white">

                                <div class="flex items-center justify-between">

                                    <div>

                                        <h2 class="text-lg font-bold">
                                            Input Data Tim Pemeriksa
                                        </h2>

                                        <p class="text-sm text-blue-100 mt-1">
                                            Masukkan data berdasarkan Surat Tugas (ST)
                                        </p>

                                    </div>

                                    <button
                                        @click="openModal = false"
                                        class="w-9 h-9 rounded-lg hover:bg-white/10 flex items-center justify-center">

                                        <svg class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12">
                                            </path>

                                        </svg>

                                    </button>

                                </div>

                            </div>


                            {{-- MODAL BODY --}}
                            <div class="p-6 overflow-y-auto max-h-[70vh]">

                                {{-- DATA PEMERIKSA --}}
                                <div>

                                    {{-- HEADER --}}
                                    <div class="flex items-center justify-between mb-5">

                                        <div>
                                            <h3 class="text-sm font-bold text-slate-800">
                                                Data Pemeriksa
                                            </h3>

                                            <p class="text-xs text-slate-500 mt-1">
                                                Isi data pemeriksa dan rincian biaya pemeriksaan.
                                            </p>
                                        </div>

                                        <button
                                            @click="addPemeriksa()"
                                            type="button"
                                            class="inline-flex items-center gap-2
                                                px-3 py-2 rounded-lg
                                                bg-blue-50 hover:bg-blue-100
                                                text-blue-700 text-xs font-bold
                                                transition">

                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>

                                            Tambah Pemeriksa

                                        </button>

                                    </div>


                                    {{-- FORM PEMERIKSA --}}
                                    <div class="space-y-5">

                                        <template
                                            x-for="(item, index) in pemeriksa"
                                            :key="index">

                                            <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white">

                                                {{-- HEADER PEMERIKSA --}}
                                                <div
                                                    class="flex items-center justify-between px-5 py-4 bg-slate-50 border-b border-slate-200">

                                                    <div class="flex items-center gap-3">

                                                        <div
                                                            class="
                                                                w-8 h-8
                                                                rounded-lg
                                                                bg-[#0B2A4A]
                                                                text-white
                                                                flex items-center justify-center
                                                                text-xs font-bold
                                                            "
                                                        >
                                                            <span x-text="index + 1"></span>
                                                        </div>

                                                        <div>

                                                            <p class="text-xs font-bold text-slate-800">
                                                                Pemeriksa <span x-text="index + 1"></span>
                                                            </p>

                                                            <p class="text-[11px] text-slate-500">
                                                                Data pemeriksa dan rincian biaya
                                                            </p>

                                                        </div>

                                                    </div>


                                                    {{-- HAPUS --}}
                                                    <button
                                                        type="button"
                                                        @click="hapusPemeriksa(index)"
                                                        class="
                                                            inline-flex items-center gap-1.5
                                                            px-2.5 py-1.5
                                                            rounded-lg
                                                            text-xs font-semibold
                                                            text-red-600
                                                            hover:bg-red-50
                                                            transition
                                                        "
                                                    >

                                                        <svg
                                                            class="w-3.5 h-3.5"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h12"
                                                            />
                                                        </svg>

                                                        Hapus

                                                    </button>

                                                </div>


                                                {{-- STEP 1 : DATA PEMERIKSA --}}
                                                <div class="p-5">

                                                    <div class="mb-4">

                                                        <div class="flex items-center gap-2">

                                                            <span
                                                                class="
                                                                    w-6 h-6
                                                                    rounded-full
                                                                    bg-blue-50
                                                                    text-blue-700
                                                                    flex items-center justify-center
                                                                    text-[11px] font-bold
                                                                "
                                                            >
                                                                1
                                                            </span>

                                                            <h4 class="text-xs font-bold text-slate-800">
                                                                Data Pemeriksa
                                                            </h4>

                                                        </div>

                                                        <p class="text-[11px] text-slate-500 mt-1 ml-8">
                                                            Lengkapi identitas dan jangka waktu pemeriksaan.
                                                        </p>

                                                    </div>


                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                                        {{-- NAMA --}}
                                                        <div>

                                                            <label
                                                                class="
                                                                    block
                                                                    text-xs font-semibold
                                                                    text-slate-600
                                                                    mb-1.5
                                                                "
                                                            >
                                                                Nama Pemeriksa
                                                            </label>

                                                            <input
                                                                type="text"
                                                                
                                                                :name="'pemeriksa[' + index + '][nama_pemeriksa]'"
                                                                placeholder="Nama sesuai ST"
                                                                class="
                                                                    w-full
                                                                    rounded-lg
                                                                    border border-slate-300
                                                                    bg-white
                                                                    px-3 py-2.5
                                                                    text-sm
                                                                    focus:border-blue-500
                                                                    focus:ring-2
                                                                    focus:ring-blue-100
                                                                    outline-none
                                                                "
                                                            >

                                                        </div>


                                                        {{-- JABATAN --}}
                                                        <div>

                                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                                                                Jabatan / Peran
                                                            </label>

                                                            <select
                                                                :name="'pemeriksa[' + index + '][jabatan_id]'"
                                                                
                                                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm
                                                                    focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none">
                                                                <option value="">Pilih Jabatan / Peran</option>

                                                                @foreach ($jabatan as $jab)
                                                                    <option value="{{ $jab->id }}">
                                                                        {{ $jab->nama_jabatan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <div>

                                                            <label
                                                                class="
                                                                    block
                                                                    text-xs font-semibold
                                                                    text-slate-600
                                                                    mb-1.5
                                                                "
                                                            >
                                                                Jangka Waktu
                                                            </label>

                                                            <input
                                                                type="number"
                                                                 :name="'pemeriksa[' + index + '][jangka_waktu]'"
                                                               
                                                                placeholder="Jangka Waktu"
                                                                class="
                                                                    w-full
                                                                    rounded-lg
                                                                    border border-slate-300
                                                                    bg-white
                                                                    px-3 py-2.5
                                                                    text-sm
                                                                    focus:border-blue-500
                                                                    focus:ring-2
                                                                    focus:ring-blue-100
                                                                    outline-none
                                                                "
                                                            >

                                                        </div>


                                                    </div>


                                                    {{-- PEMBATAS --}}
                                                    <div class="my-6 border-t border-slate-100"></div>


                                                    {{-- STEP 2 : RINCIAN BIAYA --}}
                                                    <div class="mb-4">

                                                        <div class="flex items-center gap-2">

                                                            <span
                                                                class="
                                                                    w-6 h-6
                                                                    rounded-full
                                                                    bg-blue-50
                                                                    text-blue-700
                                                                    flex items-center justify-center
                                                                    text-[11px] font-bold
                                                                "
                                                            >
                                                                2
                                                            </span>

                                                            <h4 class="text-xs font-bold text-slate-800">
                                                                Waktu Pemeriksaan per Provinsi
                                                            </h4>

                                                        </div>

                                                        <p class="text-[11px] text-slate-500 mt-1 ml-8">
                                                            Masukkan jumlah hari pemeriksaan untuk setiap provinsi.
                                                        </p>

                                                    </div>


                                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                                                        @foreach ($provinsis as $provinsi)

                                                            <div>

                                                                <label
                                                                    class="block text-xs font-semibold text-slate-600 mb-1.5"
                                                                >
                                                                    {{ $provinsi->nama_provinsi }}
                                                                </label>

                                                                <div class="relative">

                                                                    <input
                                                                        type="number"
                                                                        :name="'pemeriksa[' + index + '][provinsi][{{ $provinsi->id }}]'"
                                                                        min="0"
                                                                        placeholder="0"
                                                                        class="
                                                                            w-full
                                                                            rounded-lg
                                                                            border border-slate-300
                                                                            bg-white
                                                                            px-3 py-2.5
                                                                            pr-14
                                                                            text-sm
                                                                            focus:border-blue-500
                                                                            focus:ring-2
                                                                            focus:ring-blue-100
                                                                            outline-none
                                                                        "
                                                                    >

                                                                    <span
                                                                        class="
                                                                            absolute
                                                                            right-3
                                                                            top-1/2
                                                                            -translate-y-1/2
                                                                            text-xs
                                                                            text-slate-400
                                                                        "
                                                                    >
                                                                        hari
                                                                    </span>

                                                                </div>

                                                            </div>

                                                        @endforeach

                                                    </div>

                                                    {{-- TOTAL BIAYA --}}

                                                    <div
                                                        class="mt-5 flex items-center justify-between rounded-xl bg-slate-50 border border-slate-200 px-4 py-3">

                                                        <div>

                                                            <p class="text-xs font-bold text-slate-700">
                                                                Jumlah Biaya
                                                            </p>

                                                            <p class="text-[11px] text-slate-500 mt-0.5">
                                                                Masukkan total biaya pemeriksaan.
                                                            </p>

                                                        </div>

                                                        <div class="text-right">

                                                            <div class="flex items-center">

                                                                <span
                                                                    class="
                                                                        text-sm
                                                                        font-bold
                                                                        text-[#0B2A4A]
                                                                        mr-2
                                                                    "
                                                                >
                                                                    Rp
                                                                </span>

                                                                <input
                                                                    type="number"
                                                                    :name="'pemeriksa[' + index + '][jumlah_biaya]'"
                                                                    x-model="item.jumlah_biaya"
                                                                    min="1"
                                                                    placeholder="0"
                                                                    class="
                                                                        w-40
                                                                        rounded-lg
                                                                        border border-slate-300
                                                                        bg-white
                                                                        px-3 py-2
                                                                        text-right
                                                                        text-base
                                                                        font-extrabold
                                                                        text-[#0B2A4A]
                                                                        outline-none
                                                                        focus:border-blue-500
                                                                        focus:ring-2
                                                                        focus:ring-blue-100
                                                                    "
                                                                >

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </template>

                                    </div>

                                </div>

                            </div>


                            {{-- MODAL FOOTER --}}
                            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end gap-3">

                                <button
                                    type="button"
                                    @click="openModal = false"
                                    class="px-5 py-2.5 rounded-xl
                                        border border-slate-300
                                        bg-white hover:bg-slate-100
                                        text-sm font-semibold text-slate-700"
                                >
                                    Batal
                                </button>


                                <button type="submit" class=" px-5 py-2.5 rounded-xl bg-[#0B2A4A] hover:bg-[#12395f] text-white text-sm font-semibold shadow-sm">
                                    Simpan Data
                                </button>

                            </div>

                        </div>
                        </form>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                ALPINE JS
            ========================================================= --}}
            <script>

            function timPemeriksa() {

                return {

                    openModal: false,

                    submitted: false,

                    form: {

                        nomor_st: '',

                        tanggal_mulai: '',

                        tanggal_selesai: ''

                    },


                    pemeriksa: [],


                    addPemeriksa() {

                    this.pemeriksa.push({

                        id: null,

                        nama: '',

                        jabatan_id: '',

                        total: 0,

                        dki: 0,

                        yogyakarta: 0,

                        jatim: 0,

                        papua: 0

                    });

                    this.openModal = true;
                },


                    hapusPemeriksa(index) {

                        this.pemeriksa.splice(index, 1);

                    },


                    simpanData() {

                        if (this.pemeriksa.length === 0) {

                            alert('Silakan tambahkan minimal satu pemeriksa.');

                            return;

                        }

                        this.submitted = true;

                        this.openModal = false;

                    },


                    totalHari() {

                        return this.pemeriksa.reduce(

                            (total, item) => total + Number(item.total || 0),

                            0

                        );

                    },


                    totalBiaya() {

                        return this.pemeriksa.reduce(

                            (total, item) => total + Number(item.biaya || 0),

                            0

                        );

                    },


                    formatRupiah(value) {

                        return new Intl.NumberFormat('id-ID', {

                            style: 'currency',

                            currency: 'IDR',

                            minimumFractionDigits: 0

                        }).format(value || 0);

                    },


                    formatDate(date) {

                        if (!date) return '-';

                        return new Date(date).toLocaleDateString(

                            'id-ID',

                            {

                                day: '2-digit',

                                month: 'long',

                                year: 'numeric'

                            }

                        );

                    }

                }

            }

            </script>


            <style>

            [x-cloak] {
                display: none !important;
            }

            </style>
                </div>

            </div>

        </main>

    </div>