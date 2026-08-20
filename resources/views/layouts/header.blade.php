@php
    $isDashboard = Request::is('dashboard') || Request::is('/');
@endphp

<header
    @if($isDashboard)
        x-data="{ atTop: true }"
        @scroll.window="atTop = window.scrollY <= 20"
        :class="atTop
            ? 'bg-[#1f5b91] border-transparent shadow-none'
            : 'bg-[#1f5b91]/95 backdrop-blur-xl border-b border-white/15 shadow-lg'"
    @endif
    class="
        sidebar-aware-header
        fixed
        top-0
        right-0
        h-[88px]
        z-[9000]
        bg-[#1f5b91]
        border-b border-white/15
        shadow-lg
        transition-all
        duration-300
        ease-in-out
    "
>
    <div class="h-full px-6 flex items-center justify-end">

        {{-- PROFILE --}}
        <div class="relative">

            <button
                type="button"
                id="btn-profil"
                onclick="toggleProfileMenu(event)"
                class="flex items-center gap-3 focus:outline-none group">

                {{-- USERNAME --}}
                <div class="hidden md:block text-right">

                    <p class="text-sm font-bold text-white leading-none mb-1">
                        {{ auth()->user()->username ?? 'Nama Pengguna' }}
                    </p>

                    <p class="text-[10px] text-blue-100 uppercase tracking-widest font-semibold">
                        Role:
                        {{ auth()->user()->role->nama_role ?? 'Tidak ada role' }}
                    </p>

                </div>


                {{-- AVATAR --}}
                <div
                    class="w-10 h-10
                           rounded-full
                           bg-white
                           flex items-center justify-center
                           text-[#1f5b91]
                           font-extrabold
                           text-sm
                           shadow-md
                           border-2 border-white/80
                           transition-all
                           group-hover:scale-105"
                >
                    {{ strtoupper(substr(auth()->user()->username ?? 'US', 0, 2)) }}
                </div>


                {{-- ARROW --}}
                <svg
                    id="panah-profil"
                    class="w-4 h-4 text-white
                           transition-transform duration-300"
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


            {{-- DROPDOWN --}}
            <div
                id="menu-profil"
                class="absolute right-0 top-full mt-3
                    w-56
                    bg-white
                    border border-gray-100
                    rounded-2xl
                    shadow-xl
                    py-2
                    z-[99999]
                    overflow-hidden
                    opacity-0
                    pointer-events-none
                    translate-y-2
                    transition-all duration-200"
            >

                @php
                    $userRole = auth()->check() && auth()->user()->role
                        ? strtolower(auth()->user()->role->nama_role)
                        : '';
                @endphp

                @if($userRole === 'admin')

                    <a
                        href="{{ route('manajemen-akun.index') }}"
                        class="flex items-center gap-3
                               px-5 py-3
                               text-sm font-bold text-gray-800
                               hover:bg-blue-50
                               hover:text-[#1f5b91]"
                    >
                        ⚙️
                        Manajemen Akun
                    </a>

                    <div class="border-t border-gray-100 my-1"></div>

                @endif


                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3
                               px-5 py-3
                               text-sm font-bold
                               text-red-600
                               hover:bg-red-50
                               text-left"
                    >
                        ↪
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </div>

</header>
<script>
    function toggleProfileMenu(event) {
        event.stopPropagation();

        const menu = document.getElementById('menu-profil');
        const arrow = document.getElementById('panah-profil');

        if (!menu) return;

        const isOpen = menu.classList.contains('opacity-100');

        if (isOpen) {
            // TUTUP
            menu.classList.remove(
                'opacity-100',
                'pointer-events-auto',
                'translate-y-0'
            );

            menu.classList.add(
                'opacity-0',
                'pointer-events-none',
                'translate-y-2'
            );

            arrow?.classList.remove('rotate-180');

        } else {
            // BUKA
            menu.classList.remove(
                'opacity-0',
                'pointer-events-none',
                'translate-y-2'
            );

            menu.classList.add(
                'opacity-100',
                'pointer-events-auto',
                'translate-y-0'
            );

            arrow?.classList.add('rotate-180');
        }
    }


    // Klik di luar dropdown → tutup
    document.addEventListener('click', function (event) {

        const menu = document.getElementById('menu-profil');
        const button = document.getElementById('btn-profil');
        const arrow = document.getElementById('panah-profil');

        if (!menu || !button) return;

        if (
            !menu.contains(event.target) &&
            !button.contains(event.target)
        ) {
            menu.classList.remove(
                'opacity-100',
                'pointer-events-auto',
                'translate-y-0'
            );

            menu.classList.add(
                'opacity-0',
                'pointer-events-none',
                'translate-y-2'
            );

            arrow?.classList.remove('rotate-180');
        }
    });
</script>