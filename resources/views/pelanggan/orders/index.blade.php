@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a> /
            <span class="text-gray-900">Profil Saya</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- SIDEBAR KIRI --}}
            <div class="w-full lg:w-1/4">
                {{-- Kartu User --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 border border-gray-300">
                        @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random"
                            class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="font-bold text-gray-900 truncate">{{ $user->nama }}</h3>
                        <p class="text-xs text-gray-500 truncate">Member Pelanggan</p>
                    </div>
                </div>

                {{-- Menu Navigasi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <nav class="flex flex-col">
                        {{-- 1. AKUN SAYA (AKTIF) --}}
                        <a href="{{ route('pelanggan.profile') }}"
                            class="flex items-center gap-3 px-6 py-4 text-sm font-bold text-orange-600 bg-orange-50 border-l-4 border-orange-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Biodata
                        </a>

                        {{-- 2. PESANAN SAYA --}}
                        <a href="{{ route('pelanggan.orders.index') }}"
                            class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition border-l-4 border-transparent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Pesanan Saya
                            @if(isset($pendingOrders) && $pendingOrders > 0)
                            <span
                                class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $pendingOrders }}</span>
                            @endif
                        </a>

                        {{-- 3. ALAMAT PENGIRIMAN (LINK KE HALAMAN BARU) --}}
                        <a href="{{ route('pelanggan.address.index') }}"
                            class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 transition border-l-4 border-transparent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Pengiriman
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-6 py-4 text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left text-gray-600">
                <thead class="bg-gray-100 uppercase text-xs font-bold text-gray-500">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono font-bold text-orange-600">#{{ $order->invoice_number }}</td>
                        <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu Konfirmasi</span>
                            @elseif($order->status == 'processed')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Diproses</span>
                            @elseif($order->status == 'shipped')
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Dikirim</span>
                            @elseif($order->status == 'completed')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Batal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('pelanggan.orders.show', $order->id) }}" class="text-blue-600 font-bold hover:underline text-sm">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection