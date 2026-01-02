@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-4 md:p-8 overflow-y-auto h-screen">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
                <p class="text-gray-500 mt-1">Halo Admin, ini ringkasan performa <span class="text-orange-600 font-bold">Aimi Packaging</span> hari ini.</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Produk
                </a>

                <a href="{{ route('admin.news.create') }}" class="flex items-center gap-2 bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Tulis Berita
                </a>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2 bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Lihat Laporan
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-orange-200 transition">
                <div class="absolute right-0 top-0 h-full w-1 bg-green-500 rounded-r-2xl"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-2xl font-black text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <div class="flex items-center mt-2 text-xs font-bold text-green-600 bg-green-50 w-fit px-2 py-1 rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +12.5% <span class="text-gray-400 font-normal ml-1">vs bulan lalu</span>
                        </div>
                    </div>
                    <div class="p-3 bg-green-100 text-green-600 rounded-xl group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-orange-200 transition">
                <div class="absolute right-0 top-0 h-full w-1 bg-orange-500 rounded-r-2xl"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pesanan</p>
                        <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalOrders }}</h3>
                        <div class="flex items-center mt-2 text-xs font-bold text-orange-600 bg-orange-50 w-fit px-2 py-1 rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +5 Order <span class="text-gray-400 font-normal ml-1">hari ini</span>
                        </div>
                    </div>
                    <div class="p-3 bg-orange-100 text-orange-600 rounded-xl group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-orange-200 transition">
                <div class="absolute right-0 top-0 h-full w-1 bg-blue-500 rounded-r-2xl"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                        <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalProducts }}</h3>
                        <div class="flex items-center mt-2 text-xs font-bold text-gray-500 bg-gray-100 w-fit px-2 py-1 rounded-full">
                            <span>Aktif di Katalog</span>
                        </div>
                    </div>
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-xl group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:border-orange-200 transition">
                <div class="absolute right-0 top-0 h-full w-1 bg-purple-500 rounded-r-2xl"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pelanggan</p>
                        <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalCustomers }}</h3>
                        <div class="flex items-center mt-2 text-xs font-bold text-purple-600 bg-purple-50 w-fit px-2 py-1 rounded-full">
                            Registered Users
                        </div>
                    </div>
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-xl group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900 text-lg">Analitik Penjualan</h3>
                    <select class="text-xs border-gray-200 rounded-lg text-gray-500 focus:ring-orange-500">
                        <option>7 Hari Terakhir</option>
                        <option>Bulan Ini</option>
                    </select>
                </div>
                <div id="salesChart" style="min-height: 300px;"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 text-lg mb-6">Status Pesanan</h3>
                <div id="statusChart" style="min-height: 300px;"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 text-lg">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.orders') }}" class="text-sm text-orange-600 hover:text-orange-700 font-bold">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Invoice</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-mono font-bold text-gray-700">#{{ $order->invoice_number }}</span>
                                    <div class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d M, H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $order->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'processed' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-indigo-100 text-indigo-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                        $statusLabel = match($order->status) {
                                            'pending' => 'Menunggu Bayar',
                                            'processed' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Batal',
                                            default => $order->status
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-gray-400 hover:text-orange-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900 text-lg">Stok Menipis</h3>
                        <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">Action Needed</span>
                    </div>
                    <div class="space-y-5">
                        @forelse($lowStockProducts as $product)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-500 overflow-hidden border border-gray-200">
                                    @if($product->image)
                                        {{-- PERBAIKAN: Menambahkan 'storage/' agar gambar produk muncul --}}
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">ID: #{{ $product->id }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-red-600 font-black text-lg">{{ $product->stock }}</span>
                                <p class="text-[10px] text-gray-400">Pcs left</p>
                            </div>
                        </div>
                        
                        <div class="w-full bg-gray-100 rounded-full h-1.5 -mt-2">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width:min($product->stock * 10, 100)%"></div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm text-gray-500">Semua stok aman!</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-gray-900 text-lg">Pintasan Konten</h3>
                        <a href="{{ route('admin.news.index') }}" class="text-xs text-orange-600 font-bold hover:underline">Kelola Berita →</a>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Kelola artikel berita untuk halaman depan website.</p>
                    <a href="{{ route('admin.news.create') }}" class="block w-full text-center py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-orange-500 hover:text-orange-500 font-bold text-sm transition">
                        + Tulis Artikel Baru
                    </a>
                </div>

                <div class="bg-orange-50 rounded-xl p-4 border border-orange-100 text-center">
                    <p class="text-xs text-orange-800 font-bold">Aimi Packaging Admin Panel</p>
                    <p class="text-[10px] text-orange-600 mt-1">&copy; {{ date('Y') }} All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Config Chart tidak berubah (tetap sama)
    var salesOptions = { series: [{ name: 'Penjualan', data: [31, 40, 28, 51, 42, 109, 100] }], chart: { height: 300, type: 'area', fontFamily: 'sans-serif', toolbar: { show: false } }, colors: ['#ea580c'], dataLabels: { enabled: false }, stroke: { curve: 'smooth', width: 3 }, xaxis: { categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"], }, fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2, stops: [0, 90, 100] } }, grid: { borderColor: '#f3f4f6' } };
    var salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
    salesChart.render();

    var statusOptions = { series: [44, 55, 13, 33], chart: { height: 300, type: 'donut', fontFamily: 'sans-serif', }, labels: ['Pending', 'Diproses', 'Dikirim', 'Selesai'], colors: ['#fcd34d', '#3b82f6', '#6366f1', '#22c55e'], plotOptions: { pie: { donut: { size: '75%', labels: { show: true, total: { show: true, label: 'Total', formatter: function (w) { return w.globals.seriesTotals.reduce((a, b) => a + b, 0) } } } } } }, legend: { position: 'bottom' } };
    var statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
    statusChart.render();
</script>
@endsection