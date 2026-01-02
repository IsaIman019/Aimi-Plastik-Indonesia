@extends('layouts.app')

@section('content')

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2">
                <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    
                    <div class="w-full h-64 md:h-96 bg-gray-200 relative">
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">No Image</div>
                        @endif
                    </div>

                    <div class="p-8 md:p-10">
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full font-bold uppercase text-xs">
                                {{ $news->category }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $news->created_at->format('d F Y') }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 leading-tight">
                            {{ $news->title }}
                        </h1>

                        <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                            {!! nl2br(e($news->content)) !!}
                        </div>

                        <div class="mt-10 pt-8 border-t border-gray-100">
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-gray-600 hover:text-orange-600 font-bold transition">
                                &larr; Kembali ke Daftar Berita
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="lg:col-span-1 space-y-8">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Berita Terbaru Lainnya</h3>
                    
                    <div class="space-y-6">
                        @foreach($recentNews as $recent)
                        <a href="{{ route('blog.show', $recent->id) }}" class="flex gap-4 group">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($recent->image)
                                    <img src="{{ asset('storage/' . $recent->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">Img</div>
                                @endif
                            </div>
                            <div>
                                <span class="text-xs text-orange-600 font-bold uppercase">{{ $recent->category }}</span>
                                <h4 class="text-sm font-bold text-gray-900 line-clamp-2 mt-1 group-hover:text-orange-600 transition">
                                    {{ $recent->title }}
                                </h4>
                                <p class="text-xs text-gray-400 mt-1">{{ $recent->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-8 text-center text-white">
                    <h3 class="text-xl font-bold mb-3">Butuh Kemasan?</h3>
                    <p class="text-gray-300 text-sm mb-6">Temukan berbagai produk kemasan berkualitas untuk bisnis Anda di katalog kami.</p>
                    <a href="{{ route('home') }}#katalog" class="inline-block bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition w-full shadow-lg">
                        Lihat Katalog
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection