<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
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

    public function getRegister()
    {
         $roles = Role::orderBy('nama_role')->get();

        return view('register', compact('roles'));
    }

    public function register(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required|min:3|max:255',
            'role_id' => 'required|exists:role,id',
            'password' => 'required|string|min:6|max:10',
        ]);

        User::create([
            'username' => $validatedData['username'],
            'role_id' => $validatedData['role_id'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

}
