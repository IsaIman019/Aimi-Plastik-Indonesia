@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Buat Promo Baru</h2>

    <form action="{{ route('admin.promos.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-bold">Nama Promo</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block mb-1 font-bold">Tipe Diskon</label>
                <select name="type" class="w-full border p-2 rounded">
                    <option value="percent">Persen (%)</option>
                    <option value="fixed">Potongan Tetap (Rp)</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-bold">Nilai Diskon</label>
            <input type="number" name="value" class="w-full border p-2 rounded" placeholder="Contoh: 10 (untuk 10%) atau 5000 (untuk Rp 5.000)" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1 font-bold">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block mb-1 font-bold">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full border p-2 rounded" required>
            </div>
        </div>

        {{-- PILIH PRODUK --}}
        <div class="mb-6">
            <label class="block mb-1 font-bold">Pilih Produk (Tekan Ctrl/Cmd untuk pilih banyak)</label>
            <select name="products[]" multiple class="w-full border p-2 rounded h-48" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - Rp {{ number_format($product->price) }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">*Produk yang dipilih akan mendapatkan harga diskon.</p>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-bold">Simpan Promo</button>
    </form>
</div>
@endsection