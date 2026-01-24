<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\User;
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
        $pendingOrders = Pesanan::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processed'])
            ->count();

        return view('pelanggan.profile.index', compact('user', 'pendingOrders'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Validasi
        $request->validate([
            'name'      => 'required|string|max:255', // Input form bernama 'name'
            'phone'     => 'nullable|string|max:15',  // Sesuai varchar(15) di DB
            'avatar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'  => 'nullable|min:8|confirmed',
        ]);

        // 2. Mapping Input ke Database
        // KIRI: Nama Kolom DB (nama) | KANAN: Nama Input Form (name)
        $user->nama = $request->name;

        $user->phone = $request->phone;

        // 3. Update Foto
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path; // Menyimpan path string ke kolom avatar
        }

        // 4. Update Password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Biodata berhasil diperbarui!');
    }
}
