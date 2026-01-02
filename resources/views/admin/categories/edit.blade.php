@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Kategori</h1>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Nama Kategori</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                
                <div class="flex gap-3">
                    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection