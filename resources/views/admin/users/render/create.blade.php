<div id="createUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden">

                <!-- HEADER -->
                <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-500 text-white rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Tambah User</h2>
                            <p class="text-xs text-gray-500">Buat akun pengguna baru</p>
                        </div>
                    </div>
                    <button onclick="closeCreateUserModal()" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>

                <!-- BODY -->
                <form id="createUserForm" class="p-6 space-y-4">
                    @csrf

                    <!-- NAMA -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">👤</span>
                            <input type="text" name="nama" placeholder="Contoh: Budi Santoso" class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    text-gray-900 placeholder-gray-500
                                    focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                    transition duration-200 text-sm" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Nama lengkap pengguna</p>
                        <p id="create_nama-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">✉️</span>
                            <input type="email" name="email" placeholder="Contoh: user@email.com" class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    text-gray-900 placeholder-gray-500
                                    focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                    transition duration-200 text-sm" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Digunakan untuk login dan notifikasi</p>
                        <p id="create_email-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- NO HP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            No. HP
                        </label>
                        <input type="text" name="phone" placeholder="Contoh: 081234567890" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                text-gray-900 placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                transition duration-200 text-sm">
                        <p class="mt-1 text-xs text-gray-500">Nomor aktif yang bisa dihubungi (opsional)</p>
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                text-gray-900 placeholder-gray-500
                                focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                transition duration-200 text-sm" required>
                        <p class="mt-1 text-xs text-gray-500">Gunakan kombinasi huruf dan angka</p>
                        <p id="create_password-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- ROLE -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                transition duration-200 text-sm">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Pelanggan">Pelanggan</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Menentukan hak akses pengguna</p>
                        <p id="create_role-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="status" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500
                                transition duration-200 text-sm">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Nonaktifkan jika user tidak boleh login</p>
                    </div>


                    <!-- FOOTER -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeCreateUserModal()"
                            class="px-4 py-2 border border-gray-200 rounded-xl text-sm hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" id="createSubmitBtn"
                            class="px-5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl text-sm font-semibold hover:from-orange-600 hover:to-amber-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.USERS_STORE_URL = "{{ route('admin.users.store') }}";
</script>
<script src="{{ asset('assets/js/admin/users/create.js') }}" defer></script>
@endpush