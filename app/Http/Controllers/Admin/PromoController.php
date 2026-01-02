<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        // Ambil semua produk untuk dipilih
        $products = Product::all();
        return view('admin.promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'products' => 'required|array' // Wajib pilih minimal 1 produk
        ]);

        $promo = Promo::create($request->except('products'));
        
        // Sambungkan promo ke produk yang dipilih
        $promo->products()->sync($request->products);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dibuat!');
    }

    public function edit(Promo $promo)
    {
        $products = Product::all();
        // Ambil ID produk yang sedang terhubung dengan promo ini
        $selectedProducts = $promo->products->pluck('id')->toArray();
        
        return view('admin.promos.edit', compact('promo', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'products' => 'required|array'
        ]);

        $promo->update($request->except('products'));
        $promo->products()->sync($request->products); // Update relasi produk

        return redirect()->route('admin.promos.index')->with('success', 'Promo diperbarui!');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return back()->with('success', 'Promo dihapus.');
    }
}