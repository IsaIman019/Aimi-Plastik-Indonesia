<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Fitur Pencarian
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        
        return view('pelanggan.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);
        
        // Rekomendasi produk lain (random 4 item)
        $relatedProducts = Product::where('is_active', true)
                                  ->where('id', '!=', $id)
                                  ->inRandomOrder()
                                  ->take(4)
                                  ->get();

        return view('pelanggan.products.show', compact('product', 'relatedProducts'));
    }
}