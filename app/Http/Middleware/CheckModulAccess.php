<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModulAccess
{
    public function handle(Request $request, Closure $next, $modul): Response
    {
        // 1. Pastikan user sudah login & punya role
        if (!Auth::check() || !Auth::user()->role) {
            return redirect('/login');
        }

        // 2. Ambil nama role dan jadikan huruf kapital
        $userRole = strtoupper(Auth::user()->role->nama_role);

        // 3. Superadmin bebas akses ke semua modul
        if ($userRole === 'SUPERADMIN') {
            return $next($request);
        }

        // ==========================================
        // 4. DAFTAR AKSES ROLE PPK TRANS
        // ==========================================
        $rolesPpk = [
            'PPK TRANS', // Akun Pusat (picppktrans)
            'SES DITJEN PPK TRANS',
            'DIT. PERENCANAAN PERWUJUDAN KAWASAN TRANSMIGRASI',
            'DIT. PEMBANGUNAN KAWASAN TRANSMIGRASI',
            'DIT. FASILITASI PENATAAN PERSEBARAN PENDUDUK DI KAWASAN TRANSMIGRASI',
            'DIT. PENGEMBANGAN SATUAN PERMUKIMAN DAN PUSAT SATUAN KAWASAN PENGEMBANGAN',
            'DIT. PENGEMBANGAN KAWASAN TRANSMIGRASI'
        ];

        // ==========================================
        // 5. DAFTAR AKSES ROLE PEMT
        // ==========================================
        $rolesPemt = [
            'PEMT', // Akun Pusat (picpemt)
            'SES. DITJEN PEMT',
            'DIT. PERENCANAAN TEKNIS PENGEMBANGAN EKONOMI DAN PEMBERDAYAAN MASYARAKAT TRANSMIGRASI',
            'DIT. PENGEMBANGAN PRODUK UNGGULAN TRANSMIGRASI',
            'DIT. PENGEMBANGAN KELEMBAGAAN EKONOMI TRANSMIGRASI',
            'DIT. PROMOSI DAN PEMASARAN PRODUK UNGGULAN TRANSMIGRASI',
            'DIT. PEMBERDAYAAN MASYARAKAT TRANSMIGRASI'
        ];

        // 6. Validasi jika masuk ke rute PPK
        if (strtoupper($modul) === 'PPK') {
            if (in_array($userRole, $rolesPpk)) {
                return $next($request);
            }
        }

        // 7. Validasi jika masuk ke rute PEMT
        if (strtoupper($modul) === 'PEMT') {
            if (in_array($userRole, $rolesPemt)) {
                return $next($request);
            }
        }

        // 8. Jika tidak terdaftar di modul tersebut, TENDANG!
        abort(403, 'FORBIDDEN: ANDA TIDAK MEMILIKI IZIN UNTUK MENGAKSES MODUL INI.');
    }
}