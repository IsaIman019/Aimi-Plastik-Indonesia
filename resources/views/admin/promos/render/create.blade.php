<div id="createPromoModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <div
            class="relative inline-block bg-white rounded-2xl text-left shadow-xl sm:max-w-lg sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-500 text-white rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Tambah Promo</h2>
                        <p class="text-xs text-gray-500">Buat promo atau diskon produk</p>
                    </div>
                </div>

                <button onclick="closeCreatePromoModal()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <form id="createPromoForm" class="p-6 space-y-4">
                @csrf

                <!-- NAMA -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Promo *</label>
                    <input type="text" name="nama"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                    <p id="create_nama-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- KODE -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Promo *</label>
                    <input type="text" name="kode"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                    <p id="create_kode-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- TIPE -->
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe *</label>
                    <select name="tipe" class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                        <option value="">Pilih Tipe</option>
                        <option value="percent">Persen (%)</option>
                        <option value="fixed">Nominal (Rp)</option>
                    </select>
                    <p id="create_tipe-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- JUMLAH -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nilai *</label>
                    <input type="number" name="jumlah"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                    <p id="create_jumlah-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- PERIODE -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Mulai *</label>
                        <input type="date" name="tanggal_mulai"
                            class="w-full px-3 py-2.5 border rounded-xl bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Selesai *</label>
                        <input type="date" name="tanggal_selesai"
                            class="w-full px-3 py-2.5 border rounded-xl bg-gray-50">
                    </div>
                </div>

                <!-- ALL PRODUCT -->
                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_all_product" value="0">
                    <input type="checkbox" id="isAllProduct" name="is_all_product" value="1">
                    <label for="isAllProduct" class="text-sm">
                        Berlaku untuk semua produk
                    </label>
                </div>

                <!-- PRODUK -->
                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Produk</label>

                    <div id="produkCheckboxWrapper"
                        class="border rounded-xl bg-gray-50 p-3 space-y-2 max-h-40 overflow-y-auto">

                        @foreach ($produks as $produk)
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox"
                                    class="produk-checkbox"
                                    name="produk_ids[]"
                                    value="{{ $produk->id }}">
                                {{ $produk->nama }}
                            </label>
                        @endforeach
                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Abaikan jika promo untuk semua produk
                    </p>
                </div>


                <!-- STATUS -->
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        onclick="closeCreatePromoModal()"
                        class="px-4 py-2 border rounded-xl text-sm">
                        Batal
                    </button>

                    <button type="submit" id="createPromoSubmitBtn"
                        class="px-5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.PROMO_STORE_URL = "{{ route('admin.promos.store') }}";
</script>
<script src="{{ asset('assets/js/admin/promo/create.js') }}" defer></script>
@endpush
