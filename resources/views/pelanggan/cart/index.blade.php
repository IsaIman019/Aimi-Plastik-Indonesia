@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 font-bold">{{ session('error') }}</div>
        @endif

        @if($carts->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left text-gray-600">
                    <thead class="bg-gray-100 uppercase text-xs font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4 text-center">Jumlah</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php $grandTotal = 0; @endphp
                        @foreach($carts as $cart)
                        @php 
                            $subtotal = $cart->product->price * $cart->quantity; 
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $cart->product->name }}</p>
                                        <p class="text-xs text-gray-500">@ Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="flex justify-center items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" class="w-16 border-gray-300 rounded-lg text-center text-sm py-1">
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-xs font-bold underline">Update</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bg-gray-50 px-6 py-6 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500">Total Pembayaran</p>
                        <p class="text-2xl font-black text-orange-600">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="bg-gray-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-600 transition shadow-lg">
                        Lanjut ke Pembayaran &rarr;
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                <p class="text-gray-500 mb-4">Keranjang Anda masih kosong.</p>
                <a href="{{ route('pelanggan.products') }}" class="text-orange-600 font-bold hover:underline">Mulai Belanja</a>
            </div>
        @endif
    </div>
</div>
@endsection