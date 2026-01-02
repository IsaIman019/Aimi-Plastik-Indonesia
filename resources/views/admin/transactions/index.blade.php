@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')

    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Transaksi Keuangan</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Uang Masuk (Sukses)</p>
                    <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Transaksi Pending</p>
                    <h3 class="text-2xl font-bold text-yellow-600">{{ $pendingCount }} Transaksi</h3>
                </div>
                <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Daftar Transaksi Masuk</h3>
                <button class="text-sm text-gray-500 hover:text-orange-600">Export Excel (Coming Soon)</button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-900 font-bold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">ID Transaksi</th>
                            <th class="px-6 py-4">Ref Order</th>
                            <th class="px-6 py-4">User / Pembayar</th>
                            <th class="px-6 py-4">Metode Bayar</th>
                            <th class="px-6 py-4">Jumlah</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono text-xs font-bold text-gray-500">
                                {{ $trx->transaction_code }}
                            </td>
                            <td class="px-6 py-4">
                                @if($trx->order)
                                    <a href="{{ route('admin.orders.edit', $trx->order_id) }}" class="text-orange-600 hover:underline font-bold">
                                        #{{ $trx->order->invoice_number }}
                                    </a>
                                @else
                                    <span class="text-red-400 italic">Order Dihapus</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $trx->user->name ?? 'Guest' }}</div>
                                <div class="text-xs text-gray-400">{{ $trx->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="uppercase font-bold text-xs bg-gray-100 px-2 py-1 rounded">
                                    {{ str_replace('_', ' ', $trx->payment_method ?? 'Manual') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($trx->status == 'success' || $trx->status == 'settlement')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">Lunas</span>
                                @elseif($trx->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">Pending</span>
                                @elseif($trx->status == 'expired')
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-xs font-bold">Expired</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">Gagal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $trx->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-400">Belum ada data transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-gray-50">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection