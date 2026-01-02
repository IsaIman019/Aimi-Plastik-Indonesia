<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aimi Packaging - Solusi Kemasan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    {{-- LOGIKA HITUNG KERANJANG --}}
    @php
        $cartCount = 0;
        if(Auth::check() && Auth::user()->role === 'pelanggan'){
            try { $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count(); } catch(\Exception $e) {}
        }
    @endphp

    {{-- NAVBAR --}}
    @if(!request()->is('admin/*'))
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm/50 backdrop-blur-md bg-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 group">
                        <img src="{{ asset('images/Aimi.png') }}" alt="Logo Aimi" class="h-12 w-auto object-contain group-hover:opacity-80 transition">
                        <div class="flex flex-col">
                            <span class="font-bold text-xl text-gray-900 tracking-tight leading-none">Aimi<span class="text-orange-600">Packaging</span></span>
                            <span class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">Solusi Kemasan</span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-bold {{ request()->routeIs('home') ? 'text-orange-600' : 'text-gray-600 hover:text-orange-600' }} transition">Beranda</a>
                    
                    <a href="{{ route('about') }}" class="text-sm font-bold {{ request()->routeIs('about') ? 'text-orange-600' : 'text-gray-600 hover:text-orange-600' }} transition">Tentang Kami</a>
                    
                    <a href="{{ route('blog.index') }}" class="text-sm font-bold {{ request()->routeIs('blog.*') ? 'text-orange-600' : 'text-gray-600 hover:text-orange-600' }} transition">Artikel</a>

                    {{-- MENU BARU: DROPDOWN MARKETPLACE --}}
                    <div class="relative group">
                        <button class="flex items-center gap-1 text-sm font-bold text-gray-600 hover:text-orange-600 transition focus:outline-none">
                            Marketplace
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Isi Dropdown --}}
                        <div class="absolute left-1/2 -translate-x-1/2 mt-0 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top pt-4 z-50">
                            <div class="p-2 bg-white rounded-xl">
                                
                                {{-- Shopee --}}
                                <a href="https://shopee.co.id/aimiofficial" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-orange-50 group/item transition">
                                    <svg class="w-5 h-5 text-orange-500 group-hover/item:scale-110 transition" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.8,7.6c-0.2-1.7-1.3-3-3-3.6c-0.3-0.1-0.6-0.1-0.9-0.1c-0.2,0-0.5,0-0.7,0.1c-0.9,0.2-1.6,0.7-2.1,1.4C12.8,5.9,13.4,6.4,13.4,6.4c0.4-0.5,0.9-0.9,1.5-1c0.1,0,0.3,0,0.4,0c0.9,0.3,1.4,0.9,1.5,1.7c0.6,0.5,1,1.2,1,2v0.1l0,0l0,0c0,2.6-2.5,4.3-5.5,4.3c-3,0-5.8-1.5-5.8-4.3l0,0l0,0c0-0.8,0.4-1.6,1-2.1c0.1-0.8,0.6-1.5,1.5-1.7c0.1,0,0.3,0,0.4,0c0.6,0.1,1.1,0.5,1.5,1c0,0,0.6-0.5,0.4-1C10.8,4.6,10.1,4.2,9.2,4c-0.2,0-0.5-0.1-0.7-0.1c-0.3,0-0.6,0-0.9,0.1c-1.7,0.6-2.8,1.9-3,3.6C3.1,8.3,2,10.2,2,12.7c0,5.8,4.1,10.3,10,10.3c5.9,0,10-4.5,10-10.3C22,10.2,20.9,8.3,19.8,7.6z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-700 group-hover/item:text-orange-600">Shopee</span>
                                </a>

                                {{-- TikTok --}}
                                <a href="https://www.tiktok.com/@aimiplastik.id" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 group/item transition">
                                    <svg class="w-5 h-5 text-black group-hover/item:scale-110 transition" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.65-1.62-1.12-1.09 3.09-3.89 5.25-7.2 5.25-4.22.02-7.71-3.37-7.75-7.61-.03-4.24 3.39-7.69 7.63-7.69.05 0 .09 0 .14.01V6.9c-.06-.01-.12-.01-.18-.01-2.03.01-3.69 1.67-3.69 3.7 0 2.03 1.65 3.69 3.69 3.69 1.76 0 3.26-1.24 3.62-2.91.13-.6.13-1.21.03-1.81V.02z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-700 group-hover/item:text-black">TikTok</span>
                                </a>

                                {{-- Instagram --}}
                                <a href="https://www.instagram.com/aimiplastik.id" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-pink-50 group/item transition">
                                    <svg class="w-5 h-5 text-pink-600 group-hover/item:scale-110 transition" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span class="font-bold text-sm">Instagram</span>
                                </a>

                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('home') }}#katalog" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition">Katalog</a>
                    
                    <a href="{{ route('home') }}#kontak" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition">Kontak</a>
                </div>

                <div class="flex items-center gap-3">
                    <button class="p-2 text-gray-400 hover:text-gray-600 transition rounded-full hover:bg-gray-100 hidden sm:block">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>

                    <div class="h-6 w-px bg-gray-200 mx-2 hidden sm:block"></div>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-gray-900 text-white px-4 py-2 rounded-full text-xs font-bold hover:bg-gray-800 transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('cart') }}" class="relative p-2 text-gray-500 hover:text-orange-600 transition group mr-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                @if($cartCount > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full border-2 border-white">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        @endif

                        <div class="relative group cursor-pointer ml-1">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs border border-orange-200">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                            
                            {{-- DROPDOWN PROFIL --}}
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-xs text-gray-500">Halo,</p>
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                </div>
                                
                                {{-- MENU PROFIL PELANGGAN (UPDATE) --}}
                                @if(Auth::user()->role === 'pelanggan')
                                    <a href="{{ route('pelanggan.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 border-b border-gray-50">
                                        Akun Saya
                                    </a>
                                    <a href="{{ route('pelanggan.address.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 border-b border-gray-50">
                                        Alamat Pengiriman
                                    </a>
                                    <a href="{{ route('pelanggan.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        Pesanan Saya
                                    </a>
                                @endif

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl font-medium transition border-t border-gray-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition px-3">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-orange-600 rounded-full hover:bg-orange-700 transition shadow-lg shadow-orange-200">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    @endif

    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @if(!request()->is('admin/*'))
    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <img src="{{ asset('images/Aimi.png') }}" alt="Logo Aimi" class="h-16 w-auto mb-4 bg-white rounded-lg p-1">
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm">
                        Partner terpercaya untuk kebutuhan packing bisnis Anda. Menyediakan lakban, bubble wrap, dan perlengkapan lainnya.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-gray-200">Menu Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-500 transition">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-orange-500 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-orange-500 transition">Artikel</a></li>
                        <li><a href="#katalog" class="hover:text-orange-500 transition">Katalog Produk</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-gray-200">Hubungi Kami</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>WhatsApp: +62 821-3225-7239</li>
                        <li>Email: aimipacking45@gmail.com</li>
                        <li>Gresik, Jawa Timur</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} PT. Aimi Plastik Indonesia. All rights reserved.</p>
                <p>Designed for Excellence</p>
            </div>
        </div>
    </footer>
    @endif

</body>
</html>