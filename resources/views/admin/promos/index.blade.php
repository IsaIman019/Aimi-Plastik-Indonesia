@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Kode Promo</h1>
            <button class="px-4 py-2 bg-orange-600 text-white rounded-lg font-bold hover:bg-orange-700 transition">+ Buat Promo</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($promos ?? [] as $promo)
            <div class="bg-white border-l-4 border-orange-500 rounded-lg shadow-sm p-5 relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-wider">{{ $promo->code }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Diskon: <span class="font-bold text-orange-600">Rp {{ number_format($promo->discount_amount) }}</span></p>
                    </div>
                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-bold">Aktif</span>
                </div>
                <div class="mt-4 pt-4 border-t border-dashed border-gray-200 flex justify-between items-center text-xs text-gray-400">
                    <span>Berakhir: {{ date('d M Y', strtotime($promo->end_date)) }}</span>
                    <button class="text-red-500 hover:text-red-700">Hapus</button>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500">Belum ada promo yang aktif.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection