<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
public function index()
{
    $user = Auth::user();

    $status = request('status', 'pending'); // default pending

    $ordersQuery = Pesanan::where('user_id', $user->id);

    if ($status !== 'semua') {
        $ordersQuery->where('status', $status);
    }

    $orders = $ordersQuery->latest()
        ->paginate(10)
        ->withQueryString();

    // hitung badge per status
    $statusCounts = Pesanan::where('user_id', $user->id)
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    return view('pelanggan.orders.index', compact(
        'user',
        'orders',
        'status',
        'statusCounts'
    ));
}



    public function show($id)
    {
        $order = Pesanan::with('orderItems.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('pelanggan.orders.show', compact('order'));
    }
}
