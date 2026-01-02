@extends('layouts.app')

@section('content')

{{-- 1. LOAD LIBRARY SLIDER (SWIPER JS) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Custom warna tombol panah slider agar oranye */
    .swiper-button-next, .swiper-button-prev { color: #ea580c !important; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
    .swiper-pagination-bullet-active { background-color: #ea580c !important; }
    .swiper-pagination-bullet { background-color: white; opacity: 0.8; }
</style>

{{-- ========================================================= --}}
{{-- BANNER SLIDER SECTION (PENGGANTI HERO SECTION LAMA)       --}}
{{-- ========================================================= --}}
<div class="relative bg-white overflow-hidden">
    <div class="swiper mySwiper w-full h-[500px] md:h-[600px]">
        <div class="swiper-wrapper">
            
            {{-- SLIDE 1: INTRO UTAMA (Konten Lama) --}}
            <div class="swiper-slide relative">
                {{-- Gambar Background --}}
                <div class="absolute inset-0">
                    <img src="{{ asset('images/Plastik4.jpg') }}" alt="Aimi Packaging Banner Utama" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/40 to-transparent"></div>
                </div>
                {{-- Teks Overlay --}}
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                    <div class="max-w-2xl text-white pt-10">
                        <span class="inline-block py-1 px-3 rounded-full bg-orange-600 text-white text-xs font-bold tracking-wide mb-4 uppercase shadow-md">
                            Official Marketplace
                        </span>
                        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4 leading-tight drop-shadow-lg">
                            Solusi Kemasan <br> <span class="text-orange-500">Terpercaya & Kuat</span>
                        </h1>
                        <p class="text-lg md:text-xl text-gray-100 mb-8 leading-relaxed drop-shadow-md">
                            Aimi Packaging hadir sebagai mitra bisnis Anda menyediakan Lakban, Bubble Mailer, dan Plastik Wrap kualitas terbaik dengan harga pabrik.
                        </p>
                        <div class="flex gap-4">
                            <a href="#katalog" class="px-8 py-3 bg-orange-600 hover:bg-orange-700 rounded-full font-bold transition shadow-lg transform hover:-translate-y-1">
                                Belanja Sekarang
                            </a>
                            <a href="{{ route('about') }}" class="px-8 py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 rounded-full font-bold transition transform hover:-translate-y-1">
                                Tentang Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SLIDE 2: BANNER PROMO (IKLAN) --}}
            <div class="swiper-slide relative bg-gray-800">
                <div class="absolute inset-0">
                    {{-- Ganti src dengan gambar banner promo Anda --}}
                    {{-- Contoh placeholder pakai CSS gradient --}}
                    <div class="w-full h-full bg-gradient-to-br from-blue-900 to-gray-900 flex items-center justify-center">
                        {{-- Jika ada gambar promo: <img src="..." class="w-full h-full object-cover"> --}}
                    </div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center text-center">
                    <div class="max-w-3xl text-white">
                        <span class="text-orange-400 font-bold tracking-widest uppercase mb-2 block">Promo Bulan Ini</span>
                        <h2 class="text-4xl md:text-6xl font-extrabold mb-6">Diskon Spesial Grosir <br> Hingga 20%</h2>
                        <p class="text-xl mb-8 text-gray-300">Dapatkan harga khusus untuk pembelian Lakban Bening dalam jumlah besar. Stok terbatas!</p>
                        <a href="#katalog" class="inline-block px-8 py-4 bg-white text-gray-900 rounded-full font-bold hover:bg-gray-100 transition shadow-xl">
                            Lihat Produk Promo
                        </a>
                    </div>
                </div>
            </div>

            {{-- SLIDE 3: LAYANAN PENGIRIMAN --}}
            <div class="swiper-slide relative">
                <div class="absolute inset-0">
                    <img src="{{ asset('images/perusahaan.jpg') }}" alt="Gudang Aimi" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/60"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                    <div class="max-w-2xl text-white ml-auto text-right">
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">Pengiriman Cepat & Aman</h2>
                        <p class="text-lg text-gray-200 mb-6">
                            Kami memastikan setiap produk dikemas dengan standar tinggi dan dikirim tepat waktu ke seluruh wilayah Indonesia.
                        </p>
                        <a href="https://wa.me/6282132257239" target="_blank" class="inline-flex items-center gap-2 text-orange-400 hover:text-orange-300 font-bold text-lg">
                            Hubungi Admin Logistik <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        
        {{-- Navigasi Slider --}}
        <div class="swiper-button-next !hidden md:!flex"></div>
        <div class="swiper-button-prev !hidden md:!flex"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<section class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100">
            <div class="p-4 group">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-50 text-orange-500 mb-4 group-hover:bg-orange-500 group-hover:text-white transition duration-300">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Kualitas Terjamin</h3>
                <p class="text-sm text-gray-500 px-4">Produk kami melalui quality control ketat untuk memastikan kekuatan dan daya tahan maksimal.</p>
            </div>
            <div class="p-4 group">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-50 text-orange-500 mb-4 group-hover:bg-orange-500 group-hover:text-white transition duration-300">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Harga Pabrik</h3>
                <p class="text-sm text-gray-500 px-4">Dapatkan harga tangan pertama yang sangat kompetitif untuk pembelian grosir maupun eceran.</p>
            </div>
            <div class="p-4 group">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-50 text-orange-500 mb-4 group-hover:bg-orange-500 group-hover:text-white transition duration-300">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Pengiriman Cepat</h3>
                <p class="text-sm text-gray-500 px-4">Proses pesanan yang cepat dan pengiriman aman ke seluruh wilayah Indonesia.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2 relative">
                <div class="aspect-w-4 aspect-h-3 rounded-2xl overflow-hidden shadow-xl bg-gray-100">
                    <img src="{{ asset('images/perusahaan.jpg') }}" alt="Gudang Stok Aimi Plastik" class="object-cover w-full h-full transform hover:scale-105 transition duration-500">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-50 max-w-xs hidden md:block">
                    <p class="text-orange-600 font-bold text-lg">"Protecting Values"</p>
                    <p class="text-gray-500 text-sm mt-1">Filosofi kami dalam menjaga kualitas produk Anda.</p>
                </div>
            </div>

            <div class="lg:w-1/2">
                <span class="text-orange-600 font-bold uppercase tracking-wider text-sm">Sekilas Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2 mb-6">Mitra Solusi Kemasan Terpercaya Sejak 2020</h2>
                
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    PT. Aimi Plastik Indonesia berdedikasi untuk menyediakan perlengkapan packing berkualitas tinggi bagi UMKM hingga industri besar di seluruh Indonesia.
                </p>
                
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Visi kami adalah menjadi pemimpin pasar yang mengutamakan inovasi dan kepuasan pelanggan melalui produk yang presisi dan pelayanan prima.
                </p>

                <a href="{{ route('about') }}" class="inline-flex items-center text-orange-600 font-bold hover:text-orange-700 transition group">
                    Baca Profil Lengkap 
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section id="katalog" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <span class="text-orange-500 font-bold tracking-wide uppercase text-sm">Katalog Pilihan</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">Produk Terlaris Kami</h2>
                <p class="mt-3 text-gray-500 max-w-xl">Temukan berbagai kebutuhan packing mulai dari lakban, bubble wrap, hingga kardus dengan kualitas terbaik.</p>
            </div>
            <a href="{{ Auth::check() ? route('pelanggan.products') : route('login') }}" class="inline-flex items-center gap-2 text-white bg-orange-500 hover:bg-orange-600 px-6 py-3 rounded-full font-medium transition shadow-md shadow-orange-500/20">
                Lihat Semua Produk <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredProducts ?? [] as $product)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full relative">
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">Best Seller</span>
                    </div>

                    {{-- IMAGE CONTAINER --}}
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100 group-hover:opacity-90 h-64 relative p-4 flex items-center justify-center">
                        @if($product->image)
                             <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-h-full w-auto object-contain transition duration-300 group-hover:scale-105">
                        @else
                             <div class="h-full w-full flex items-center justify-center text-gray-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                             </div>
                        @endif

                        {{-- OVERLAY BUTTONS --}}
                        <div class="absolute inset-0 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition duration-300 bg-black/10 backdrop-blur-[2px]">
                            
                            {{-- Tombol Preview --}}
                            <button type="button" 
                                    onclick="openPreviewModal(this)" 
                                    data-product="{{ json_encode($product) }}"
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 hover:text-orange-600 hover:shadow-lg transition transform hover:-translate-y-1"
                                    title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>

                            {{-- Tombol Quick Cart --}}
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-10 h-10 bg-orange-600 rounded-full flex items-center justify-center text-white hover:bg-orange-700 hover:shadow-lg transition transform hover:-translate-y-1" title="Tambah ke Keranjang">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 hover:text-orange-600 hover:shadow-lg transition" title="Login untuk Belanja">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                    
                    <div class="p-5 flex flex-col grow">
                        <div class="grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 min-h-14 group-hover:text-orange-500 transition-colors cursor-pointer" 
                                onclick="openPreviewModal(this)"
                                data-product="{{ json_encode($product) }}">
                                {{ $product->name }}
                            </h3>
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-orange-600 font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                @if($product->stock > 0)
                                    <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">Ready: {{ $product->stock }}</span>
                                @else
                                    <span class="text-[10px] font-bold text-red-600 bg-red-100 px-2 py-1 rounded-full">Habis</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-100">
                            <button type="button" 
                                    onclick="openPreviewModal(this)" 
                                    data-product="{{ json_encode($product) }}"
                                    class="block w-full text-center px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-orange-500 transition duration-300">
                                Detail & Beli
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Produk Sedang Disiapkan</h3>
                    <p class="text-gray-500 mt-2">Nantikan koleksi produk terbaru dari kami segera.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-20 bg-orange-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Berita & Tips Kemasan</h2>
            <p class="mt-3 text-gray-500">Informasi terbaru seputar dunia packaging untuk bisnis Anda.</p>
            <a href="{{ route('blog.index') }}" class="inline-block mt-4 text-orange-600 font-bold hover:underline">
                Lihat Semua Artikel →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($latestNews ?? [] as $news)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="h-48 bg-gray-200 relative group">
                        <a href="{{ route('blog.show', $news->id) }}" class="block w-full h-full">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                            @endif
                        </a>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-orange-500 uppercase tracking-wide">{{ $news->category }}</span>
                        <h3 class="mt-2 text-xl font-bold text-gray-900 hover:text-orange-600 cursor-pointer line-clamp-2">
                            <a href="{{ route('blog.show', $news->id) }}">{{ $news->title }}</a>
                        </h3>
                        <p class="mt-3 text-gray-500 text-sm leading-relaxed line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($news->content, 100) }}
                        </p>
                        <a href="{{ route('blog.show', $news->id) }}" class="mt-4 inline-block text-sm font-semibold text-orange-600 hover:text-orange-700">Baca Selengkapnya →</a>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500 italic">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section id="kontak" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16">
            <div class="space-y-10">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Informasi & Bantuan</h2>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        Kami berkomitmen memberikan pelayanan terbaik. Jangan ragu menghubungi tim kami untuk konsultasi produk, penawaran harga grosir, atau bantuan teknis lainnya.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                             <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center shrink-0 text-orange-600 mt-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">Alamat Gudang</h4>
                                <p class="text-gray-600">Jl. Legundi Business Park H 08-09, Jl. Karangandong No.58, Dusun Banjarsari, Banjaran, Driyorejo, Gresik Regency, East Java 61177</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-3">Hubungi & Ikuti Kami</h4>
                            <div class="flex flex-wrap gap-3">
                                <a href="https://shopee.co.id/aimiofficial" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-orange-500 hover:text-orange-500 transition shadow-sm group">
                                    <svg class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.8,7.6c-0.2-1.7-1.3-3-3-3.6c-0.3-0.1-0.6-0.1-0.9-0.1c-0.2,0-0.5,0-0.7,0.1c-0.9,0.2-1.6,0.7-2.1,1.4C12.8,5.9,13.4,6.4,13.4,6.4c0.4-0.5,0.9-0.9,1.5-1c0.1,0,0.3,0,0.4,0c0.9,0.3,1.4,0.9,1.5,1.7c0.6,0.5,1,1.2,1,2v0.1l0,0l0,0c0,2.6-2.5,4.3-5.5,4.3c-3,0-5.8-1.5-5.8-4.3l0,0l0,0c0-0.8,0.4-1.6,1-2.1c0.1-0.8,0.6-1.5,1.5-1.7c0.1,0,0.3,0,0.4,0c0.6,0.1,1.1,0.5,1.5,1c0,0,0.6-0.5,0.4-1C10.8,4.6,10.1,4.2,9.2,4c-0.2,0-0.5-0.1-0.7-0.1c-0.3,0-0.6,0-0.9,0.1c-1.7,0.6-2.8,1.9-3,3.6C3.1,8.3,2,10.2,2,12.7c0,5.8,4.1,10.3,10,10.3c5.9,0,10-4.5,10-10.3C22,10.2,20.9,8.3,19.8,7.6z"/>
                                    </svg>
                                    <span class="font-bold text-sm">Shopee</span>
                                </a>

                                <a href="https://www.instagram.com/aimiplastik.id/?hl=en" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-pink-500 hover:text-pink-500 transition shadow-sm group">
                                    <svg class="w-5 h-5 text-pink-600" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span class="font-bold text-sm">Instagram</span>
                                </a>

                                <a href="mailto:aimipacking45@gmail.com" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:text-blue-500 transition shadow-sm group">
                                    <svg class="w-5 h-5 text-gray-500 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="font-bold text-sm">Email</span>
                                </a>

                                <a href="https://wa.me/6282132257239" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-green-500 hover:text-green-500 transition shadow-sm group">
                                    <svg class="w-5 h-5 text-green-600 group-hover:text-green-700" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    <span class="font-bold text-sm">WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-8">
                    <h3 class="font-bold text-gray-900 text-lg mb-4">Metode Pengiriman</h3>
                    <div class="flex gap-4 mb-8 grayscale hover:grayscale-0 transition duration-300">
                        <div class="h-10 w-20 bg-white border border-gray-200 rounded flex items-center justify-center font-bold text-blue-700 italic">JNE</div>
                        <div class="h-10 w-20 bg-white border border-gray-200 rounded flex items-center justify-center font-bold text-red-600">J&T</div>
                        <div class="h-10 w-20 bg-white border border-gray-200 rounded flex items-center justify-center font-bold text-orange-500">SPX</div>
                    </div>

                    <h3 class="font-bold text-gray-900 text-lg mb-4">Metode Pembayaran</h3>
                    <div class="flex gap-4 grayscale hover:grayscale-0 transition duration-300">
                        <div class="h-10 w-20 bg-white border border-gray-200 rounded flex items-center justify-center font-bold text-blue-800">BCA</div>
                        <div class="h-10 w-20 bg-white border border-gray-200 rounded flex items-center justify-center font-bold text-orange-600">BNI</div>
                        <div class="h-10 w-20 bg-white border border-gray-200 rounded flex items-center justify-center font-bold text-blue-600">BRI</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="h-full min-h-100 w-full bg-gray-200 rounded-3xl overflow-hidden shadow-xl border border-gray-100 relative">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d23260.96283539689!2d112.56989777843683!3d-7.351839194096372!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78090070c1c3d5%3A0x1ed6e7c3668ae23d!2sPT.%20Aimi%20Plastik%20Indonesia!5e0!3m2!1sen!2sid!4v1766849888941!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                     <div class="absolute bottom-6 left-6 right-6">
                        <a href="https://wa.me/6282132257239" target="_blank" class="block w-full bg-white/90 backdrop-blur text-gray-900 py-4 rounded-xl font-bold text-center shadow-lg hover:bg-orange-500 hover:text-white transition duration-300 border border-gray-200">
                            Chat Admin Sekarang
                        </a>
                     </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========================================================= --}}
{{-- MODAL PREVIEW PRODUK (POPUP)                              --}}
{{-- ========================================================= --}}
<div id="previewModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Background Backdrop --}}
    <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm" onclick="closePreviewModal()"></div>

    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            
            {{-- Modal Panel --}}
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">
                
                {{-- Tombol Close --}}
                <button onclick="closePreviewModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-50 bg-white rounded-full p-1 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    {{-- Kolom Kiri: Gambar --}}
                    <div class="bg-gray-100 p-8 flex items-center justify-center">
                        <img id="modalImage" src="" alt="Product Image" class="w-full max-h-96 object-contain mix-blend-multiply">
                        <div id="modalNoImage" class="hidden flex flex-col items-center text-gray-400">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Gambar Tidak Tersedia</span>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Detail & Form --}}
                    <div class="p-8 flex flex-col h-full">
                        <div class="mb-auto">
                            <h3 id="modalTitle" class="text-2xl font-black text-gray-900 leading-tight mb-2">Nama Produk</h3>
                            <p id="modalPrice" class="text-3xl font-bold text-orange-600 mb-4">Rp 0</p>
                            
                            <div class="border-t border-b border-gray-100 py-4 mb-6">
                                <p id="modalDesc" class="text-gray-600 leading-relaxed text-sm h-24 overflow-y-auto pr-2">Deskripsi produk...</p>
                            </div>

                            <p class="text-sm font-bold text-gray-700 mb-2">Stok Tersedia: <span id="modalStock" class="text-green-600">0</span></p>
                        </div>

                        {{-- Form Add to Cart --}}
                        @auth
                            <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                                @csrf
                                <input type="hidden" name="product_id" id="modalProductId">
                                
                                <div class="flex items-center gap-4">
                                    <div class="max-w-32">
                                        <label class="sr-only">Jumlah</label>
                                        <div class="relative flex items-center">
                                            <button type="button" onclick="decrementQty()" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                                <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/></svg>
                                            </button>
                                            <input type="text" name="quantity" id="modalQty" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm font-bold block w-full py-2.5" value="1" readonly required />
                                            <button type="button" onclick="incrementQty()" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                                                <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" id="btnAddToCart" class="flex-1 text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-bold rounded-lg text-sm px-5 py-3 text-center flex items-center justify-center gap-2 shadow-lg shadow-orange-200 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Masukan Keranjang
                                    </button>
                                </div>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full bg-gray-900 text-white text-center py-3 rounded-xl font-bold hover:bg-gray-800 transition">
                                Login untuk Membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT SWIPER (SLIDER) --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 0,
        effect: "fade", // Efek transisi
        centeredSlides: true,
        autoplay: {
            delay: 5000, // Geser setiap 5 detik
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        loop: true,
    });
