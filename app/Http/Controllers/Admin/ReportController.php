<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Input Tanggal dari Filter (Default: Bulan Ini)
        $startDate = $request->input('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // 2. Query Dasar: Ambil Order yang SUDAH SELESAI / DIKIRIM dalam rentang tanggal
        // Status yang dihitung: processed, shipped, completed (uang dianggap masuk)
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
                        ->whereIn('status', ['processed', 'shipped', 'completed'])
                        ->latest()
                        ->get();

        // 3. Hitung Statistik Ringkasan
        $totalRevenue = $orders->sum('total_price');
        $totalTransactions = $orders->count();
        $totalItemsSold = 0; // Kalau mau detail, harus ada relasi order_items, sementara kita skip atau hitung manual jika ada

        // 4. Hitung Pelanggan Baru di periode ini
        $newCustomers = User::where('role', 'pelanggan')
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->count();

        // 5. Data untuk Grafik / Tabel Harian
        // Mengelompokkan pendapatan per tanggal
        $dailyReports = $orders->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function ($row) {
            return [
                'total' => $row->sum('total_price'),
                'count' => $row->count(),
            ];
        });

        return view('admin.reports.index', compact(
            'startDate', 
            'endDate', 
            'totalRevenue', 
            'totalTransactions', 
            'newCustomers',
            'orders',
            'dailyReports'
        ));
    }
}