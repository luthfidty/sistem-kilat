<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KILAT</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col font-sans bg-white">

    <!-- Header Biru -->
    <div class="h-[62px] bg-[#1f5b91]"></div>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4 py-10">

        <!-- Login Card -->
        <div class="w-full max-w-[440px]">

            <div class="bg-white rounded-[24px] border border-gray-200
                        shadow-lg px-9 sm:px-10 py-10">

                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img
                        src="{{ asset('KILAT.png') }}"
                        alt="Logo KILAT"
                        class="w-[190px] h-auto object-contain"
                    >
                </div>

                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-[26px] font-bold text-gray-900">
                        Sign in
                    </h1>

                    <p class="text-sm text-gray-600 mt-1">
                        Silakan masuk ke akun Anda
                    </p>
                </div>

                <!-- Error -->
                @if($errors->any())
                    <div class="mb-5 px-4 py-3 bg-red-50
                                border border-red-200 text-red-600
                                text-sm rounded-lg">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mb-5">
                        <label
                            for="username"
                            class="block text-gray-900 text-sm font-semibold mb-2"
                        >
                            Username
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                            autocomplete="username"
                            class="w-full px-4 py-3.5
                                   rounded-lg
                                   border border-gray-300
                                   bg-white
                                   text-gray-800
                                   placeholder-gray-400
                                   text-sm
                                   focus:border-[#1f5b91]
                                   focus:ring-2
                                   focus:ring-[#1f5b91]/20
                                   focus:outline-none
                                   transition"
                        >
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label
                            for="password"
                            class="block text-gray-900 text-sm font-semibold mb-2"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3.5
                                   rounded-lg
                                   border border-gray-300
                                   bg-white
                                   text-gray-800
                                   placeholder-gray-400
                                   text-sm
                                   focus:border-[#1f5b91]
                                   focus:ring-2
                                   focus:ring-[#1f5b91]/20
                                   focus:outline-none
                                   transition"
                        >
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center mb-7">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4
                                       text-[#1f5b91]
                                       border-gray-300
                                       rounded
                                       focus:ring-[#1f5b91]"
                            >

                            <span class="ml-2 text-sm text-gray-700">
                                Remember me
                            </span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        class="w-full
                               bg-[#1f5b91]
                               hover:bg-[#174a78]
                               text-white
                               font-semibold
                               py-3.5
                               rounded-lg
                               transition
                               duration-200
                               shadow-sm"
                    >
                        Masuk
                    </button>

                </form>

                <!-- Register -->
                <div class="text-center mt-7">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a
                            href="{{ route('register') }}"
                            class="font-semibold text-[#1f5b91]
                                   hover:text-[#174a78]
                                   hover:underline"
                        >
                            Register
                        </a>
                    </p>
                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>