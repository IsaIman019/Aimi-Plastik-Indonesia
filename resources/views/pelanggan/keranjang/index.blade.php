@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🛒 Keranjang Belanja</h1>
                <p class="text-sm text-gray-600">
                    Total <span id="total-items-header">{{ $keranjangs->count() }}</span> produk
                </p>
            </div>
            <a href="{{ route('pelanggan.produk') }}"
                class="text-orange-600 font-semibold hover:underline">
                ← Lanjut Belanja
            </a>
        </div>

        @if($keranjangs->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ================= LEFT : CART LIST ================= --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- LIST ITEM --}}
                <div class="bg-white rounded-2xl rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                    {{-- DESKTOP --}}
                    <div class="hidden md:block">
                        <div class="grid grid-cols-12 bg-gray-50 px-6 py-4 text-sm font-semibold text-gray-600">
                            <div class="col-span-6 flex items-center gap-3">
                                <input type="checkbox" id="select-all" class="w-4 h-4">
                                <span>Produk</span>
                            </div>
                            <div class="col-span-2 text-center">Harga</div>
                            <div class="col-span-2 text-center">Jumlah</div>
                            <div class="col-span-1 text-right">Subtotal</div>
                            <div class="col-span-1 text-center">Aksi</div>
                        </div>

                        @php $grandTotal = 0; @endphp
                        @foreach($keranjangs as $keranjang)
                        @php
                            $subtotal = $keranjang->produk->harga * $keranjang->qty;
                            $grandTotal += $subtotal;
                        @endphp
                        <div id="cart-item-{{ $keranjang->id }}"
                            data-product-price="{{ $keranjang->produk->harga }}"
                            class="grid grid-cols-12 items-center px-6 py-5  shadow-sm border border-gray-200">

                            <div class="col-span-6 flex gap-4">
                                <input type="checkbox"
                                    class="cart-checkbox"
                                    data-id="{{ $keranjang->id }}"
                                    data-produk-id="{{ $keranjang->produk->id }}"
                                    data-price="{{ $keranjang->produk->harga }}"
                                    checked>
                                <img src="{{ asset('storage/'.$keranjang->produk->image) }}"
                                    class="w-20 h-20 rounded-xl object-cover bg-gray-100">
                                <div>
                                    <h3 class="font-bold text-gray-900">
                                        {{ $keranjang->produk->nama }}
                                    </h3>
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                        {{ $keranjang->produk->kategori->nama ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-span-2 text-center font-semibold">
                                Rp {{ number_format($keranjang->produk->harga,0,',','.') }}
                            </div>

                            <div class="col-span-2">
                                <div class="flex justify-center gap-2">
                                    <button onclick="updateQuantity({{ $keranjang->id }},-1)"
                                        class="w-8 h-8 border rounded">-</button>
                                    <input id="quantity-{{ $keranjang->id }}"
                                        type="number"
                                        value="{{ $keranjang->qty }}"
                                        min="1"
                                        max="{{ $keranjang->produk->stok }}"
                                        onchange="updateQuantity({{ $keranjang->id }},0,this.value)"
                                        class="w-14 text-center border rounded font-bold">
                                    <button onclick="updateQuantity({{ $keranjang->id }},1)"
                                        class="w-8 h-8 border rounded">+</button>
                                </div>
                            </div>

                            <div class="col-span-1 text-right font-bold">
                                Rp <span id="subtotal-{{ $keranjang->id }}">
                                    {{ number_format($subtotal,0,',','.') }}
                                </span>
                            </div>

                            <div class="col-span-1 text-center">
                                <button onclick="removeItem({{ $keranjang->id }})"
                                    class="text-red-500 hover:text-red-700">
                                    🗑
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- MOBILE --}}
                    <div class="md:hidden divide-y">
                        @foreach($keranjangs as $keranjang)
                        <div id="cart-item-mobile-{{ $keranjang->id }}"
                            data-product-price="{{ $keranjang->produk->harga }}"
                            class="p-4">

                            <div class="flex gap-4">
                                <img src="{{ asset('storage/'.$keranjang->produk->image) }}"
                                    class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="font-bold text-sm">
                                            {{ $keranjang->produk->nama }}
                                        </h3>
                                        <button onclick="removeItem({{ $keranjang->id }})"
                                            class="text-red-500">✕</button>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        Rp {{ number_format($keranjang->produk->harga,0,',','.') }}
                                    </p>

                                    <div class="flex justify-between mt-3">
                                        <div class="flex gap-2">
                                            <button onclick="updateQuantity({{ $keranjang->id }},-1)"
                                                class="w-7 h-7 border rounded">-</button>
                                            <input id="quantity-mobile-{{ $keranjang->id }}"
                                                value="{{ $keranjang->qty }}"
                                                readonly
                                                class="w-10 text-center font-bold">
                                            <button onclick="updateQuantity({{ $keranjang->id }},1)"
                                                class="w-7 h-7 border rounded">+</button>
                                        </div>
                                        <div class="font-bold">
                                            Rp <span id="subtotal-mobile-{{ $keranjang->id }}">
                                                {{ number_format($keranjang->produk->harga*$keranjang->qty,0,',','.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- PENGIRIMAN ONLY --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-bold mb-3">Metode Pengiriman</h3>
                    <div class="flex gap-3 bg-gray-50 p-4 rounded-xl shadow-sm border border-gray-200">
                        <input type="radio" checked>
                        <div>
                            <p class="font-semibold">Dikirim Ekspedisi</p>
                            <p class="text-sm text-gray-600">
                                Dari Driyorejo, Gresik, Jawa Timur<br>
                                Estimasi 2 – 5 hari kerja
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= RIGHT : SUMMARY ================= --}}
            <div class="space-y-4">

                {{-- VOUCHER --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <button onclick="openPromo()"
                        class="w-full flex justify-between items-center bg-red-50 text-red-600 px-4 py-3 rounded-xl shadow-sm border border-gray-200 font-semibold">
                        🎟 Pilih promo menarik
                        <span>›</span>
                    </button>
                </div>

                {{-- RINGKASAN --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6 space-y-3">
                    <h3 class="font-bold text-lg">Ringkasan Belanja</h3>

                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span>Rp <span id="grand-total">
                            {{ number_format($grandTotal,0,',','.') }}
                        </span></span>
                    </div>

                    <div class="flex justify-between text-sm ">
                        <span>Ongkos Kirim</span>
                        <span>Gagal memuat</span>
                    </div>

                    <div class="flex justify-between text-sm text-orange-600">
                        <span id="promo-used">0 promo terpakai</span>
                        <span>-Rp <span id="promo-discount">0</span></span>
                    </div>

                    <hr>

                    <div class="flex justify-between text-lg font-bold">
                        <span>TOTAL</span>
                        <span>Rp <span id="final-total">
                            {{ number_format($grandTotal,0,',','.') }}
                        </span></span>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                        class="block w-full text-center py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white rounded-xl font-bold cursor-not-allowed">
                        Beli Sekarang
                    </a>
                </div>
            </div>
        </div>

        @else
            {{-- EMPTY --}}
            <div class="text-center py-20 bg-white rounded-3xl border">
                <h3 class="text-2xl font-bold">Keranjang Kosong</h3>
                <a href="{{ route('pelanggan.produk') }}"
                    class="mt-4 inline-block px-6 py-3 bg-orange-500 text-white rounded-xl">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
<div id="promoModal"
    class="fixed inset-0 hidden bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl p-6">
        <h3 class="font-bold text-lg mb-4">🎟 Promo Tersedia</h3>

        <div id="promoList" class="space-y-3">
        </div>

        <button onclick="closePromo()"
            class="mt-4 w-full py-2 bg-gray-200 rounded-lg">
            Tutup
        </button>
    </div>
</div>

{{-- JS TETAP SAMA --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/pelanggan/keranjang/index.js') }}"></script>
@endsection
