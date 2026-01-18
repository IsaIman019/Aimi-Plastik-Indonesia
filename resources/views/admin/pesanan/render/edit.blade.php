@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('components.admin-sidebar')
    <div class="flex-1 p-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Proses Pesanan #{{ $order->invoice_number }}</h1>
            <a href="{{ route('admin.orders') }}" class="text-gray-500 hover:text-orange-600">← Kembali</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Pesanan</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-orange-500">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                            <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Diproses (Sedang Packing)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim (Input Resi)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kurir Ekspedisi</label>
                        <select name="courier" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="JNE" {{ $order->courier == 'JNE' ? 'selected' : '' }}>JNE</option>
                            <option value="J&T Express" {{ $order->courier == 'J&T Express' ? 'selected' : '' }}>J&T Express</option>
                            <option value="SiCepat" {{ $order->courier == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Resi (Jika sudah dikirim)</label>
                        <input type="text" name="resi_number" value="{{ $order->resi_number }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 font-mono uppercase" placeholder="Masukkan No Resi">
                        <p class="text-xs text-gray-500 mt-1">Isi hanya jika status diubah menjadi 'Dikirim'.</p>
                    </div>

                    <button type="submit" class="w-full bg-orange-600 text-white font-bold py-3 rounded-xl hover:bg-orange-700 transition">Simpan Perubahan</button>
                </form>
            </div>

            <div class="bg-gray-100 rounded-xl p-6 h-fit">
                <h3 class="font-bold text-gray-900 mb-4">Info Pelanggan</h3>
                <p class="text-sm font-bold">{{ $order->user->name }}</p>
                <p class="text-xs text-gray-600 mb-4">{{ $order->user->email }}</p>
                
                <h3 class="font-bold text-gray-900 mb-2">Alamat Kirim</h3>
                <p class="text-xs text-gray-600 leading-relaxed">{{ $order->user->address ?? 'Alamat belum diisi lengkap.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection