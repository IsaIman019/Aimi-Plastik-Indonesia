<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan import User ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Hitung pesanan aktif (pending/processed) untuk badge notifikasi
        $pendingOrders = \App\Models\Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processed'])
            ->count();

        return view('pelanggan.profile.index', compact('user', 'pendingOrders'));
    }

    public function update(Request $request)
    {
        // -----------------------------------------------------------
        // PERBAIKAN DI SINI (Menambahkan Type Hinting)
        // -----------------------------------------------------------
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string|max:500', 
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'  => 'nullable|min:8|confirmed',
        ]);

        // 1. Update Data Dasar
        $user->name = $request->name;
        $user->phone = $request->phone;
        // Jika user belum pakai fitur Alamat Ganda, simpan di kolom address biasa
        // (Opsional: Jika sudah pakai tabel addresses, baris ini bisa dihapus/disesuaikan)
        $user->address = $request->address; 

        // 2. Update Foto Profil
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Update Password (Jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Sekarang error 'Undefined method save' akan hilang
        $user->save(); 

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}