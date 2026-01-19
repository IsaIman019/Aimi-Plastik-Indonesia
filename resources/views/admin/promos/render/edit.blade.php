<div id="editUserModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <!-- Modal panel -->
            <div
                class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <!-- HEADER -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-amber-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Edit User</h3>
                                <p class="text-sm text-gray-500 mt-0.5">Perbarui informasi pengguna</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeEditUserModal()"
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- BODY -->
                <form id="editUserForm" class="bg-white">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id">

                    <div class="px-6 py-5 space-y-6">

                        <!-- NAMA -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input id="edit_nama" name="nama"
                                placeholder="Contoh: Budi Santoso"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <p class="mt-1 text-xs text-gray-500">Nama lengkap pengguna</p>
                            <div id="edit_nama-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input id="edit_email" name="email"
                                placeholder="user@email.com"
                                class="block w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl text-gray-500"
                                readonly>
                            <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah</p>
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                            <input id="edit_phone" name="phone"
                                placeholder="08xxxxxxxxxx"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <p class="mt-1 text-xs text-gray-500">Nomor yang dapat dihubungi</p>
                            <div id="edit_phone-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password (Opsional)
                            </label>
                            <input id="edit_password" name="password" type="password"
                                placeholder="Kosongkan jika tidak diubah"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <p class="text-xs text-gray-500 mt-1">
                                Isi hanya jika ingin mengganti password
                            </p>
                            <div id="edit_password-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- ROLE -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_role" name="role"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="" disabled>Pilih Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Pelanggan">Pelanggan</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Tentukan hak akses pengguna</p>
                            <div id="edit_role-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- STATUS -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_status" name="status"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="" disabled>Pilih Status</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Status akun pengguna</p>
                            <div id="edit_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="button" onclick="closeEditUserModal()"
                                class="flex-1 sm:flex-none px-5 py-3 border border-gray-300 rounded-xl bg-white text-gray-700 hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" id="editUserSubmitBtn"
                                class="flex-1 sm:flex-none px-5 py-3 bg-gradient-to-r from-orange-600 to-amber-600 text-white rounded-xl font-semibold hover:from-orange-700 hover:to-amber-700">
                                <span id="editUserSubmitText" class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Perubahan
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
    </div>
</div>
@push('scripts')
<script>
    window.USERS_UPDATE_URL = "{{ route('admin.users.update', ':id') }}";
</script>
<script src="{{ asset('assets/js/admin/users/edit.js') }}" defer></script>
@endpush
