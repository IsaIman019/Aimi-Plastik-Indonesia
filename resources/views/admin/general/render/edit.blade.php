<div id="editGeneralModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex justify-between">
                <h3 class="text-lg font-bold">Edit General</h3>
                <button onclick="closeEditGeneralModal()">✕</button>
            </div>

            <!-- BODY -->
            <form id="editGeneralForm" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id">

                <!-- KEY -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Key
                    </label>
                    <input
                        id="edit_key"
                        name="key"
                        readonly
                        class="block w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl
                            text-gray-600 cursor-not-allowed">
                    <p class="mt-1 text-xs text-gray-500">
                        Key tidak dapat diubah karena digunakan oleh sistem
                    </p>
                </div>

                <!-- VALUE -->
               <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Value <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="edit_value"
                        name="value"
                        placeholder="Masukkan nilai konfigurasi"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                            placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <p class="mt-1 text-xs text-gray-500">
                        Nilai yang akan digunakan oleh sistem
                    </p>
                    <div id="edit_value-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea
                        id="edit_description"
                        name="description"
                        rows="3"
                        placeholder="Penjelasan singkat mengenai konfigurasi ini..."
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                            placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Opsional, untuk membantu admin memahami fungsi konfigurasi
                    </p>
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
                    <p class="mt-1 text-xs text-gray-500">
                        Nonaktifkan jika konfigurasi tidak ingin digunakan sementara
                    </p>
                    <div id="edit_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeEditGeneralModal()">Batal</button>
                    <button id="editGeneralSubmitBtn" type="submit"
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
    window.GENERAL_UPDATE_URL = "{{ route('admin.general.update', ':id') }}";
</script>
<script src="{{ asset('assets/js/admin/general/edit.js') }}" defer></script>
@endpush
