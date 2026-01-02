@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan <span class="text-orange-600">#{{ $order->invoice_number }}</span></h1>
            <a href="{{ route('pelanggan.orders.index') }}" class="text-gray-500 font-bold hover:text-orange-600">&larr; Kembali</a>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <h2 class="font-bold text-gray-800 mb-4">Status Pengiriman</h2>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                @php
                    $width = '0%';
                    if($order->status == 'pending') $width = '25%';
                    elseif($order->status == 'processed') $width = '50%';
                    elseif($order->status == 'shipped') $width = '75%';
                    elseif($order->status == 'completed') $width = '100%';
                @endphp
                <div class="bg-orange-600 h-2.5 rounded-full" style="width: {{ $width }}"></div>
            </div>
            <p class="text-right text-sm font-bold text-orange-600 uppercase">{{ $order->status }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-3">Info Penerima</h3>
                <p class="text-gray-600 text-sm"><span class="font-bold">Nama:</span> {{ Auth::user()->name }}</p>
                <p class="text-gray-600 text-sm mt-1"><span class="font-bold">No HP:</span> {{ $order->phone }}</p>
                <p class="text-gray-600 text-sm mt-1"><span class="font-bold">Alamat:</span> {{ $order->address }}</p>
                <p class="text-gray-600 text-sm mt-1"><span class="font-bold">Ekspedisi:</span> {{ $order->shipping_method }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-3">Info Pembayaran</h3>
                <p class="text-gray-600 text-sm"><span class="font-bold">Metode:</span> {{ $order->payment_method }}</p>
                <p class="text-gray-600 text-sm mt-1"><span class="font-bold">Total:</span> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left text-gray-600 text-sm">
                <thead class="bg-gray-100 uppercase font-bold text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-right">Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->product->name }}</td>
                        <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection