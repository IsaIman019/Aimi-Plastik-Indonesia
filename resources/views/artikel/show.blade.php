@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Image -->
    @if($artikel->gambar)
    <div class="w-full h-64 md:h-80 lg:h-96 bg-gray-900">
        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}"
            class="w-full h-full object-cover">
    </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <div class="lg:flex lg:gap-8">

            <!-- Left Content - Article -->
            <div class="lg:w-2/3">
                <article>
                    <!-- Article Info -->
                    <div class="mb-8">
                        <p class="text-gray-500 text-sm mb-2">{{ $artikel->created_at->format('d F Y') }}</p>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                            {{ $artikel->judul }}
                        </h1>
                    </div>

                    <!-- Article Content -->
                    <div class="prose prose-lg max-w-none">
                        <div class="text-gray-800 leading-relaxed">
                            <!-- Process content with proper HTML formatting -->
                            @php
                            $content = $artikel->konten;

                            // Clean the content first
                            $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

                            // Convert markdown-like formatting to HTML - FIXED REGEX
                            $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);
                            $content = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $content);

                            // Convert headings - FIXED REGEX (escape #)
                            $content = preg_replace('/^# (.*)$/m', '<h2 class="text-2xl font-bold mt-8 mb-4">$1</h2>',
                            $content);
                            $content = preg_replace('/^## (.*)$/m', '<h3 class="text-xl font-bold mt-6 mb-3">$1</h3>',
                            $content);
                            $content = preg_replace('/^### (.*)$/m', '<h4 class="text-lg font-bold mt-4 mb-2">$1</h4>',
                            $content);

                            // Convert lists - SIMPLIFIED APPROACH
                            // First, handle list items
                            $lines = explode("\n", $content);
                            $inList = false;
                            $formattedLines = [];

                            foreach ($lines as $line) {
                            // Check if line starts with dash or asterisk
                            if (preg_match('/^[\-\*]\s+(.+)$/', trim($line), $matches)) {
                            if (!$inList) {
                            $formattedLines[] = '<ul class="list-disc ml-6 mb-4">';
                                $inList = true;
                                }
                                $formattedLines[] = '<li class="mb-2">' . $matches[1] . '</li>';
                                } else {
                                if ($inList) {
                                $formattedLines[] = '</ul>';
                            $inList = false;
                            }
                            $formattedLines[] = $line;
                            }
                            }

                            // Close any open list
                            if ($inList) {
                            $formattedLines[] = '</ul>';
                            }

                            $content = implode("\n", $formattedLines);

                            // Convert line breaks
                            $content = nl2br($content);

                            // Finally, decode HTML entities for safe output
                            $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
                            @endphp

                            {!! $content !!}
                        </div>
                    </div>
                </article>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:w-1/3 mt-8 lg:mt-0">
                <div class="space-y-8">

                    <!-- Artikel Terkait -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                            Artikel Terkait
                        </h3>
                        <div class="space-y-6">
                            @forelse($recentArtikel as $recent)
                            <a href="{{ route('artikel.show', $recent->id) }}" class="block group">
                                <div class="flex items-start space-x-4">
                                    <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($recent->gambar)
                                        <img src="{{ asset('storage/' . $recent->gambar) }}" alt="{{ $recent->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 mb-1">{{ $recent->created_at->format('d F Y') }}
                                        </p>
                                        <h4
                                            class="text-base font-bold text-gray-900 line-clamp-2 group-hover:text-red-600 transition">
                                            {{ $recent->judul }}
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada artikel terkait</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Ad Banner -->
                    <div
                        class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl shadow-lg p-8 text-center text-white">
                        <h3 class="text-xl font-bold mb-3">Butuh Kemasan?</h3>
                        <p class="text-gray-300 text-sm mb-6">Temukan berbagai produk kemasan berkualitas untuk bisnis
                            Anda di katalog kami.</p>
                        <a href="{{ route('home') }}#katalog"
                            class="inline-block bg-orange-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-orange-700 transition w-full shadow-lg">
                            Lihat Katalog
                        </a>
                    </div>

                    <!-- Artikel Populer -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                            Artikel Populer
                        </h3>
                        <div class="space-y-6">
                            @forelse($popularArticles as $popular)
                            <a href="{{ route('artikel.show', $popular->id) }}" class="block group">
                                <div class="flex items-start space-x-4">
                                    <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                        @if($popular->gambar)
                                        <img src="{{ asset('storage/' . $popular->gambar) }}"
                                            alt="{{ $popular->judul }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 mb-1">
                                            {{ $popular->created_at->format('d F Y') }}
                                        </p>
                                        <h4
                                            class="text-base font-bold text-gray-900 line-clamp-2 group-hover:text-red-600 transition">
                                            {{ $popular->judul }}
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada artikel populer</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;

        button.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 6L9 17L4 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        `;

        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endsection