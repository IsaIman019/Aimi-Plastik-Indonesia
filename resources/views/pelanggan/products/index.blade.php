@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Katalog Produk</h1>
            
            {{-- SEARCH BAR --}}
            <form action="{{ route('pelanggan.products') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}" 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:ring-orange-500 focus:border-orange-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden group border border-gray-100">
                    <a href="{{ route('pelanggan.products.show', $product->id) }}">
                        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-200 relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="object-cover w-full h-48 group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-48 flex items-center justify-center text-gray-400"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                            @endif
                            @if($product->stock <= 5 && $product->stock > 0)
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Stok Menipis</span>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 truncate">{{ $product->name }}</h3>
                        <p class="text-orange-600 font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            
                            @if($product->stock > 0)
                                <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded-lg text-sm font-bold hover:bg-orange-600 transition">
                                    + Keranjang
                                </button>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg text-sm font-bold cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-gray-500">Produk tidak ditemukan.</div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection