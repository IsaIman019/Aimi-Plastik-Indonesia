@extends('layouts.app')

@section('content')

<div class="relative bg-gray-900 py-24 sm:py-32">
    <img src="{{ asset('img/Plastik4.jpg') }}" alt="Gudang Aimi Plastik" class="absolute inset-0 -z-10 h-full w-full object-cover object-center opacity-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Tentang Kami</h1>
        <p class="mt-6 text-lg leading-8 text-gray-300">Mengenal lebih dekat PT. Aimi Plastik Indonesia, mitra solusi kemasan terpercaya Anda.</p>
    </div>
</div>

<div class="bg-white py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-6">Filosofi Perusahaan</h2>
                <div class="space-y-6 text-gray-600 leading-relaxed text-lg">
                    <p>
                        Di <strong>PT. Aimi Plastik Indonesia</strong>, kami percaya bahwa kemasan bukan sekadar pembungkus. Kemasan adalah <span class="text-orange-600 font-bold">pelindung nilai</span>, representasi kualitas, dan jembatan kepercayaan antara penjual dan pembeli.
                    </p>
                    <p>
                        Filosofi kami adalah <strong>"Protecting Values, Delivering Promises"</strong>. Setiap lembar bubble wrap, setiap gulungan lakban, dan setiap plastik yang kami produksi didedikasikan untuk memastikan produk pelanggan kami sampai ke tujuan dengan aman dan sempurna.
                    </p>
                    <p>
                        Berdiri sejak tahun 2020, kami tumbuh dari usaha kecil menjadi salah satu distributor packaging terbesar di Jawa Timur dengan memegang teguh prinsip kejujuran, kualitas, dan pelayanan prima.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-w-3 aspect-h-2 rounded-2xl overflow-hidden shadow-2xl bg-gray-100">
                     <img src="{{ asset('img/perusahaan.jpg') }}" class="object-cover w-full h-full" alt="Tim PT. Aimi Plastik Indonesia">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-orange-600 text-white p-6 rounded-xl shadow-lg hidden md:block">
                    <p class="text-4xl font-black">5+</p>
                    <p class="text-sm font-medium uppercase tracking-wide">Tahun Pengalaman</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900">Visi & Misi</h2>
            <p class="mt-4 text-gray-500">Arah dan tujuan kami dalam melayani industri di Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi perusahaan penyedia solusi pengemasan (packaging) terdepan di Indonesia yang dikenal karena kualitas produk, inovasi berkelanjutan, dan pelayanan yang berorientasi pada kepuasan pelanggan.
                </p>
            </div>

            <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                <ul class="space-y-4 text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Menyediakan produk kemasan berkualitas tinggi dengan harga yang kompetitif.
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Memberikan pelayanan yang responsif, ramah, dan solutif kepada setiap mitra bisnis.
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Membangun jaringan distribusi yang luas dan efisien di seluruh Indonesia.
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Terus berinovasi dalam teknologi pengemasan yang ramah lingkungan.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="py-16 sm:py-24 bg-white">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Lokasi Kami</h2>
        <div class="h-96 w-full bg-gray-200 rounded-2xl overflow-hidden shadow-lg border border-gray-200">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.381395029377!2d112.6074499!3d-7.3110222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7807a555555555%3A0x0!2zN8KwMTgnMzkuNyJTIDExMsKwMzYnMjYuOCJF!5e0!3m2!1sen!2sid!4v1600000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="text-center mt-6">
            <p class="text-gray-900 font-bold">PT. Aimi Plastik Indonesia</p>
            <p class="text-gray-500">Jl.  Legundi Business Park H 08-09, Jl. Karangandong No.58, Dusun Banjarsari, Banjaran, Driyorejo, Gresik Regency, East Java 61177</p>
        </div>
    </div>
</div>

@endsection