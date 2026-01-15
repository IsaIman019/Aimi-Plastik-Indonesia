@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-900">Katalog Produk</h1>

            {{-- SEARCH BAR --}}
            <form action="{{ route('pelanggan.produk') }}" method="GET" class="relative w-full md:w-auto">
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                    class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:ring-orange-500 focus:border-orange-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>

        @if($produks->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($produks as $produk)
            <div
                class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden group border border-gray-100">
                <a href="{{ route('pelanggan.produk.show', $produk->id) }}">
                    <div class="w-full h-48 bg-gray-200 relative overflow-hidden">
                        @if($produk->image)
                        <img src="{{ asset('storage/' . $produk->image) }}" alt="{{ $produk->nama }}"
                            class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        @endif

                        @if($produk->stok <= 5 && $produk->stok > 0)
                            <span
                                class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                Stok Menipis
                            </span>
                            @elseif($produk->stok == 0)
                            <span
                                class="absolute top-2 right-2 bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded">
                                Habis
                            </span>
                            @endif
                    </div>
                </a>

                <div class="p-4">
                    <h3 class="font-bold text-gray-900 truncate">{{ $produk->nama }}</h3>

                    <!-- Kategori dan Varian -->
                    @if($produk->kategori || $produk->varian)
                    <div class="flex items-center gap-2 mt-1">
                        @if($produk->kategori)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                            {{ $produk->kategori->nama }}
                        </span>
                        @endif
                        @if($produk->varian)
                        <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                            {{ $produk->varian->value }}
                        </span>
                        @endif
                    </div>
                    @endif

                    <p class="text-orange-600 font-bold mt-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <!-- Info Stok -->
                    <p class="text-sm text-gray-500 mt-1">
                        Stok: {{ $produk->stok }} pcs
                    </p>

                    <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <input type="hidden" name="quantity" value="1">

                        @if($produk->stok > 0)
                        <button type="submit"
                            class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-bold hover:bg-orange-600 transition duration-300">
                            + Tambah ke Keranjang
                        </button>
                        @else
                        <button disabled
                            class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg text-sm font-bold cursor-not-allowed">
                            Stok Habis
                        </button>
                        @endif
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $produks->withQueryString()->links() }}
        </div>

        @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Produk tidak ditemukan</h3>
            <p class="text-gray-500 mb-4">
                @if(request()->has('search'))
                Tidak ada produk yang cocok dengan pencarian "{{ request('search') }}"
                @else
                Belum ada produk yang tersedia
                @endif
            </p>
            @if(request()->has('search'))
            <a href="{{ route('pelanggan.produk.index') }}"
                class="inline-block px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                Lihat Semua Produk
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection