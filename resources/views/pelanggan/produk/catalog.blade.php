@extends('layouts.app')

@section('content')
<style>
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }

    .hide-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .form-checkbox:checked {
        background-color: #2c3e8c;
        border-color: #2c3e8c;
    }
</style>

<div class="bg-gray-50 min-h-screen pt-6 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ================= SIDEBAR FILTER (AKTIF) ================= --}}
            <aside class="w-full lg:w-1/4 flex-shrink-0 space-y-8">

                {{-- FORM FILTER --}}
                <form id="filterForm" action="{{ route('pelanggan.produk.all') }}" method="GET" autocomplete="off">

                    {{-- Search Hidden --}}
                    @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- 1. FILTER KATEGORI --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm mb-6">
                        <h3 class="font-bold text-gray-900 text-lg mb-4 border-b border-gray-100 pb-2">Kategori</h3>
                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">

                            {{-- PERBAIKAN: Menambahkan kembali @foreach --}}
                            @foreach($kategoris as $kategori)
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="cat-{{ $kategori->id }}"
                                        name="kategori[]"
                                        value="{{ $kategori->id }}"
                                        type="checkbox"
                                        onchange="filterProduk()"
                                        autocomplete="off"
                                        {{ in_array($kategori->id, request('kategori', [])) ? 'checked' : '' }}
                                        class="form-checkbox h-4 w-4 text-[#2c3e8c] border-gray-300 rounded focus:ring-[#2c3e8c] cursor-pointer">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="cat-{{ $kategori->id }}" class="font-medium text-gray-600 hover:text-[#2c3e8c] cursor-pointer transition select-none">
                                        {{ $kategori->nama }}
                                        <span class="text-gray-400 text-xs ml-1">
                                            ({{ $kategori->produk_count ?? 0 }})
                                        </span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            {{-- END PERBAIKAN --}}

                        </div>
                    </div>

                    {{-- 2. FILTER HARGA --}}
                    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-lg mb-4 border-b border-gray-100 pb-2">Harga</h3>
                        <div class="flex items-center space-x-2 mb-3">
                            <input type="text"
                                id="min_price"
                                name="min_price"
                                placeholder="Rp Min"
                                autocomplete="off"
                                value="{{ request('min_price') ? 'Rp ' . number_format(request('min_price'), 0, ',', '.') : '' }}"
                                class="rupiah-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-[#2c3e8c] focus:border-[#2c3e8c]">

                            <span class="text-gray-400">-</span>

                            <input type="text"
                                id="max_price"
                                name="max_price"
                                placeholder="Rp Max"
                                autocomplete="off"
                                value="{{ request('max_price') ? 'Rp ' . number_format(request('max_price'), 0, ',', '.') : '' }}"
                                class="rupiah-input w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-[#2c3e8c] focus:border-[#2c3e8c]">
                        </div>

                        <button type="button" onclick="filterProduk()" class="w-full mt-3 bg-[#2c3e8c] hover:bg-blue-900 text-white text-sm font-bold py-2 rounded-lg transition shadow-md">
                            Terapkan Filter
                        </button>
                    </div>

                </form>
            </aside>

            {{-- ================= MAIN CONTENT ================= --}}
            <div class="flex-1">
                <div class="mb-6 flex justify-between items-end">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Semua Produk</h1>
                        <p class="text-sm text-gray-500 mt-1">Menampilkan {{ $produks->total() }} produk</p>
                    </div>

                    {{-- Tombol Reset Filter --}}
                    @if(request('kategori') || request('min_price') || request('max_price'))
                    <a href="{{ route('pelanggan.produk.all') }}" class="text-sm text-red-500 hover:text-red-700 underline font-medium">
                        Hapus Filter
                    </a>
                    @endif
                </div>

                {{-- PRODUCT GRID --}}
                @if($produks->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($produks as $produk)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 relative group flex flex-col h-full">
                        <a href="{{ route('pelanggan.produk.show', $produk->id) }}" class="flex-1 flex flex-col">
                            <div class="relative w-full pt-[100%] bg-white rounded-t-xl overflow-hidden">
                                @if($produk->image)
                                <img src="{{ asset('storage/' . $produk->image) }}" alt="{{ $produk->nama }}"
                                    class="absolute inset-0 w-full h-full object-contain p-6 group-hover:scale-105 transition duration-500">
                                @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif

                                <div class="absolute bottom-3 left-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20 translate-y-2 group-hover:translate-y-0">
                                    <div class="flex-1">
                                        <button type="button" onclick="event.preventDefault(); document.getElementById('add-to-cart-{{ $produk->id }}').submit();" class="w-full bg-[#2c3e8c] text-white text-xs font-bold py-2 px-2 rounded-lg hover:bg-blue-800 flex items-center justify-center gap-1 shadow-md transition transform active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            +Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="text-sm text-gray-500 font-medium line-clamp-2 leading-tight mb-2 group-hover:text-[#2c3e8c] transition h-10">
                                    {{ $produk->nama }}
                                </h3>
                                <div class="mt-auto">
                                    <span class="text-[#2c3e8c] font-bold text-base">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <form id="add-to-cart-{{ $produk->id }}" action="{{ route('keranjang.store') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <input type="hidden" name="quantity" value="1">
                    </form>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $produks->withQueryString()->links() }}
                </div>
                @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16 text-center bg-white rounded-xl border border-dashed border-gray-300">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Produk tidak ditemukan</h3>
                    <p class="text-gray-500 text-sm max-w-xs mx-auto">Coba ubah filter kategori atau kata kunci pencarian Anda.</p>
                    <a href="{{ route('pelanggan.produk.all') }}" class="mt-4 px-4 py-2 bg-[#2c3e8c] text-white text-sm font-bold rounded-lg hover:bg-blue-800 transition">
                        Reset Filter
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.rupiah-input').forEach(input => {
            input.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value, 'Rp ');
            });
        });
    });

    function formatRupiah(angka, prefix) {
        if (!angka) return '';
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    function filterProduk() {
        const form = document.getElementById('filterForm');
        const url = new URL(form.action);
        const formData = new FormData(form);

        const rawMin = formData.get('min_price').replace(/[^0-9]/g, '');
        const rawMax = formData.get('max_price').replace(/[^0-9]/g, '');

        if (rawMin) formData.set('min_price', rawMin);
        else formData.delete('min_price');

        if (rawMax) formData.set('max_price', rawMax);
        else formData.delete('max_price');

        const params = new URLSearchParams(formData);
        const finalUrl = `${url.origin}${url.pathname}?${params.toString()}`;

        window.location.replace(finalUrl);
    }

    // Sync State saat back/forward
    window.addEventListener('pageshow', function(event) {
        const urlParams = new URLSearchParams(window.location.search);

        // Sync Checkbox
        const activeCategories = urlParams.getAll('kategori[]');
        document.querySelectorAll('input[name="kategori[]"]').forEach(checkbox => {
            checkbox.checked = activeCategories.includes(checkbox.value);
        });

        // Sync Min Price
        const minPrice = urlParams.get('min_price');
        const minInput = document.getElementById('min_price');
        if (minPrice) {
            minInput.value = formatRupiah(minPrice, 'Rp ');
        } else {
            minInput.value = '';
        }

        // Sync Max Price
        const maxPrice = urlParams.get('max_price');
        const maxInput = document.getElementById('max_price');
        if (maxPrice) {
            maxInput.value = formatRupiah(maxPrice, 'Rp ');
        } else {
            maxInput.value = '';
        }
    });
</script>
@endsection
