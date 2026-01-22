<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori; // Pastikan model Kategori di-import
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // Jika ada pencarian, gunakan tampilan pencarian (bisa menggunakan view lama atau khusus search)
        if ($request->has('search') && !empty($request->search)) {
            $produks = Produk::where('status', 'ACTIVE')
                ->where('nama', 'like', '%' . $request->search . '%')
                ->latest()
                ->paginate(12);
            return view('pelanggan.produk.search', compact('produks')); // Buat view search.blade.php jika perlu, atau gunakan index lama
        }

        // --- DATA UNTUK HOMEPAGE ---

        // 1. Ambil Kategori (Untuk menu ikon di atas)
        $kategoris = Kategori::take(8)->get();

        // 2. Produk Terbaru (Baris pertama)
        $produkTerbaru = Produk::where('status', 'ACTIVE')
            ->latest()
            ->take(6)
            ->get();

        // 3. Best Seller (Simulasi: ambil acak atau berdasarkan field 'terjual' jika ada)
        $bestSeller = Produk::where('status', 'ACTIVE')
            ->inRandomOrder()
            ->take(5)
            ->get();

        // 4. Keamanan Rumah (Filter berdasarkan nama kategori 'Rumah' atau ID spesifik)
        $keamananRumah = Produk::where('status', 'ACTIVE')
            ->whereHas('kategori', function ($q) {
                $q->where('nama', 'like', '%Rumah%')
                    ->orWhere('nama', 'like', '%Home%');
            })
            ->take(5)
            ->get();

        // 5. Keamanan Kendaraan
        $keamananKendaraan = Produk::where('status', 'ACTIVE')
            ->whereHas('kategori', function ($q) {
                $q->where('nama', 'like', '%Kendaraan%')
                    ->orWhere('nama', 'like', '%Traffic%')
                    ->orWhere('nama', 'like', '%Jalan%');
            })
            ->take(5)
            ->get();

        // 6. Lingkungan Kerja
        $lingkunganKerja = Produk::where('status', 'ACTIVE')
            ->whereHas('kategori', function ($q) {
                $q->where('nama', 'like', '%Kerja%')
                    ->orWhere('nama', 'like', '%Proyek%')
                    ->orWhere('nama', 'like', '%Safety%');
            })
            ->take(5)
            ->get();

        return view('pelanggan.produk.index', compact(
            'kategoris',
            'produkTerbaru',
            'bestSeller',
            'keamananRumah',
            'keamananKendaraan',
            'lingkunganKerja'
        ));
    }

    public function all(Request $request)
    {
        // 1. Ambil Kategori dan hitung jumlah produknya
        // Pastikan nama fungsi relasi di Model Kategori adalah 'produks' atau 'produk'
        // Jika error "Call to undefined method", cek Model Kategori Anda.
        $kategoris = Kategori::withCount('produk')->get();

        // 2. Query Dasar
        $query = Produk::where('status', 'ACTIVE');

        // 3. Filter Kategori (Array Checkbox)
        // name="kategori[]" di view akan diterima sebagai array di sini
        if ($request->filled('kategori') && is_array($request->kategori)) {
            $query->whereIn('kategori_id', $request->kategori);
        }

        // 4. Filter Harga
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // 6. Pagination (Append Query String agar filter tidak hilang saat pindah halaman)
        $produks = $query->paginate(20)->withQueryString();

        return view('pelanggan.produk.catalog', compact('produks', 'kategoris'));
    }

    public function show($id)
    {
        $produk = Produk::with(['kategori', 'varian'])
            ->where('status', 'ACTIVE')
            ->findOrFail($id);

        $produkTerkaits = Produk::where('status', 'ACTIVE')
            ->where('id', '!=', $id)
            ->where('kategori_id', $produk->kategori_id) // Lebih relevan jika satu kategori
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pelanggan.produk.show', compact('produk', 'produkTerkaits'));
    }
}