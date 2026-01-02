@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Berita</h1>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Judul Berita</label>
                    <input type="text" name="title" value="{{ $news->title }}" class="w-full border rounded-lg px-4 py-2 text-lg font-bold" required>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Kategori</label>
                        <select name="category" class="w-full border rounded-lg px-4 py-2">
                            <option value="Tips Bisnis" {{ $news->category == 'Tips Bisnis' ? 'selected' : '' }}>Tips Bisnis</option>
                            <option value="Produk Baru" {{ $news->category == 'Produk Baru' ? 'selected' : '' }}>Produk Baru</option>
                            <option value="Info Pengiriman" {{ $news->category == 'Info Pengiriman' ? 'selected' : '' }}>Info Pengiriman</option>
                            <option value="Promo" {{ $news->category == 'Promo' ? 'selected' : '' }}>Promo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Ganti Thumbnail (Opsional)</label>
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" class="h-10 w-auto mb-2 rounded border">
                        @endif
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"/>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Isi Konten</label>
                    <textarea name="content" rows="10" class="w-full border rounded-lg px-4 py-2" required>{{ $news->content }}</textarea>
                </div>

                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">Update Berita</button>
            </form>
        </div>
    </div>
</div>
@endsection