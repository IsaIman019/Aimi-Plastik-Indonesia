<div id="createKategoriModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-lg sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-500 text-white rounded-xl">
                        🏷️
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Tambah Kategori</h2>
                        <p class="text-xs text-gray-500">Tambah kategori produk</p>
                    </div>
                </div>
                <button onclick="closeCreateKategoriModal()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <form id="createKategoriForm" class="p-6 space-y-4">
                @csrf

                <!-- NAMA -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama"
                        placeholder="Contoh: Lakban, Bubble Wrap, Dus Karton, dll."
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <p class="mt-1 text-xs text-gray-500">
                        Nama kategori yang akan ditampilkan
                    </p>
                    <p id="create_nama-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea
                        name="deskripsi"
                        rows="3"
                        placeholder="Deskripsi singkat kategori produk..."
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Opsional, untuk menjelaskan kategori
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
                        Kategori hanya digunakan jika status ACTIVE
                    </p>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeCreateKategoriModal()"
                        class="px-4 py-2 border rounded-xl text-sm">
                        Batal
                    </button>
                    <button type="submit" id="createKategoriSubmitBtn"
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
    window.KATEGORI_STORE_URL = "{{ route('admin.kategori.store') }}";
</script>
<script src="{{ asset('assets/js/admin/kategori/create.js') }}" defer></script>
@endpush
