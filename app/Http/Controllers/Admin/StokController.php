<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // 1. TAMPILKAN HALAMAN MANAJEMEN STOK
    public function index()
    {
        // Ambil produk, urutkan dari stok terendah (ASC) agar yang habis muncul diatas
        $produk = produk::select('id', 'name', 'image', 'stock', 'category_id')
                            ->with('category')
                            ->orderBy('stock', 'asc') // Stok sedikit di atas
                            ->paginate(15);

        return view('admin.stok.index', compact('produk'));
    }

    // 2. PROSES UPDATE STOK CEPAT
    public function update(Request $request, $id)
    {
        $produk = produk::findOrFail($id);

        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        // Update stok
        $produk->update([
            'stock' => $request->stock
        ]);

        // Cek jika stok 0, otomatis non-aktifkan (Opsional, tapi bagus untuk UX)
        if ($produk->stock == 0) {
            $produk->update(['is_active' => false]);
            $msg = 'Stok diperbarui jadi 0 (Produk dinonaktifkan).';
        } else {
            // Jika stok diisi lagi, aktifkan kembali
            $produk->update(['is_active' => true]);
            $msg = 'Stok berhasil diperbarui.';
        }

        return redirect()->back()->with('success', $msg);
    }
}