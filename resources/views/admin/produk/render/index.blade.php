@extends('admin.produk.wrapper')

@section('render')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto h-screen">

        <!-- Header -->
        <div class="mb-6 lg:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manajemen Produk</h1>
                    <p class="text-gray-500 text-sm md:text-base mt-1">
                        Kelola data produk kemasan.
                    </p>
                </div>

                <button type="button" onclick="openCreateModal()"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-amber-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Produk
                </button>
            </div>
        </div>
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('
                    success ') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
        @endif
        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('
                    error ') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
        @endif
        <!-- Filter & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">

                <!-- SEARCH -->
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="searchInput"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg"
                            placeholder="Cari nama produk ...">
                    </div>
                </div>

                <!-- KATEGORI -->
                <div class="flex flex-col">
                    <select id="kategoriFilter"
                        class="border rounded-lg px-4 py-2.5 bg-gray-50 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- STATUS -->
                <select id="statusFilter" class="border rounded-lg px-4 py-2.5 bg-gray-50 border-gray-300">
                    <option value="">Semua Status</option>
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                </select>

                <button onclick="resetFilters()"
                    class="px-4 py-2.5 text-gray-700 bg-red-100 hover:bg-red-300 border border-gray-300 rounded-lg">
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-4 py-3 border-b border-gray-200 flex justify-between">
                <div>
                    <label class="flex items-center gap-2 text-sm">
                        <span>Tampilkan</span>
                        <select id="pageLength" class="border border-gray-300 rounded-md px-2 py-1">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span>data</span>
                    </label>
                </div>
                <div class="text-sm text-gray-500" id="tableInfoTop">
                    Total: <span class="font-semibold">0</span> data
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="produkTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium">NO</th>
                            <th class="px-4 py-3 text-xs font-medium">PRODUK</th>
                            <th class="px-4 py-3 text-xs font-medium">KATEGORI</th>
                            <th class="px-4 py-3 text-xs font-medium">HARGA</th>
                            <th class="px-4 py-3 text-xs font-medium">STOK</th>
                            <th class="px-4 py-3 text-xs font-medium">STATUS</th>
                            <th class="px-4 py-3 text-xs font-medium text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200"></tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="text-sm text-gray-700" id="tableInfo">
                        Menampilkan <span class="font-semibold">0</span> sampai <span class="font-semibold">0</span>
                        dari <span class="font-semibold">0</span> data
                    </div>
                    <div class="flex items-center space-x-1" id="paginationContainer">
                        <!-- Pagination akan diisi manual -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('admin.produk.render.create')
@include('admin.produk.render.edit')
@push('scripts')
<script>
    window.PRODUK_INDEX_URL = "{{ route('admin.produk.index') }}";
</script>
<script src="{{ asset('assets/js/admin/produk/index.js') }}" defer></script>
@endpush
@endsection