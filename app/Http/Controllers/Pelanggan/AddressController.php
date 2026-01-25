<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use App\Models\Address; // <--- INI YANG HILANG SEBELUMNYA
use App\Models\Alamat;

class AddressController extends Controller
{
    // Tampilkan Daftar Alamat
    public function index()
    {
        $user = Auth::user(); 
        
        // Ambil data alamat dari relasi user
        $addresses = $user->alamat; 
        
        return view('pelanggan.profile.address', compact('user','addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'            => 'required|string|max:50',
            'nama_penerima'    => 'required|string|max:100',
            'phone'            => 'required|string|max:20',
            'alamat_lengkap'   => 'required|string',
            'provinsi'         => 'required|string|max:100',
            'kota'             => 'required|string|max:100',
            'kecamatan'        => 'required|string|max:100',
            'kode_pos'         => 'required|string|max:10',
            'rt'               => 'nullable|string|max:5',
            'rw'               => 'nullable|string|max:5',
            'latitude'         => 'nullable|string',
            'longitude'        => 'nullable|string',
            'is_utama'         => 'nullable|boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika ini alamat pertama user → otomatis utama
        $isUtama = $user->alamat()->count() === 0
            ? true
            : ($request->has('is_utama') ? true : false);

        // Kalau user memilih alamat utama → reset alamat lain
        if ($isUtama) {
            $user->alamat()->update(['is_utama' => false]);
        }

        Alamat::create([
            'user_id'         => $user->id,
            'label'           => $request->label,
            'nama_penerima'   => $request->nama_penerima,
            'phone'           => $request->phone,
            'alamat_lengkap'  => $request->alamat_lengkap,
            'provinsi'        => $request->provinsi,
            'kota'            => $request->kota,
            'kecamatan'       => $request->kecamatan,
            'kode_pos'        => $request->kode_pos,
            'rt'              => $request->rt,
            'rw'              => $request->rw,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'is_utama'        => $isUtama,
        ]);

        return redirect()
            ->route('pelanggan.address.index')
            ->with('success', 'Alamat berhasil ditambahkan.');
    }


    // Update Alamat
    public function update(Request $request, $id)
    {
        // Pastikan hanya bisa edit alamat milik sendiri
        $address = Alamat::where('user_id', Auth::id())->findOrFail($id);

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
        Alamat::where('user_id', $userId)->update(['is_utama' => false]);
        
        // 2. Set alamat yang dipilih jadi UTAMA (true)
        Alamat::where('user_id', $userId)->where('id', $id)->update(['is_utama' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    // Hapus Alamat
    public function destroy($id)
    {
        $address = Alamat::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();
        
        return back()->with('success', 'Alamat berhasil dihapus.');
    }
}