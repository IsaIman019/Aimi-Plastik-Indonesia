@extends('layouts.app')

@section('content')

<div class="relative bg-gray-900 py-20">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/perusahaan.jpg') }}" class="w-full h-full object-cover opacity-30">
    </div>
    <div class="relative max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold text-white tracking-tight">Berita & Artikel</h1>
        <p class="mt-4 text-xl text-gray-300">Wawasan terbaru seputar industri kemasan dan update dari Aimi Packaging.</p>
    </div>
</div>

<div class="bg-gray-50 py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($allNews as $news)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full">
                    
                    {{-- Gambar --}}
                    <div class="h-56 bg-gray-200 relative overflow-hidden group">
                        <a href="{{ route('blog.show', $news->id) }}">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                            @endif
                        </a>
                        <div class="absolute top-4 left-4 bg-orange-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase shadow-sm">
                            {{ $news->category }}
                        </div>
                    </div>

                    {{-- Konten --}}
                    <div class="p-6 flex flex-col flex-1">
                        <div class="text-xs text-gray-500 mb-3 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $news->created_at->format('d M Y') }}
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-orange-600 transition">
                            <a href="{{ route('blog.show', $news->id) }}">{{ $news->title }}</a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($news->content), 120) }}
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ route('blog.show', $news->id) }}" class="text-orange-600 font-bold text-sm hover:text-orange-800 flex items-center gap-1 group">
                                Baca Selengkapnya 
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-20">
                    <p class="text-gray-500">Belum ada artikel yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $allNews->links() }}
        </div>
    </div>
</div>
@endsection