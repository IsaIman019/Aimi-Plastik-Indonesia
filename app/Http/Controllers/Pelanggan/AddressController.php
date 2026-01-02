<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\Address; // <--- INI YANG HILANG SEBELUMNYA

class AddressController extends Controller
{
    // Tampilkan Daftar Alamat
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 
        
        // Ambil data alamat dari relasi user
        $addresses = $user->addresses; 
        
        return view('pelanggan.profile.address', compact('addresses'));
    }

    // Simpan Alamat Baru
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'recipient_name' => 'required|string',
            'phone' => 'required|string',
            'full_address' => 'required|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek apakah user sudah punya alamat? Jika 0, maka alamat ini jadi UTAMA (true)
        $isPrimary = $user->addresses()->count() == 0 ? true : false;

        Address::create([
            'user_id' => $user->id,
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'full_address' => $request->full_address,
            'is_primary' => $isPrimary
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan.');
    }

    // Update Alamat
    public function update(Request $request, $id)
    {
        // Pastikan hanya bisa edit alamat milik sendiri
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        $address->update([
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'full_address' => $request->full_address,
        ]);

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }

    // Set Alamat Utama
    public function setPrimary($id)
    {
        $userId = Auth::id();

        // 1. Set semua alamat user ini jadi BUKAN UTAMA (false)
        Address::where('user_id', $userId)->update(['is_primary' => false]);
        
        // 2. Set alamat yang dipilih jadi UTAMA (true)
        Address::where('user_id', $userId)->where('id', $id)->update(['is_primary' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    // Hapus Alamat
    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        
        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}