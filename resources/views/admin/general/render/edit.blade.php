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
                    <label class="text-sm font-medium">Key</label>
                    <input id="edit_key" name="key"
                        class="w-full px-4 py-2 border rounded-xl bg-gray-100" readonly>
                </div>

                <!-- VALUE -->
                <div>
                    <label class="text-sm font-medium">Value</label>
                    <input id="edit_value" name="value"
                        class="w-full px-4 py-2 border rounded-xl">
                    <p id="edit_value-error" class="text-xs text-red-500 hidden"></p>
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label class="text-sm font-medium">Description</label>
                    <textarea id="edit_description" name="description"
                        class="w-full px-4 py-2 border rounded-xl"></textarea>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="text-sm font-medium">Status</label>
                    <select id="edit_status" name="status"
                        class="w-full px-4 py-2 border rounded-xl">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
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
