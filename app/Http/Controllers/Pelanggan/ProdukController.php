<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::where('status', 'ACTIVE');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $produks = $query->latest()->paginate(12);

        return view('pelanggan.produk.index', compact('produks'));
    }

    public function show($id)
    {
        $produk = Produk::with(['kategori', 'varian'])
            ->where('status', 'ACTIVE')
            ->findOrFail($id);

        $produkTerkaits = Produk::where('status', 'ACTIVE')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pelanggan.produk.show', compact('produk', 'produkTerkaits'));
    }

    
}
