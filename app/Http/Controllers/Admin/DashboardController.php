<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KARTU STATISTIK (Ringkasan Angka)
        
        // Total Pesanan Masuk
        $totalOrders = Order::count();

        // Hitung Pendapatan (FIXED: Menggunakan kolom 'status')
        // Menjumlahkan uang dari pesanan yang statusnya SUDAH diproses/dikirim/selesai
        // Mengabaikan status 'pending' (belum bayar) dan 'cancelled' (batal)
        $totalRevenue = Order::whereIn('status', ['processed', 'shipped', 'completed'])
                             ->sum('total_price');

        // Total Produk
        $totalProducts = Product::count();

        // Total Customer (Hanya role pelanggan)
        $totalCustomers = User::where('role', 'pelanggan')->count();


        // 2. TABEL PESANAN TERBARU (Ambil 5 transaksi terakhir)
        $recentOrders = Order::with('user')
                             ->latest()
                             ->take(5)
                             ->get();


        // 3. TABEL STOK MENIPIS 
        // Ambil produk yang stoknya kurang dari atau sama dengan 10
        $lowStockProducts = Product::where('stock', '<=', 10)
                                   ->orderBy('stock', 'asc')
                                   ->take(5)
                                   ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'totalRevenue', 
            'totalProducts', 
            'totalCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}