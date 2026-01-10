<div id="createUserModal" class="fixed inset-0 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

            <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden">

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
                        <label class="text-sm font-medium text-gray-700">Nama</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">👤</span>
                            <input type="text" name="nama"
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm">
                        </div>
                        <p id="create_nama-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">✉️</span>
                            <input type="email" name="email"
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm">
                        </div>
                        <p id="create_email-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- PHONE -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">No HP</label>
                        <input type="text" name="phone"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm">
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm">
                        <p id="create_password-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- ROLE -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">Role</label>
                        <select name="role"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Pelanggan">Pelanggan</option>
                        </select>
                        <p id="create_role-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label class="text-sm font-medium text-gray-700">Status</label>
                        <select name="status"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
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
