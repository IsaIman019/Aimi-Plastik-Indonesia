@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Pesanan</h1>
        <span class="px-4 py-2 bg-orange-100 text-orange-600 rounded-lg font-bold text-sm">
            Admin Panel
        </span>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-orange-500">
                    <tr>
                        <th scope="col" class="px-6 py-4">Invoice</th>
                        <th scope="col" class="px-6 py-4">Pelanggan</th>
                        <th scope="col" class="px-6 py-4">Total</th>
                        <th scope="col" class="px-6 py-4">Status Pembayaran</th>
                        <th scope="col" class="px-6 py-4">Status Pesanan</th>
                        <th scope="col" class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b hover:bg-orange-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                #{{ $order->invoice_number }}
                                <br>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $order->user->name }}
                                <br>
                                <span class="text-xs">{{ $order->user->email }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-orange-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex flex-col gap-2">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <select name="status" class="text-xs border-gray-300 rounded focus:border-orange-500 focus:ring-orange-500">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                    </select>

                                    <select name="payment_status" class="text-xs border-gray-300 rounded focus:border-orange-500 focus:ring-orange-500">
                                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                                    </select>

                                    <button type="submit" class="px-3 py-1 bg-orange-500 text-white rounded text-xs hover:bg-orange-600 transition">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection