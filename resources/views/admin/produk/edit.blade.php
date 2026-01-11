@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
            <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-orange-600">← Kembali</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-3xl">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Harga</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ $product->description }}</textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ganti Foto (Opsional)</label>
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" class="h-20 w-20 object-cover rounded mb-2 border">
                    @endif
                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"/>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-orange-600 transition">Update Produk</button>
            </form>
        </div>
    </div>
</div>
@endsection