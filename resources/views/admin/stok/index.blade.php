@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-8 overflow-y-auto h-screen">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Stok</h1>
                <p class="text-gray-500 mt-1">Pantau dan perbarui jumlah stok produk dengan cepat.</p>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 uppercase text-xs font-bold text-gray-500 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Status Stok</th>
                            <th class="px-6 py-4">Update Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $product->name }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold">
                                    {{ $product->category->name ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($product->stock == 0)
                                    <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Habis</span>
                                @elseif($product->stock <= 10)
                                    <span class="inline-flex px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menipis</span>
                                @else
                                    <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Aman</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <form action="{{ route('admin.stock.update', $product->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <div class="relative w-24">
                                        <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="w-full border-gray-300 rounded-lg text-center font-bold focus:ring-orange-500 focus:border-orange-500 text-sm py-2">
                                    </div>
                                    <button type="submit" class="p-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition shadow-md" title="Simpan Stok">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
@endsection