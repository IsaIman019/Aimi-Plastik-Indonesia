<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek: Apakah user sudah login?
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil data user saat ini
        $user = Auth::user();
        
        // 3. Normalisasi Role User (Ubah ke huruf kecil semua biar aman)
        // Contoh: Database 'Admin' tetap terbaca 'admin'
        $userRole = strtolower($user->role);

        // 4. Normalisasi Role yang Diizinkan (dari Route)
        // $roles adalah parameter dari route web.php (misal: 'admin')
        // Kita ubah juga ke huruf kecil
        $allowedRoles = array_map('strtolower', $roles);

        // 5. Cek Kecocokan
        // Apakah role user saat ini ada di daftar yang diizinkan?
        if (in_array($userRole, $allowedRoles)) {
            return $next($request); // SILAKAN MASUK
        }

        // 6. JIKA DITOLAK (Misal: Pelanggan coba akses halaman Admin)
        // Kita lempar balik ke halaman Home User biasa
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman Administrator.');
    }
}