</script>

{{-- SCRIPT MODAL (POPUP) --}}
<script>
    let currentStock = 0;

    function openPreviewModal(element) {
        // Ambil data dari atribut data-product
        const productData = element.getAttribute('data-product');
        if (!productData) return;

        const product = JSON.parse(productData);

        // Isi Data Modal
        document.getElementById('modalTitle').innerText = product.name;
        document.getElementById('modalPrice').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(product.price);
        document.getElementById('modalDesc').innerText = product.description || 'Tidak ada deskripsi.';
        document.getElementById('modalStock').innerText = product.stock;
        
        // Handle Image
        const imgEl = document.getElementById('modalImage');
        const noImgEl = document.getElementById('modalNoImage');
        
        if(product.image) {
            // Gunakan path absolut agar aman
            imgEl.src = "{{ asset('storage') }}/" + product.image;
            imgEl.classList.remove('hidden');
            noImgEl.classList.add('hidden');
        } else {
            imgEl.classList.add('hidden');
            noImgEl.classList.remove('hidden');
        }

        // Set ID & Stock Logic
        currentStock = product.stock;
        const qtyInput = document.getElementById('modalQty');
        if(qtyInput) {
            qtyInput.value = 1;
            document.getElementById('modalProductId').value = product.id;
            
            const btnAdd = document.getElementById('btnAddToCart');
            if(product.stock <= 0) {
                btnAdd.disabled = true;
                btnAdd.classList.add('opacity-50', 'cursor-not-allowed');
                btnAdd.innerText = "Stok Habis";
            } else {
                btnAdd.disabled = false;
                btnAdd.classList.remove('opacity-50', 'cursor-not-allowed');
                btnAdd.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg> Masukan Keranjang';
            }
        }

        // Tampilkan Modal
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreviewModal() {
        document.getElementById('previewModal').classList.add('hidden');
    }

    function incrementQty() {
        const input = document.getElementById('modalQty');
        let val = parseInt(input.value);
        if(val < currentStock) input.value = val + 1;
    }

    function decrementQty() {
        const input = document.getElementById('modalQty');
        let val = parseInt(input.value);
        if(val > 1) input.value = val - 1;
    }
</script>

@endsection