@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-gray-100 rounded-2xl overflow-hidden shadow-sm">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain">
                @else
                    <div class="w-full h-96 flex items-center justify-center text-gray-400">Gambar tidak tersedia</div>
                @endif
            </div>

            <div>
                <span class="text-orange-600 font-bold uppercase tracking-wide text-sm">Kategori: {{ $product->category->name ?? 'Umum' }}</span>
                <h1 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-gray-900 mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <div class="mt-6 border-t border-b border-gray-100 py-4">
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="mt-6">
                    <p class="text-sm font-bold text-gray-700 mb-2">Stok Tersedia: <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock }} Unit</span></p>
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="w-24">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full border-gray-300 rounded-xl text-center py-3 font-bold focus:ring-orange-500">
                        </div>

                        @if($product->stock > 0)
                            <button type="submit" class="flex-1 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-200">
                                Masukkan Keranjang
                            </button>
                        @else
                            <button disabled class="flex-1 bg-gray-300 text-gray-500 font-bold rounded-xl cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection