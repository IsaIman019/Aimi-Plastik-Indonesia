@extends('layouts.app')

@section('content')
<style>
    /* Hilangkan panah input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .hide-scroll::-webkit-scrollbar {
        display: none;
    }

    .hide-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="bg-white min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- BREADCRUMB (Navigasi Atas) --}}
        <nav class="flex py-4 text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('pelanggan.produk') }}" class="hover:text-[#2c3e8c]">Home</a>
                </li>
                <li>
                    <span class="mx-1 text-gray-400">/</span>
                </li>
                <li>
                    <a href="{{ route('pelanggan.kategori.all') }}" class="hover:text-[#2c3e8c]">Produk</a>
                </li>
                @if($produk->kategori)
                <li>
                    <span class="mx-1 text-gray-400">/</span>
                </li>
                <li>
                    <a href="{{ route('pelanggan.kategori.all', ['kategori[]' => $produk->kategori_id]) }}"
                        class="hover:text-[#2c3e8c]">{{ $produk->kategori->nama }}</a>
                </li>
                @endif
                <li>
                    <span class="mx-1 text-gray-400">/</span>
                </li>
                <li aria-current="page">
                    <span class="text-gray-900 font-medium truncate max-w-[200px]">{{ $produk->nama }}</span>
                </li>
            </ol>
        </nav>


        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- KOLOM KIRI: GAMBAR UTAMA --}}
            <div class="lg:col-span-4">
                <div class="border border-gray-200 rounded-xl overflow-hidden mb-4 relative group">
                    {{-- Badge Diskon (Jika ada) --}}
                    {{-- <span class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">25%</span> --}}

                    @if($produk->image)
                    <img id="mainImage" src="{{ asset('storage/' . $produk->image) }}" alt="{{ $produk->nama }}"
                        class="w-full h-auto object-contain p-4 transition-transform duration-500 group-hover:scale-110 cursor-zoom-in">
                    @else
                    <div class="w-full h-96 flex items-center justify-center bg-gray-50 text-gray-400">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    @endif
                </div>

                {{-- Thumbnail Gallery (Opsional/Statis) --}}
                <div class="flex gap-2 overflow-x-auto hide-scroll">
                    @if($produk->image)
                    <div class="w-16 h-16 border border-[#2c3e8c] rounded-lg overflow-hidden cursor-pointer p-1">
                        <img src="{{ asset('storage/' . $produk->image) }}" class="w-full h-full object-contain">
                    </div>
                    @endif
                    {{-- Placeholder Thumbnails (Simulasi) --}}
                    {{-- <div class="w-16 h-16 border border-gray-200 rounded-lg overflow-hidden cursor-pointer p-1 hover:border-gray-400"><img src="..." class="w-full h-full object-contain"></div> --}}
                </div>
            </div>

            {{-- KOLOM TENGAH: DETAIL PRODUK --}}
            <div class="lg:col-span-5">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $produk->nama }}</h1>

                {{-- Rating & Review Count --}}
                <div class="flex items-center gap-2 mb-4 text-sm">
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <span class="text-gray-600 font-bold ml-1">5.0</span>
                    </div>
                    <span class="text-gray-400">•</span>
                    <span class="text-gray-500">1 orang telah mengulas</span>
                </div>

                {{-- Harga --}}
                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-[#2c3e8c]">Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </h2>
                </div>

                {{-- Form Add to Cart --}}
                <form action="{{ route('keranjang.store') }}" method="POST" class="border-b border-gray-100 pb-8 mb-6">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                    <div class="flex items-center gap-4 mb-6">
                        {{-- Input Quantity --}}
                        <div class="flex items-center border border-gray-300 rounded-lg w-32">
                            <button type="button" onclick="decrementValue()"
                                class="w-10 h-10 text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-l-lg flex items-center justify-center font-bold text-lg">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1"
                                max="{{ $produk->stok }}"
                                class="flex-1 w-full text-center border-none focus:ring-0 text-gray-800 font-bold h-10 p-0">
                            <button type="button" onclick="incrementValue()"
                                class="w-10 h-10 text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-r-lg flex items-center justify-center font-bold text-lg">+</button>
                        </div>
                        <span class="text-sm text-gray-500">Stok: <b>{{ $produk->stok }}</b></span>
                    </div>

                    <div class="flex gap-3">
                        @if($produk->stok > 0)
                        <button type="submit"
                            class="flex-1 bg-[#2c3e8c] text-white font-bold py-3 rounded-lg hover:bg-blue-900 transition flex items-center justify-center gap-2 shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Keranjang
                        </button>
                        @else
                        <button disabled
                            class="flex-1 bg-gray-300 text-gray-500 font-bold py-3 rounded-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                        @endif
                    </div>
                </form>

                {{-- Deskripsi Text --}}
                <div class="prose prose-sm text-gray-600">
                    <h3 class="font-bold text-gray-800 mb-2">Deskripsi:</h3>
                    <p class="mb-4">
                        {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>

                    <a href="#" class="text-[#2c3e8c] font-bold text-xs hover:underline">Read Less</a>
                </div>
            </div>


        </div>


        {{-- BAGIAN BAWAH: PRODUK REKOMENDASI --}}
        @if(isset($produkTerkaits) && $produkTerkaits->count() > 0)
        <div class="mt-16 border-t border-gray-100 pt-10">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Produk Rekomendasi Lainnya</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($produkTerkaits as $related)

                {{-- CARD PRODUK (Style Index) --}}
                <div
                    class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 relative group flex flex-col h-full">

                    {{-- Link Wrapper --}}
                    <a href="{{ route('pelanggan.produk.show', $related->id) }}" class="flex-1 flex flex-col">

                        {{-- Image Container --}}
                        <div class="relative w-full pt-[100%] bg-white rounded-t-xl overflow-hidden">

                            {{-- Product Image --}}
                            @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->nama }}"
                                class="absolute inset-0 w-full h-full object-contain p-4 group-hover:scale-105 transition duration-500">
                            @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            @endif

                            {{-- HOVER ACTIONS (Keranjang & Mata) --}}
                            <div
                                class="absolute bottom-3 left-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20 translate-y-2 group-hover:translate-y-0">

                                {{-- Tombol Keranjang --}}
                                <div class="flex-1">
                                    {{-- Gunakan onclick preventDefault agar tidak pindah halaman saat klik tombol ini --}}
                                    <button type="button"
                                        onclick="event.preventDefault(); document.getElementById('add-to-cart-related-{{ $related->id }}').submit();"
                                        class="w-full bg-[#2c3e8c] text-white text-xs font-bold py-2 px-2 rounded-lg hover:bg-blue-800 flex items-center justify-center gap-1 shadow-md transition transform active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        +Keranjang
                                    </button>
                                </div>


                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="p-3 flex flex-col flex-1">
                            <h3
                                class="text-sm text-gray-500 font-medium line-clamp-2 leading-tight mb-2 group-hover:text-[#2c3e8c] transition h-10">
                                {{ $related->nama }}
                            </h3>

                            {{-- Harga --}}
                            <div class="mt-auto">
                                <span class="text-[#2c3e8c] font-bold text-sm">
                                    Rp {{ number_format($related->harga, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Rating Static --}}
                            <div class="flex items-center gap-1 mt-1 text-[10px] text-gray-400">
                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                <span>5.0 (2)</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Form Hidden untuk Keranjang (ID Unik untuk Related) --}}
                <form id="add-to-cart-related-{{ $related->id }}" action="{{ route('keranjang.store') }}" method="POST"
                    class="hidden">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $related->id }}">
                    <input type="hidden" name="quantity" value="1">
                </form>

                @endforeach
            </div>
        </div>
        @endif

        {{-- Ulasan Pembeli (Placeholder) --}}
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Ulasan Pembeli</h2>
            <div class="bg-blue-50/50 p-6 rounded-xl flex items-center gap-4">
                <div class="text-center">
                    <p class="text-3xl font-bold text-[#2c3e8c]">5.0<span
                            class="text-sm text-gray-400 font-normal">/5.0</span></p>
                    <p class="text-xs text-gray-500">1 orang telah mengulas</p>
                </div>
                {{-- List Ulasan (Bisa di-looping jika ada datanya) --}}
            </div>
        </div>

    </div>
</div>

{{-- SCRIPT: Quantity Counter --}}
<script>
    function incrementValue() {
        var value = parseInt(document.getElementById('quantity').value, 10);
        value = isNaN(value) ? 0 : value;
        var max = parseInt(document.getElementById('quantity').getAttribute('max'), 10);
        if (value < max) {
            value++;
            document.getElementById('quantity').value = value;
        }
    }

    function decrementValue() {
        var value = parseInt(document.getElementById('quantity').value, 10);
        value = isNaN(value) ? 0 : value;
        if (value > 1) {
            value--;
            document.getElementById('quantity').value = value;
        }
    }
</script>
@endsection