@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tulis Berita Baru</h1>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Judul Berita</label>
                    <input type="text" name="title" class="w-full border rounded-lg px-4 py-2 text-lg font-bold" placeholder="Contoh: Tips Packing Aman..." required>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Kategori</label>
                        <select name="category" class="w-full border rounded-lg px-4 py-2">
                            <option value="Tips Bisnis">Tips Bisnis</option>
                            <option value="Produk Baru">Produk Baru</option>
                            <option value="Info Pengiriman">Info Pengiriman</option>
                            <option value="Promo">Promo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Thumbnail Gambar</label>
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"/>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Isi Konten</label>
                    <textarea name="content" rows="10" class="w-full border rounded-lg px-4 py-2" placeholder="Tulis isi berita di sini..." required></textarea>
                </div>

                <button type="submit" class="px-6 py-3 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700">Terbitkan Berita</button>
            </form>
        </div>
    </div>
</div>
@endsection