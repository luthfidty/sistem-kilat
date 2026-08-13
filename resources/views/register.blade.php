<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KILAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-lg bg-white rounded-3xl shadow-xl p-10">

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-[#102a4a]">
            Register
        </h1>

        <p class="text-slate-500 mt-2">
            Buat akun KILAT
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-5">
            <label class="font-semibold text-sm">Username</label>
            <input
                type="text"
                name="username"
                class="w-full mt-2 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#102a4a]"
                required>
        </div>

        <div class="mb-5">
            <label class="font-semibold text-sm">Password</label>
            <input
                type="password"
                name="password"
                class="w-full mt-2 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#102a4a]"
                required>
        </div>

        <div class="mb-8">
            <label class="block font-semibold text-sm mb-2">
                Role
            </label>

            <select
                name="role_id"
                class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#102a4a]"
                required>

                <option value="">-- Pilih Role --</option>

                @foreach($roles as $role)
                    <option value="{{ $role->id }}">
                        {{ $role->nama_role }}
                    </option>
                @endforeach

            </select>
        </div>

        <button
            class="w-full bg-[#102a4a] text-white py-3 rounded-xl hover:bg-[#18395f] transition">
            Register
        </button>

        <div class="text-center mt-6">
            <span class="text-slate-500">
                Sudah memiliki akun?
            </span>

            <a href="{{ route('login') }}"
               class="text-[#102a4a] font-semibold hover:underline">
                Login
            </a>
        </div>

    </form>

</div>

</body>

</html>