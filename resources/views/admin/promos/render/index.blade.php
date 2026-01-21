@extends('admin.promos.wrapper')

@section('render')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto h-screen">
        <!-- Header -->
        <div class="mb-6 lg:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Promo & Diskon</h1>
                    <p class="text-gray-500 text-sm md:text-base mt-1">
                        Kelola promo dan diskon produk.
                    </p>
                </div>

                <button type="button" onclick="openCreateModal()"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-amber-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Promo
                </button>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" id="searchInput"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg"
                            placeholder="Cari nama atau kode promo...">
                    </div>
                </div>

                <select id="statusFilter"
                    class="border rounded-lg px-4 py-2.5 bg-gray-50 border-gray-300">
                    <option value="">Semua Status</option>
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                </select>

                <button onclick="resetFilters()"
                    class="px-4 py-2.5 bg-red-100 hover:bg-red-300 border rounded-lg">
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="promoTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium">NO</th>
                            <th class="px-4 py-3 text-xs font-medium">NAMA PROMO</th>
                            <th class="px-4 py-3 text-xs font-medium">KODE</th>
                            <th class="px-4 py-3 text-xs font-medium">TIPE</th>
                            <th class="px-4 py-3 text-xs font-medium">NILAI</th>
                            <th class="px-4 py-3 text-xs font-medium">PERIODE</th>
                            <th class="px-4 py-3 text-xs font-medium">STATUS</th>
                            <th class="px-4 py-3 text-xs font-medium text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.promos.render.create')
@include('admin.promos.render.edit')
@push('scripts')
<script>
    window.PROMO_INDEX_URL = "{{ route('admin.promos.index') }}";
    window.PROMO_EDIT_URL   = "{{ url('admin/promo') }}";
    window.PROMO_DELETE_URL = "{{ url('admin/promo') }}";
</script>
<script src="{{ asset('assets/js/admin/promo/index.js') }}" defer></script>
@endpush
@endsection
