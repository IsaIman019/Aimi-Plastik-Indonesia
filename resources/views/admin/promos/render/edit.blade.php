<div id="editPromoModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <div class="relative inline-block bg-white rounded-2xl text-left shadow-xl sm:max-w-lg sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-500 text-white rounded-xl">✎</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Edit Promo</h2>
                        <p class="text-xs text-gray-500">Perbarui promo produk</p>
                    </div>
                </div>

                <button onclick="closeEditPromoModal()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>

            <!-- BODY -->
            <form id="editPromoForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <input type="hidden" id="edit_id" name="id">

                <!-- NAMA -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Promo *</label>
                    <input type="text" id="edit_nama" name="nama"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                </div>

                <!-- KODE -->
                <div>
                    <label class="block text-sm font-medium mb-1">Kode Promo *</label>
                    <input type="text" id="edit_kode" name="kode"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                </div>

                <!-- TIPE -->
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe *</label>
                    <select id="edit_tipe" name="tipe"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                        <option value="percent">Persen (%)</option>
                        <option value="fixed">Nominal (Rp)</option>
                    </select>
                </div>

                <!-- JUMLAH -->
                <div>
                    <label class="block text-sm font-medium mb-1">Nilai *</label>
                    <input type="number" id="edit_jumlah" name="jumlah"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                </div>

                <!-- PERIODE -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Mulai *</label>
                        <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai"
                            class="w-full px-3 py-2.5 border rounded-xl bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Selesai *</label>
                        <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai"
                            class="w-full px-3 py-2.5 border rounded-xl bg-gray-50">
                    </div>
                </div>

                <!-- ALL PRODUCT -->
                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_all_product" value="0">
                    <input type="checkbox" id="edit_is_all_product" name="is_all_product" value="1">
                    <label for="edit_is_all_product" class="text-sm">
                        Berlaku untuk semua produk
                    </label>
                </div>

                <!-- PRODUK -->
                <!-- PRODUK -->
                <div>
                    <label class="block text-sm font-medium mb-1">Pilih Produk</label>

                    <div id="editProdukCheckboxWrapper"
                        class="border rounded-xl bg-gray-50 p-3 space-y-2 max-h-40 overflow-y-auto">

                        @foreach ($produks as $produk)
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox"
                                    class="edit-produk-checkbox"
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
                    <select id="edit_status" name="status"
                        class="w-full px-4 py-2.5 border rounded-xl bg-gray-50">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeEditPromoModal()"
                        class="px-4 py-2 border rounded-xl text-sm">
                        Batal
                    </button>

                    <button type="submit" id="editPromoSubmitBtn"
                        class="px-5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl text-sm">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
window.PROMO_UPDATE_URL = "{{ route('admin.promos.update', ':id') }}";
</script>
<script src="{{ asset('assets/js/admin/promo/edit.js') }}" defer></script>
@endpush