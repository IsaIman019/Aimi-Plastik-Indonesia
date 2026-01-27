@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-orange-600">Beranda</a> /
            <span class="text-gray-900">Pesanan Saya</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- SIDEBAR --}}
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

                {{-- Menu --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <nav class="flex flex-col">

                        <a href="{{ route('pelanggan.profile') }}"
                           class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 border-l-4 border-transparent">
                            Profil Biodata
                        </a>

                        {{-- AKTIF --}}
                        <a href="{{ route('pelanggan.orders.index') }}"
                           class="flex items-center gap-3 px-6 py-4 text-sm font-bold text-orange-600 bg-orange-50 border-l-4 border-orange-600">
                            Pesanan Saya
                            
                        </a>

                        <a href="{{ route('pelanggan.address.index') }}"
                           class="flex items-center gap-3 px-6 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-orange-600 border-l-4 border-transparent">
                            Alamat Pengiriman
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-100">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-6 py-4 text-sm font-medium text-red-600 hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="w-full lg:w-3/4">

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @php
                    $statuses = [
                        'pending'   => 'Pending',
                        'diproses'  => 'Diproses',
                        'dikirim'   => 'Dikirim',
                        'diterima'  => 'Diterima',
                        'selesai'   => 'Selesai',
                        'semua'     => 'Semua',
                    ];
                @endphp
                <div class="bg-gray-100 p-1 w-full border-b border-gray-200">
                    <div class="flex w-full">
                        @foreach($statuses as $key => $label)
                            @php
                                $count = $key === 'semua'
                                    ? $statusCounts->sum()
                                    : ($statusCounts[$key] ?? 0);
                            @endphp

                            <a href="{{ route('pelanggan.orders.index', ['status' => $key]) }}"
                            class="flex-1 text-center px-3 py-2 text-sm font-semibold rounded-lg transition
                            {{ $status === $key
                                    ? 'bg-orange-600 text-white shadow-sm'
                                    : 'bg-gray-100 text-orange-600 hover:bg-gray-200' }}">

                                {{ $label }}
                                <span class="text-xs font-bold">
                                    ({{ $count }})
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
                    <div class="bg-white">
                        <table class="w-full text-left text-gray-600">
                            <thead class="bg-gray-100 text-xs font-bold uppercase text-gray-500">
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
                                        <td class="px-6 py-4 font-mono font-bold text-orange-600">
                                            #{{ $order->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @include('pelanggan.orders.partials.status', ['status' => $order->status])
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('pelanggan.orders.show', $order->id) }}"
                                            class="text-blue-600 font-bold hover:underline text-sm">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                            Belum ada pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
