@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Tombol Kembali - Opsi dengan Warna Tema -->
        <div class="mb-6">
            <a href="{{ route('pelanggan.produk') }}"
                class="inline-flex items-center px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-700 rounded-lg transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-gray-100 rounded-2xl overflow-hidden shadow-sm">
                @if($produk->image)
                <img src="{{ asset('storage/' . $produk->image) }}" alt="{{ $produk->nama }}"
                    class="w-full h-full object-contain">
                @else
                <div class="w-full h-96 flex items-center justify-center text-gray-400">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                @endif
            </div>

            <div>
                <!-- Kategori -->
                @if($produk->kategori)
                <span class="text-orange-600 font-bold uppercase tracking-wide text-sm">
                    Kategori: {{ $produk->kategori->nama }}
                </span>
                @endif

                <!-- Nama Produk -->
                <h1 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $produk->nama }}</h1>

                <!-- Harga -->
                <p class="text-3xl font-bold text-gray-900 mt-4">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                <!-- Varian (jika ada) -->
                @if($produk->varian)
                <div class="mt-2">
                    <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full">
                        Varian: {{ $produk->varian->value }}
                    </span>
                </div>
                @endif

                <!-- Deskripsi -->
                @if($produk->deskripsi)
                <div class="mt-6 border-t border-b border-gray-100 py-4">
                    <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi }}</p>
                </div>
                @endif

                <!-- Stok dan Form -->
                <div class="mt-6">
                    <p class="text-sm font-bold text-gray-700 mb-2">
                        Stok Tersedia:
                        <span class="{{ $produk->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $produk->stok }} Unit
                        </span>
                    </p>

                    <!-- Status Stok -->
                    @if($produk->stok <= 5 && $produk->stok > 0)
                        <div class="mb-4">
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">
                                ⚠️ Stok Menipis
                            </span>
                        </div>
                        @elseif($produk->stok == 0)
                        <div class="mb-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full">
                                ❌ Stok Habis
                            </span>
                        </div>
                        @endif

                        <form action="{{ route('keranjang.store') }}" method="POST" class="flex gap-4">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                            <div class="w-24">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $produk->stok }}"
                                    class="w-full border-gray-300 rounded-xl text-center py-3 font-bold focus:ring-orange-500 focus:border-orange-500">
                            </div>

                            @if($produk->stok > 0)
                            <button type="submit"
                                class="flex-1 bg-gray-900 text-white font-bold rounded-xl hover:bg-orange-600 transition duration-300">
                                + Tambah ke Keranjang
                            </button>
                            @else
                            <button disabled
                                class="flex-1 bg-gray-300 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                                Stok Habis
                            </button>
                            @endif
                        </form>
                </div>
            </div>
        </div>

        <!-- Produk Terkait -->
        @if($produkTerkaits->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($produkTerkaits as $produkTerkait)
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100">
                    <a href="{{ route('pelanggan.produk.show', $produkTerkait->id) }}">
                        <div class="w-full h-40 bg-gray-200 relative overflow-hidden">
                            @if($produkTerkait->image)
                            <img src="{{ asset('storage/' . $produkTerkait->image) }}" alt="{{ $produkTerkait->nama }}"
                                class="object-cover w-full h-full hover:scale-105 transition duration-500">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            @endif
                        </div>
                    </a>

                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 truncate">{{ $produkTerkait->nama }}</h3>
                        <p class="text-orange-600 font-bold mt-1">
                            Rp {{ number_format($produkTerkait->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection