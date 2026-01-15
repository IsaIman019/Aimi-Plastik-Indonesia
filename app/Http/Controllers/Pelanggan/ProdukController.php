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
        $produks = Produk::where('ACTIVE', true)->findOrFail($id);

        // Rekomendasi produk lain (random 4 item)
        $Produkterkaits = Produk::where('ACTIVE', true)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pelanggan.produk.show', compact('produks', 'Produkterkaits'));
    }
}
