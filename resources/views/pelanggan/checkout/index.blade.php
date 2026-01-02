@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout Pesanan</h1>

        <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @csrf
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="font-bold text-lg mb-4 text-gray-800">Informasi Pengiriman</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Penerima</label>
                        <input type="text" value="{{ Auth::user()->name }}" class="w-full border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" required class="w-full border-gray-300 rounded-lg focus:ring-orange-500" placeholder="08123xxxx">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3" required class="w-full border-gray-300 rounded-lg focus:ring-orange-500" placeholder="Jalan, No Rumah, Kecamatan, Kota..."></textarea>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="font-bold text-lg mb-4 text-gray-800">Metode Pengiriman</h2>
                    <select name="shipping_method" class="w-full border-gray-300 rounded-lg focus:ring-orange-500">
                        <option value="JNE">JNE</option>
                        <option value="J&T">J&T</option>
                        <option value="Sicepat">Sicepat</option>
                        <option value="Ambil Sendiri">Ambil Sendiri di Gudang (Gresik)</option>
                    </select>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="font-bold text-lg mb-4 text-gray-800">Metode Pembayaran</h2>
                    <select name="payment_method" class="w-full border-gray-300 rounded-lg focus:ring-orange-500">
                        <option value="Transfer BCA">Transfer Bank BCA</option>
                        <option value="Transfer BRI">Transfer Bank BRI</option>
                        <option value="COD">Bayar di Tempat (COD)</option>
                    </select>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <h2 class="font-bold text-lg mb-4 text-gray-800">Ringkasan Pesanan</h2>
                    <div class="space-y-3 mb-6">
                        @php $total = 0; @endphp
                        @foreach($carts as $cart)
                            @php $total += $cart->product->price * $cart->quantity; @endphp
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $cart->product->name }} (x{{ $cart->quantity }})</span>
                                <span class="font-bold">Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-lg">Total</span>
                            <span class="font-black text-xl text-orange-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-orange-600 text-white font-bold py-3 rounded-xl hover:bg-orange-700 transition shadow-lg">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection