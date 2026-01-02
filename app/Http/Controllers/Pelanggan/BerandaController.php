<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        return view('pelanggan.home', [
            'products' => Product::where('is_active', true)
                ->with('category')
                ->latest()
                ->limit(8)
                ->get(),

            'reviews' => Review::with('user')
                ->latest()
                ->limit(5)
                ->get()
        ]);
    }
}
