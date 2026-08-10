<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ==========================================
    // BAGIAN 1: AUTHENTICATION & LOGIN
    // ==========================================

    public function showLogin()
    {
        // Pastikan nama filenya sesuai, misal: resources/views/login.blade.php
        return view('login'); 
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        // Proses pencocokan ke database
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            
            // Redirect ke halaman dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika gagal
        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }


    // ==========================================
    // BAGIAN 2: MANAJEMEN AKUN
    // ==========================================

    public function index()
    {
        // Ambil data user beserta rolenya, urutkan dari terbaru
        $users = User::with('role')->latest('created_at')->paginate(10);
        // Ambil semua role untuk dropdown form
        $roles = Role::all(); 
        
        return view('manajemen-akun', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'role_id'  => 'required|exists:role,id',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'username' => $request->username,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->users_id . ',users_id',
            'role_id'  => 'required|exists:role,id',
            'password' => 'nullable|string|min:8',
        ]);

        $user->username = $request->username;
        $user->role_id = $request->role_id;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }


    // ==========================================
    // BAGIAN 3: MATRIKS PPK TRANS
    // ==========================================

    /**
     * Menampilkan halaman Dashboard PPK
     */
    public function dashboardPpk()
    {
        return view('ppktrans.dashboard-ppk'); 
    }

    /**
     * Menampilkan halaman Matriks Utama
     */
    public function inputMatriks()
    {
        return view('ppktrans.input-ppk'); 
    }

    /**
     * Menampilkan halaman Detail per Satker
     */
    public function detailPpk(Request $request)
    {
        $satker = $request->query('satker', 'Ses Ditjen PPK Trans');
        return view('ppktrans.detail-ppk', compact('satker'));
    }

    /**
     * Menampilkan halaman Rekapitulasi
     */
    public function rekapPpk(Request $request)
    {
        $mingguAktif = $request->query('minggu', 'M1');
        $bulanAktif = $request->query('bulan', 'Juli');
        $tahunAktif = $request->query('tahun', date('Y')); 

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

        // Tambahkan ppktrans. di depan nama view
        return view('ppktrans.rekap-ppk', compact(
            'mingguAktif', 'bulanAktif', 'tahunAktif', 'daftarBulan', 'daftarMinggu', 'daftarSatker'
        ));
    }

    // ==========================================
    // BAGIAN 4: MATRIKS PEMT (BARU)
    // ==========================================

    /**
     * Menampilkan halaman Dashboard PEMT
     */
    public function dashboardPemt()
    {
        return view('pemt.dashboard-pemt'); 
    }

    /**
     * Menampilkan halaman Matriks Utama PEMT
     */
    public function inputMatriksPemt()
    {
        return view('pemt.input-pemt'); 
    }

    /**
     * Menampilkan halaman Detail per Satker PEMT
     */
    public function detailPemt(Request $request)
    {
        // Tangkap nama satker dari URL, default ke Sesditjen PEMT
        $satker = $request->query('satker', 'Sesditjen PEMT');
        
        return view('pemt.detail-pemt', compact('satker'));
    }

    /**
     * Menampilkan halaman Rekapitulasi PEMT
     */
    public function rekapPemt(Request $request)
    {
        $mingguAktif = $request->query('minggu', 'M1');
        $bulanAktif = $request->query('bulan', 'Juli');
        $tahunAktif = $request->query('tahun', date('Y')); 

        $daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftarMinggu = ['M1', 'M2', 'M3', 'M4'];
        
        // Data Dummy Satker PEMT
        $daftarSatker = [
            'Sesditjen PEMT',
            'Direktorat Perencanaan Ekstensifikasi',
            'Direktorat Pembangunan Penempatan',
            'Direktorat Pembinaan Lingkungan',
            'Direktorat Pengembangan Ekonomi',
            'Direktorat Sosial Budaya'
        ];

        return view('pemt.rekap-pemt', compact(
            'mingguAktif', 'bulanAktif', 'tahunAktif', 'daftarBulan', 'daftarMinggu', 'daftarSatker'
        ));
    }
}