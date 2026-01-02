<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ==========================================================
    // LOGIN
    // ==========================================================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek Credential (Email & Password) ke Database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Ambil User & Role Saat Ini
            $user = Auth::user();
            
            // Konversi role ke huruf kecil untuk keamanan (antisipasi typo di DB: Admin vs admin)
            $role = strtolower($user->role); 

            // 4. LOGIKA REDIRECT (ALUR KUNCI)
            
            // SKENARIO A: Jika Role adalah ADMIN
            // Arahkan ke Dashboard Admin (Grafik, Laporan, Produk, dll)
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            
            // SKENARIO B: Jika Role adalah PELANGGAN (Atau role lain)
            // Arahkan ke Halaman Depan (Beranda/Katalog)
            return redirect()->route('home');
        }

        // 5. Jika Login Gagal (Password/Email Salah)
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ==========================================================
    // REGISTER
    // ==========================================================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // 2. Buat User Baru 
        // PENTING: Role default diset 'pelanggan' agar user biasa tidak masuk admin
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan', 
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        // 3. Otomatis Login setelah daftar
        Auth::login($user);

        // 4. Redirect ke Home (User baru pasti pelanggan)
        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // ==========================================================
    // LOGOUT
    // ==========================================================

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}