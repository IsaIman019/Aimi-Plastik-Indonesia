<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::take(8)->get();

        $produkTerbaru = Produk::where('status', 'ACTIVE')
            ->latest()
            ->take(6)
            ->get();

        $bestSeller = Produk::where('status', 'ACTIVE')
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('pelanggan.produk.index', compact(
            'kategoris',
            'produkTerbaru',
            'bestSeller'
        ));
    }

    public function all(Request $request)
    {
        $kategoris = Kategori::withCount('produk')->get();
        $query = Produk::where('status', 'ACTIVE');


        if ($request->filled('kategori') && is_array($request->kategori)) {
            $query->whereIn('kategori_id', $request->kategori);
        }

        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        $produks = $query->paginate(20)->withQueryString();

        return view('pelanggan.produk.catalog', compact('produks', 'kategoris'));
    }

    public function kategori(Request $request, $id)
    {
        $kategoriSelected = Kategori::withCount('produk')->findOrFail($id);

        $kategoris = Kategori::withCount('produk')->get();

        $query = Produk::where('status', 'ACTIVE')
            ->where('kategori_id', $id);

        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        $produks = $query->paginate(20)->withQueryString();

        return view('pelanggan.produk.catalog', compact('produks', 'kategoris', 'kategoriSelected'));
    }

    public function show($id)
    {
        $produk = Produk::with(['kategori', 'varian'])
            ->where('status', 'ACTIVE')
            ->findOrFail($id);

        $produkTerkaits = Produk::where('status', 'ACTIVE')
            ->where('id', '!=', $id)
            ->where('kategori_id', $produk->kategori_id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pelanggan.produk.show', compact('produk', 'produkTerkaits'));
    }
}
