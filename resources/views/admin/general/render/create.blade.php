<div id="createGeneralModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-lg sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-500 text-white rounded-xl">
                        ⚙️
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Tambah General</h2>
                        <p class="text-xs text-gray-500">Tambah konfigurasi sistem</p>
                    </div>
                </div>
                <button onclick="closeCreateGeneralModal()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <form id="createGeneralForm" class="p-6 space-y-4">
                @csrf

                <!-- KEY -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Key <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="key"
                        placeholder="Contoh: SITE_NAME, MAX_UPLOAD_SIZE"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <p class="mt-1 text-xs text-gray-500">
                        Identifier unik untuk konfigurasi (gunakan huruf besar & underscore)
                    </p>
                    <p id="create_key-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>


                <!-- VALUE -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Value <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="value"
                        placeholder="Contoh: Aimi Packaging"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <p class="mt-1 text-xs text-gray-500">
                        Nilai yang digunakan oleh sistem
                    </p>
                    <p id="create_value-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>


                <!-- DESCRIPTION -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Penjelasan singkat mengenai fungsi konfigurasi ini..."
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Opsional, untuk memudahkan admin lain memahami fungsinya
                    </p>
                </div>


                <!-- STATUS -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">
                        Konfigurasi hanya digunakan jika status ACTIVE
                    </p>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeCreateGeneralModal()"
                        class="px-4 py-2 border rounded-xl text-sm">
                        Batal
                    </button>
                    <button type="submit" id="createGeneralSubmitBtn"
                        class="px-5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl text-sm font-semibold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.GENERAL_STORE_URL = "{{ route('admin.general.store') }}";
</script>
<script src="{{ asset('assets/js/admin/general/create.js') }}" defer></script>
@endpush
