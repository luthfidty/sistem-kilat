<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun - KILAT</title>
    <!-- Memanggil Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="min-h-screen">

    <!-- Header -->
    @include('layouts.header')

    <!-- Konten Utama Manajemen Akun -->
    <div class="max-w-7xl mx-auto p-4 md:p-8 animate-fade-in">
        
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-bold flex justify-between items-center">
                {{ session('success') }}
                <button onclick="this.parentElement.style.display='none'" class="text-emerald-700 hover:text-emerald-900">&times;</button>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-bold">
                Gagal menyimpan data! Pastikan Username belum dipakai dan Password minimal 8 karakter.
            </div>
        @endif

        <!-- Header Halaman -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Manajemen Akun</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Kelola data pengguna dan hak akses unit kerja.</p>
            </div>
            <button type="button" onclick="openModalAkun('tambah')" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 text-sm flex items-center gap-2 border border-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Akun
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white/50 backdrop-blur-md border border-white/80 rounded-[2rem] shadow-[0_10px_30px_rgb(0,0,0,0.05)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-200 tracking-wider font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-5">ID</th>
                            <th scope="col" class="px-6 py-5">Username</th>
                            <th scope="col" class="px-6 py-5">Role Akses</th>
                            <th scope="col" class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-white/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-500">#{{ $user->users_id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-gray-800">{{ $user->username }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-gray-100 text-gray-700 border border-gray-200 px-3 py-1 rounded-full text-[10px] font-extrabold tracking-wider uppercase">
                                    {{ $user->role ? $user->role->nama_role : 'Tidak Ada Role' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" onclick="openModalAkun('edit', {{ $user }})" class="p-2 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    
                                    <form action="{{ route('manajemen-akun.destroy', $user->users_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->username }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">Belum ada data akun terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form Akun -->
    <div id="modalAkunOverlay" class="fixed inset-0 z-[100] hidden bg-gray-900/60 backdrop-blur-sm items-center justify-center transition-opacity duration-300 opacity-0 overflow-y-auto">
        <div id="modalAkunContent" class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg p-8 transform scale-95 transition-transform duration-300 relative mx-4 my-8">
            <button type="button" onclick="closeModalAkun()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mb-6">
                <h3 id="modalAkunTitle" class="text-xl font-extrabold text-gray-800 tracking-tight">Tambah Akun Baru</h3>
                <p class="text-xs text-gray-500 font-medium mt-1">Lengkapi informasi di bawah ini.</p>
            </div>
            <form id="formAkun" action="{{ route('manajemen-akun.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="grid grid-cols-1 gap-5 mb-6">
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wide">Username</label>
                        <input type="text" name="username" id="inputUsername" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-gray-800 block w-full p-3 font-medium transition-all" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wide">Role Akses</label>
                        <select name="role_id" id="inputRole" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-gray-800 block w-full p-3 font-semibold cursor-pointer" required>
                            <option value="" disabled selected>Pilih Role...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" id="inputPassword" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-gray-800 block w-full p-3 font-medium transition-all">
                        <p id="passwordHelp" class="mt-1.5 text-[10px] text-gray-400">Gunakan minimal 8 karakter.</p>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModalAkun()" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition-all">Batal</button>
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg transition-all">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modalOverlay = document.getElementById('modalAkunOverlay');
        const modalContent = document.getElementById('modalAkunContent');
        const formAkun = document.getElementById('formAkun');
        const formMethod = document.getElementById('formMethod');
        
        function openModalAkun(mode, user = null) {
            formAkun.reset(); 
            if (mode === 'tambah') {
                document.getElementById('modalAkunTitle').textContent = "Tambah Akun Baru";
                formAkun.action = "{{ route('manajemen-akun.store') }}";
                formMethod.value = "POST";
                document.getElementById('inputPassword').required = true;
                document.getElementById('passwordHelp').textContent = "Wajib diisi, minimal 8 karakter.";
            } else if (mode === 'edit' && user) {
                document.getElementById('modalAkunTitle').textContent = "Edit Data Akun";
                formAkun.action = `/manajemen-akun/${user.users_id}`;
                formMethod.value = "PUT";
                document.getElementById('inputUsername').value = user.username;
                document.getElementById('inputRole').value = user.role_id;
                document.getElementById('inputPassword').required = false;
                document.getElementById('passwordHelp').textContent = "Biarkan kosong jika tidak ingin mengubah password.";
            }
            modalOverlay.classList.remove('hidden');
            modalOverlay.classList.add('flex');
            setTimeout(() => {
                modalOverlay.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeModalAkun() {
            modalOverlay.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modalOverlay.classList.add('hidden');
                modalOverlay.classList.remove('flex');
            }, 300);
        }
    </script>
</body>
</html>