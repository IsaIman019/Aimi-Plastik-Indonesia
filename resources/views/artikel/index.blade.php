@extends('layouts.app')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="relative bg-gray-900 py-20">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/perusahaan.jpg') }}" class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-white tracking-tight">Berita & Artikel</h1>
        <p class="mt-4 text-xl text-gray-300">Wawasan terbaru seputar industri kemasan dan update dari Aimi Packaging.
        </p>
    </div>
</div>

<div class="bg-white py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 font-sans">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-12">
            <div class="lg:col-span-3">
                <article class="group cursor-pointer relative rounded-xl overflow-hidden shadow-lg h-[450px]">
                    <img src="https://images.unsplash.com/photo-1589793463308-658ed42e5dfe?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-8">
                        <div class="bg-white px-4 py-1.5 rounded-full shadow-md w-fit mb-4">
                            <span class="text-slate-500 text-[11px] font-bold">23 December 2025</span>
                        </div>

                        <h2 class="text-2xl md:text-2xl font-bold text-white mb-3 leading-tight">
                            Panduan Lengkap Assembly Point : Pentingnya Titik Kumpul Darurat untuk Keselamatan Optimal
                        </h2>

                        <p class="text-gray-200 leading-relaxed text-sm md:text-base max-w-4xl line-clamp-2">
                            Panduan lengkap tentang Assembly Point atau titik kumpul darurat, mulai dari fungsi, standar
                            keselamatan, hingga perannya dalam evakuasi untuk melindungi pekerja dan pengunjung secara
                            optimal.
                        </p>
                    </div>
                </article>
            </div>

            <div class="lg:col-span-1">
                <h3 class="text-xl font-bold text-[#F54A00] mb-4 tracking-tight">Terpopuler</h3>

                <div class="flex flex-col">
                    @php
                    $populer = [
                    ['title' => 'Apakah APAR bisa Kadaluarsa?', 'date' => '24 February 2023', 'img' =>
                    'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400'],
                    ['title' => 'Cermin Cembung (Convex Mirror) untuk Jalan Raya: Cara Kerja dan Panduan Pemasangan',
                    'date' => '24 March 2025', 'img' =>
                    'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400'],
                    ['title' => 'Tipe APAR untuk Kebakaran Listrik', 'date' => '04 July 2022', 'img' =>
                    'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?w=400']
                    ];
                    @endphp

                    @foreach($populer as $pop)
                    <div
                        class="flex gap-4 py-5 {{ !$loop->last ? 'border-b border-gray-100' : '' }} group cursor-pointer items-start">

                        <div class="w-25 h-25 flex-shrink-0 rounded-xl overflow-hidden bg-gray-50 shadow-sm">
                            <img src="{{ $pop['img'] }}"
                                class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                        </div>

                        <div class="flex flex-col pt-1">
                            <span class="text-[11px] text-gray-400 font-medium mb-1.5 uppercase tracking-wide">
                                {{ $pop['date'] }}
                            </span>

                            <a href="#"
                                class="text-[14px] font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-red-600 transition-colors duration-200">
                                {{ $pop['title'] }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            @php
            $bottomArticles = [
            ['title' => 'Bagian-bagian APAR dan Fungsinya', 'img' =>
            'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5?w=400'],
            ['title' => '5 Langkah Mudah Penggunaan APAR sesuai Prosedur', 'img' =>
            'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400'],
            ['title' => 'Daftar Harga APAR Terbaik', 'img' =>
            'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?w=400'],
            ['title' => 'Cara Instalasi APAR Tonata', 'img' =>
            'https://images.unsplash.com/photo-1513224502586-d1e602410265?w=400'],
            ];
            @endphp

            {{-- Hanya gunakan foreach agar artikel muncul 4 sesuai jumlah data --}}
            @foreach($bottomArticles as $article)
            <article class="group cursor-pointer">
                <div class="relative mb-8">
                    <div class="rounded-xl overflow-hidden shadow-sm aspect-video">
                        <img src="{{ $article['img'] }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    </div>

                    <div
                        class="absolute -bottom-4 left-6 bg-white px-4 py-1.5 rounded-full shadow-md border border-gray-50 z-10">
                        <span class="text-slate-400 text-[10px] font-bold whitespace-nowrap uppercase">26 November
                            2025</span>
                    </div>
                </div>

                <div class="px-2">
                    <h4
                        class="text-base font-bold text-slate-800 leading-tight mb-2 line-clamp-2 group-hover:text-red-700 transition">
                        {{ $article['title'] }}
                    </h4>
                    <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">
                        Pelajari informasi lengkap mengenai {{ strtolower($article['title']) }} untuk meningkatkan
                        standar keamanan.
                    </p>
                </div>
            </article>
            @endforeach
        </div>



        <div id="videoModal" class="fixed inset-0 z-100 hidden items-center justify-center bg-black/90 p-4">
            <div class="relative w-full max-w-4xl aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
                <button onclick="closeVideo()"
                    class="absolute top-4 right-4 z-110 text-white bg-red-600 w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg hover:bg-red-700">✕</button>

                <iframe id="youtubeFrame" class="w-full h-full" src="" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>


        <style>
            [x-cloak] {
                display: none !important;
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <div x-data="{ limit: 8, totalData: 12 }" class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

                @foreach($allArtikel as $index => $artikel)
                <article x-show="{{ $index }} < limit" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="group cursor-pointer">

                    <div class="relative mb-8">
                        <div class="rounded-xl overflow-hidden shadow-sm aspect-video">
                            <img src="{{ url('storage/' . $artikel->gambar) }}"
                                class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        </div>

                        <div
                            class="absolute -bottom-4 left-6 bg-white px-4 py-1.5 rounded-full shadow-md border border-gray-50 z-10">
                            <span
                                class="text-slate-400 text-[10px] font-bold whitespace-nowrap uppercase">{{ $artikel->created_at->format('d F Y') }}</span>
                        </div>
                    </div>

                    <div class="px-2">
                        <h4
                            class="text-base font-bold text-slate-800 leading-tight mb-2 line-clamp-2 group-hover:text-red-700 transition">
                            {{ $artikel['konten'] }}
                        </h4>
                        <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">
                            Pelajari informasi lengkap mengenai {{ strtolower($artikel['konten']) }} untuk meningkatkan
                            standar keamanan.
                        </p>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="flex justify-center mt-12" x-show="limit < totalData">
                <button @click="limit += 4"
                    class="group flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-10 py-3.5 rounded-full font-bold text-sm transition-all shadow-lg hover:shadow-red-200">
                    Lihat Artikel Lainnya
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transition-transform group-hover:translate-y-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openVideo(id) {
        const modal = document.getElementById('videoModal');
        const frame = document.getElementById('youtubeFrame');

        // Pasang link YouTube embed
        frame.src = `https://www.youtube.com/embed/${id}?autoplay=1`;

        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Kunci scrolling layar
        document.body.style.overflow = 'hidden';
    }

    function closeVideo() {
        const modal = document.getElementById('videoModal');
        const frame = document.getElementById('youtubeFrame');

        // Sembunyikan modal dan kosongkan src agar video berhenti
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        frame.src = "";

        // Aktifkan kembali scrolling
        document.body.style.overflow = 'auto';
    }

    // Tutup modal jika klik di luar area video
    window.onclick = function(event) {
        const modal = document.getElementById('videoModal');
        if (event.target == modal) {
            closeVideo();
        }
    }
</script>

@endsection