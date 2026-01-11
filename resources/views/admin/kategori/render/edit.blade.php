<div id="editKategoriModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl
                   transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex justify-between">
                <h3 class="text-lg font-bold">Edit Kategori</h3>
                <button onclick="closeEditKategoriModal()">✕</button>
            </div>

            <!-- BODY -->
            <form id="editKategoriForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <input type="hidden" id="edit_id" name="id">

                <!-- NAMA -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="edit_nama"
                        name="nama"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                               placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Masukkan nama kategori">
                    <div id="edit_nama-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea
                        id="edit_deskripsi"
                        name="deskripsi"
                        rows="3"
                        placeholder="Deskripsi singkat kategori..."
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                               placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="edit_status"
                        name="status"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                               focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                    <div id="edit_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeEditKategoriModal()">Batal</button>
                    <button id="editKategoriSubmitBtn" type="submit"
                        class="px-5 py-2 bg-orange-500 text-white rounded-xl">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.KATEGORI_UPDATE_URL = "{{ route('admin.kategori.update', ':id') }}";
</script>
<script src="{{ asset('assets/js/admin/kategori/edit.js') }}" defer></script>
@endpush
