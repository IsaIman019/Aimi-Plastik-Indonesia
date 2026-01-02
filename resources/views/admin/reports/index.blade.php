@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-8 overflow-y-auto h-screen">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Penjualan</h1>
            <p class="text-gray-500 mb-6">Analisa performa toko berdasarkan periode waktu.</p>

            <form action="{{ route('admin.reports.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-end gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <button type="submit" class="px-6 py-2.5 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 transition shadow-lg shadow-orange-200">
                    Filter Laporan
                </button>
                <a href="{{ route('admin.reports.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-lg hover:bg-gray-200 transition">
                    Reset
                </a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-green-500">
                <p class="text-sm text-gray-500 font-bold uppercase">Total Pendapatan</p>
                <h3 class="text-2xl font-black text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p class="text-xs text-green-600 mt-1 font-bold">Periode Terpilih</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
                <p class="text-sm text-gray-500 font-bold uppercase">Total Transaksi</p>
                <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalTransactions }} Order</h3>
                <p class="text-xs text-blue-600 mt-1 font-bold">Status: Selesai / Dikirim</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-purple-500">
                <p class="text-sm text-gray-500 font-bold uppercase">Pelanggan Baru</p>
                <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $newCustomers }} User</h3>
                <p class="text-xs text-purple-600 mt-1 font-bold">Mendaftar di periode ini</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-lg">Rincian Transaksi Masuk</h3>
                <button onclick="window.print()" class="text-sm text-gray-500 hover:text-orange-600 font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-mono font-bold text-orange-600">#{{ $order->invoice_number }}</td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">Tidak ada data penjualan pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-gray-50 font-bold text-gray-900">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right uppercase tracking-wider">Total Pendapatan</td>
                            <td class="px-6 py-4 text-right text-lg">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection