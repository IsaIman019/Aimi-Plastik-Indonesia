@extends('layouts.app')

@section('content')
<style>
    /* Hilangkan scrollbar default untuk tampilan carousel yang bersih */
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }

    .hide-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="bg-gray-50 min-h-screen pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- SEARCH & HEADER --}}
        <div class="py-6">
            <h1 class="text-xl font-bold text-gray-800 mb-2">Kategori</h1>
            <p class="text-xs text-gray-500 mb-4">Apa yang sedang ingin Anda cari?</p>
        </div>

        {{-- LAYOUT KATEGORI (Sesuai Gambar 1) --}}
        @if(isset($kategoris) && $kategoris->count() > 0)
        <div class="flex flex-col lg:flex-row gap-4 mb-10">

            {{-- 1. KIRI: TOMBOL SEMUA KATEGORI --}}
            <a href="{{ route('pelanggan.produk.all') }}" class="w-full lg:w-1/6 bg-blue-50 rounded-xl border border-blue-100 flex flex-col items-center justify-center p-6 text-center group hover:bg-blue-100 transition relative overflow-hidden min-h-[180px]">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-100 rounded-full opacity-50 blur-xl group-hover:bg-blue-200 transition"></div>
                <div class="relative z-10">
                    <div class="grid grid-cols-2 gap-1 mb-3 w-10 mx-auto opacity-70">
                        <span class="w-3 h-3 border-2 border-blue-600 rounded-full"></span>
                        <span class="w-3 h-3 border-2 border-blue-600 rounded-full"></span>
                        <span class="w-3 h-3 border-2 border-blue-600 rounded-full"></span>
                        <span class="w-3 h-3 border-2 border-blue-600 rounded-full"></span>
                    </div>
                    <h3 class="font-bold text-blue-900 text-sm mb-2">Semua Kategori</h3>
                    <svg class="w-5 h-5 text-blue-600 mx-auto transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </div>
            </a>

            {{-- 2. TENGAH: GRID LIST KATEGORI --}}
            <div class="flex-1 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 divide-y sm:divide-y-0 md:divide-x md:divide-y divide-gray-100">
                    @foreach($kategoris->take(8) as $index => $kategori)
                    <a href="{{ route('pelanggan.produk', ['search' => $kategori->nama]) }}" class="group p-4 flex items-center gap-3 hover:bg-gray-50 transition h-full {{ $index >= 4 ? 'border-t border-gray-100' : '' }}">
                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center">
                            @if($kategori->image)
                            <img src="{{ asset('storage/' . $kategori->image) }}" class="w-full h-full object-contain group-hover:scale-110 transition duration-300">
                            @else
                            <svg class="w-8 h-8 text-gray-300 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 group-hover:text-orange-600 transition leading-tight line-clamp-2">
                                {{ $kategori->nama }}
                            </h4>
                            <p class="text-[10px] text-gray-500 mt-0.5">
                                {{ isset($kategori->produks_count) ? $kategori->produks_count . ' produk' : 'Lihat produk' }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- HELPER FUNCTION: PRODUCT CARD --}}
        @php
        function renderProductCard($produk, $showBadge = false) {
        $cartUrl = route('keranjang.store');
        $csrf = csrf_field();

        $html = '
        <div class="min-w-[180px] md:min-w-[220px] max-w-[220px] bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex-shrink-0 relative group snap-start">
            <a href="'.route('pelanggan.produk.show', $produk->id).'">
                <div class="relative w-full pt-[100%] bg-white rounded-t-xl overflow-hidden">';

                    if($showBadge) {
                    $html .= '<span class="absolute top-0 left-0 bg-[#6f7ecc] text-white text-[10px] font-bold px-3 py-1 rounded-br-lg z-10">NEW</span>';
                    }

                    if($produk->image) {
                    $html .= '<img src="'.asset('storage/' . $produk->image).'" class="absolute inset-0 w-full h-full object-contain p-6 group-hover:scale-105 transition duration-500">';
                    } else {
                    $html .= '<div class="absolute inset-0 flex items-center justify-center text-gray-300"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg></div>';
                    }

                    $html .= '<div class="absolute bottom-3 left-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20 translate-y-2 group-hover:translate-y-0">
                        <form action="'.$cartUrl.'" method="POST" class="flex-1">
                            '.$csrf.'
                            <input type="hidden" name="produk_id" value="'.$produk->id.'">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-[#2c3e8c] text-white text-xs font-bold py-2 px-2 rounded-lg hover:bg-blue-800 flex items-center justify-center gap-1 shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                +Keranjang
                            </button>
                        </form>

                    </div>';

                    $html .= '</div>

                <div class="p-4">
                    <h3 class="text-sm text-gray-500 font-medium line-clamp-2 h-10 leading-tight mb-2 group-hover:text-blue-900 transition">'.$produk->nama.'</h3>
                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-[#2c3e8c] font-bold text-base">Rp '.number_format($produk->harga, 0, ',', '.').'</span>
                    </div>
                </div>
            </a>
        </div>';
        return $html;
        }
        @endphp


        {{-- SECTION 1: PRODUK TERBARU --}}
        <div class="mb-12">
            <div class="flex justify-between items-center mb-4 px-1">
                <h2 class="text-xl font-bold text-gray-800">Produk Terbaru</h2>
            </div>

            <div class="relative group/slider">
                {{-- Arrow Left --}}
                <button class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 z-20 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-blue-900 hover:bg-blue-50 opacity-0 group-hover/slider:opacity-100 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                {{-- Scroll Container --}}
                <div class="flex overflow-x-auto space-x-6 pb-8 px-2 hide-scroll snap-x scroll-smooth">
                    @foreach($produkTerbaru as $produk)
                    {!! renderProductCard($produk, true) !!}
                    @endforeach
                </div>

                {{-- Arrow Right --}}
                <button class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 z-20 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-blue-900 hover:bg-blue-50 opacity-0 group-hover/slider:opacity-100 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- Dots --}}
                <div class="absolute bottom-0 left-0 right-0 flex justify-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#6f7ecc]"></div>
                    <div class="w-2 h-2 rounded-full bg-gray-300 hover:bg-[#6f7ecc] transition cursor-pointer"></div>
                    <div class="w-2 h-2 rounded-full bg-gray-300 hover:bg-[#6f7ecc] transition cursor-pointer"></div>
                </div>
            </div>
        </div>


        {{-- SECTION 2: PALING DIMINATI (BEST SELLER) --}}
        {{-- Layout disamakan dengan Produk Terbaru --}}
        <div class="mb-12">
            <div class="flex justify-between items-center mb-4 px-1">
                <h2 class="text-xl font-bold text-gray-800">Paling Diminati</h2>
            </div>

            <div class="relative group/slider-best">
                {{-- Arrow Left --}}
                <button class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 z-20 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-blue-900 hover:bg-blue-50 opacity-0 group-hover/slider-best:opacity-100 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                {{-- Scroll Container --}}
                <div class="flex overflow-x-auto space-x-6 pb-8 px-2 hide-scroll snap-x scroll-smooth">
                    @foreach($bestSeller as $produk)
                    {{-- Menggunakan renderProductCard yang sama, false agar tidak muncul badge NEW (opsional) --}}
                    {!! renderProductCard($produk, false) !!}
                    @endforeach
                </div>

                {{-- Arrow Right --}}
                <button class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 z-20 w-10 h-10 bg-white rounded-full shadow-lg border border-gray-100 flex items-center justify-center text-blue-900 hover:bg-blue-50 opacity-0 group-hover/slider-best:opacity-100 transition-opacity">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                {{-- Dots --}}
                <div class="absolute bottom-0 left-0 right-0 flex justify-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#6f7ecc]"></div>
                    <div class="w-2 h-2 rounded-full bg-gray-300 hover:bg-[#6f7ecc] transition cursor-pointer"></div>
                    <div class="w-2 h-2 rounded-full bg-gray-300 hover:bg-[#6f7ecc] transition cursor-pointer"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
