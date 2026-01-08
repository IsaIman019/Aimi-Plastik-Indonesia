<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KARTU STATISTIK (Ringkasan Angka)

        // Total Pesanan Masuk
        $totalOrders = Pesanan::count();

        // Hitung Pendapatan (FIXED: Menggunakan kolom 'status')
        // Menjumlahkan uang dari pesanan yang statusnya SUDAH diproses/dikirim/selesai
        // Mengabaikan status 'pending' (belum bayar) dan 'cancelled' (batal)
        $totalRevenue = Pesanan::whereIn('status', ['processed', 'shipped', 'completed'])
            ->sum('total_harga');

        // Total Produk
        $totalProducts = Produk::count();

        // Total Customer (Hanya role pelanggan)
        $totalCustomers = User::where('role', 'pelanggan')->count();


        // 2. TABEL PESANAN TERBARU (Ambil 5 transaksi terakhir)
        $recentOrders = Pesanan::with('user')
            ->latest()
            ->take(5)
            ->get();


        // 3. TABEL STOK MENIPIS
        // Ambil produk yang stoknya kurang dari atau sama dengan 10
        $lowStockProducts = Produk::where('stok', '<=', 10)
            ->orderBy('stok', 'asc')
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
