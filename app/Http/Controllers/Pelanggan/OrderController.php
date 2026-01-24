<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Pesanan::where('user_id', Auth::id())->latest()->paginate(10);
        return view('pelanggan.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Pesanan::with('orderItems.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('pelanggan.orders.show', compact('order'));
    }
}
