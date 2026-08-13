<aside
    class="fixed
           top-0
           left-0
           bottom-0
           w-[72px]
           hover:w-64
           bg-[#1f5b91]
           text-white
           border-r border-white/10
           shadow-2xl
           z-[10000]
           transition-all duration-300
           group
           overflow-hidden"
>

    {{-- =========================================================
        HEADER / BRAND
    ========================================================== --}}
    <div
        class="relative
               h-[76px]
               w-64
               flex items-center
               bg-white
               border-b border-gray-200
               overflow-hidden"
    >

        <a
            href="{{ url('/dashboard') }}"
            class="relative
                   block
                   w-full
                   h-full
                   overflow-hidden"
        >

            {{-- LOGO --}}
            <img
                src="{{ asset('KILAT.png') }}"
                alt="KILAT"
                class="absolute
                       left-0
                       top-1/2
                       -translate-y-1/2
                       w-[150px]
                       h-auto
                       max-w-none
                       object-contain
                       transition-all
                       duration-300
                       ease-in-out
                       group-hover:left-1/2
                       group-hover:-translate-x-1/2
                       group-hover:w-[215px]"
            >

        </a>

    </div>


    {{-- =========================================================
        NAVIGASI
    ========================================================== --}}
    <nav
        class="flex-1
               py-5
               space-y-1
               w-64
               px-3
               overflow-x-hidden
               overflow-y-auto"
    >

        {{-- =====================================================
            DASHBOARD UTAMA
        ====================================================== --}}
        <a
            href="{{ url('/dashboard') }}"
            class="flex items-center
                   px-3 py-3
                   rounded-xl
                   transition-all
                   duration-200
                   font-semibold
                   {{ Request::is('dashboard') || Request::is('/')
                        ? 'bg-white/15 text-white shadow-sm'
                        : 'text-blue-100 hover:text-white hover:bg-white/10' }}"
        >

            <svg
                class="w-6 h-6 shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                />
            </svg>

            <span
                class="ml-3
                       opacity-0
                       group-hover:opacity-100
                       transition-opacity
                       duration-300
                       whitespace-nowrap"
            >
                Dashboard Utama
            </span>

        </a>


        {{-- =====================================================
            LABEL MODUL
        ====================================================== --}}
        <div
            class="px-3
                   pt-6
                   pb-2
                   text-[10px]
                   font-extrabold
                   text-blue-200/60
                   uppercase
                   tracking-[0.18em]
                   opacity-0
                   group-hover:opacity-100
                   transition-opacity
                   duration-300
                   whitespace-nowrap">
            Modul Monitoring
        </div>
            {{-- =====================================================
                MODUL 1
                MONITORING ANGGARAN & REALISASI
            ====================================================== --}}
            <div
                x-data="{
                    open:
                        {{ request()->is('dashboard-anggaran*')
                            || request()->is('tim-pemeriksa*')
                            || request()->is('tentative-audit-finding*')
                            ? 'true'
                            : 'false' }}
                }"
            >

                {{-- PARENT MENU --}}
                <button
                    @click="open = !open"
                    type="button"
                    class="w-full
                        flex items-center
                        justify-between
                        px-3 py-3
                        rounded-xl
                        transition-all
                        duration-200
                        font-semibold
                        text-blue-100
                        hover:text-white
                        hover:bg-white/10"
                >

                    {{-- ICON + TITLE --}}
                    <div class="flex items-center min-w-0">

                        <div
                            class="w-6 h-6
                                shrink-0
                                flex items-center justify-center
                                rounded-lg
                                bg-white/10
                                transition-colors
                                duration-200"
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
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 10v2m0-12c-1.11 0-2.08-.402-2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>

                        </div>


                        <span
                            class="ml-3
                                opacity-0
                                group-hover:opacity-100
                                transition-opacity
                                duration-300
                                whitespace-nowrap
                                text-sm"
                        >
                            Anggaran & Realisasi
                        </span>

                    </div>


                    {{-- CHEVRON --}}
                    <svg
                        x-show="true"
                        :class="{ 'rotate-180': open }"
                        class="w-4 h-4
                            shrink-0
                            opacity-0
                            group-hover:opacity-100
                            transition-all
                            duration-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>

                </button>


                {{-- =====================================================
                    SUB MENU
                ====================================================== --}}
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"

                    class="ml-[34px]
                        pl-3
                        pr-2
                        py-1
                        space-y-1
                        border-l
                        border-white/10
                        opacity-0
                        group-hover:opacity-100
                        transition-opacity
                        duration-300"
                >

                    {{-- DASHBOARD ANGGARAN --}}
                    <a
                        href="{{ url('/dashboard-anggaran') }}"
                        class="block
                            py-2
                            px-2
                            rounded-lg
                            text-sm
                            whitespace-nowrap
                            transition-all
                            duration-200
                            {{ request()->is('dashboard-anggaran*')
                                    ? 'text-white font-bold bg-white/10'
                                    : 'text-blue-100/70 hover:text-white hover:bg-white/5' }}"
                    >
                        Dashboard Anggaran
                    </a>


                    {{-- TIM PEMERIKSA --}}
                    <a
                        href="{{ url('/tim-pemeriksa') }}"
                        class="block
                            py-2
                            px-2
                            rounded-lg
                            text-sm
                            whitespace-nowrap
                            transition-all
                            duration-200
                            {{ request()->is('tim-pemeriksa*')
                                    ? 'text-white font-bold bg-white/10'
                                    : 'text-blue-100/70 hover:text-white hover:bg-white/5' }}"
                    >
                        Tim Pemeriksa
                    </a>


                    {{-- TENTATIVE AUDIT FINDING --}}
                    <a
                        href="{{ url('/tentative-audit-finding') }}"
                        class="block
                            py-2
                            px-2
                            rounded-lg
                            text-sm
                            whitespace-nowrap
                            transition-all
                            duration-200
                            {{ request()->is('tentative-audit-finding*')
                                    ? 'text-white font-bold bg-white/10'
                                    : 'text-blue-100/70 hover:text-white hover:bg-white/5' }}"
                    >
                        Tentative Audit Finding
                    </a>

                </div>

            </div>

        {{-- =====================================================
            MODUL 2
        ====================================================== --}}
        <a
            href="#"
            class="flex items-center
                   px-3 py-3
                   rounded-xl
                   transition-all
                   duration-200
                   font-semibold
                   group/menu
                   {{ Request::is('modul-2*')
                        ? 'bg-white/15 text-white shadow-sm'
                        : 'text-blue-100 hover:text-white hover:bg-white/10' }}"
        >

            <div
                class="w-6 h-6
                       shrink-0
                       flex items-center justify-center
                       rounded-lg
                       bg-white/10
                       group-hover/menu:bg-white/20
                       transition-colors"
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
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>

            <span
                class="ml-3
                       opacity-0
                       group-hover:opacity-100
                       transition-opacity
                       duration-300
                       whitespace-nowrap
                       text-sm"
            >
                Tindak Lanjut Rekomendasi
            </span>

        </a>


        {{-- =====================================================
            MODUL 3
        ====================================================== --}}
        <a
            href="#"
            class="flex items-center
                   px-3 py-3
                   rounded-xl
                   transition-all
                   duration-200
                   font-semibold
                   group/menu
                   {{ Request::is('modul-3*')
                        ? 'bg-white/15 text-white shadow-sm'
                        : 'text-blue-100 hover:text-white hover:bg-white/10' }}"
        >

            <div
                class="w-6 h-6
                       shrink-0
                       flex items-center justify-center
                       rounded-lg
                       bg-white/10
                       group-hover/menu:bg-white/20
                       transition-colors"
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
                        d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 001.73 3z"
                    />
                </svg>
            </div>

            <span
                class="ml-3
                       opacity-0
                       group-hover:opacity-100
                       transition-opacity
                       duration-300
                       whitespace-nowrap
                       text-sm"
            >
                Kerugian Negara
            </span>

        </a>


        {{-- =====================================================
            MODUL 4
        ====================================================== --}}
        <a
            href="#"
            class="flex items-center
                   px-3 py-3
                   rounded-xl
                   transition-all
                   duration-200
                   font-semibold
                   group/menu
                   {{ Request::is('modul-4*')
                        ? 'bg-white/15 text-white shadow-sm'
                        : 'text-blue-100 hover:text-white hover:bg-white/10' }}"
        >

            <div
                class="w-6 h-6
                       shrink-0
                       flex items-center justify-center
                       rounded-lg
                       bg-white/10
                       group-hover/menu:bg-white/20
                       transition-colors"
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
                        d="M4 7h16M4 12h16M4 17h16M7 4v16"
                    />
                </svg>
            </div>

            <span
                class="ml-3
                       opacity-0
                       group-hover:opacity-100
                       transition-opacity
                       duration-300
                       whitespace-nowrap
                       text-sm"
            >
                Database Entitas Pemeriksaan
            </span>

        </a>

    </nav>


    {{-- =========================================================
        BAGIAN BAWAH SIDEBAR
    ========================================================== --}}
    <div
        class="w-64
               px-3
               py-4
               border-t border-white/10
               shrink-0"
    >

        <div
            class="flex items-center
                   px-3 py-2
                   text-blue-100/60"
        >

            <svg
                class="w-5 h-5 shrink-0"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"
                />
            </svg>

            <span
                class="ml-3
                       text-[10px]
                       uppercase
                       tracking-wider
                       whitespace-nowrap
                       opacity-0
                       group-hover:opacity-100
                       transition-opacity
                       duration-300"
            >
                Sistem Monitoring KILAT
            </span>

        </div>

    </div>

</aside>