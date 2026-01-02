@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-8 overflow-y-auto h-screen">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori</h1>
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-orange-600 font-bold">&larr; Kembali</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-lg mx-auto">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 p-3" placeholder="Contoh: Lakban, Bubble Wrap..." required>
                </div>
                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection