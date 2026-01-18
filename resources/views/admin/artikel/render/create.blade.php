<div id="createNewsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-2xl sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-500 text-white rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Tambah News</h2>
                        <p class="text-xs text-gray-500">Tambah berita atau artikel baru</p>
                    </div>
                </div>
                <button onclick="closeCreateNewsModal()" class="text-gray-400 hover:text-gray-600 transition">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <form id="createNewsForm" class="p-6 space-y-4" enctype="multipart/form-data">
                @csrf

                <!-- JUDUL -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" id="createJudul"
                        placeholder="Contoh: Tips Packaging untuk Produk Makanan"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <p class="mt-1 text-xs text-gray-500">
                        Judul berita maksimal 100 karakter
                    </p>
                    <p id="create_judul-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_id" id="createKategoriId"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                    <p id="create_kategori_id-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- GAMBAR -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Gambar
                    </label>
                    <div class="mt-1">
                        <input type="file" name="gambar" id="createGambar" accept="image/jpeg,image/png,image/jpg"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Format: JPEG, PNG, JPG. Maksimal 2MB
                    </p>
                    <p id="create_gambar-error" class="text-xs text-red-500 mt-1 hidden"></p>

                    <!-- Image Preview -->
                    <div id="createImagePreview" class="mt-2 hidden">
                        <p class="text-sm text-gray-600 mb-1">Preview:</p>
                        <img id="createPreviewImage" class="w-32 h-20 object-cover rounded-lg border border-gray-200">
                    </div>
                </div>

                <!-- KONTEN -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea name="konten" id="createKonten" rows="5" placeholder="Tulis isi berita di sini..."
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Konten maksimal 255 karakter
                    </p>
                    <p id="create_konten-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="createStatus"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="DRAFT">DRAFT</option>
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                    <p id="create_status-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeCreateNewsModal()" class="px-4 py-2 border rounded-xl text-sm">
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
window.NEWS_STORE_URL = "{{ route('admin.artikel.store') }}";
</script>
<script src="{{ asset('assets/js/admin/artikel/create.js') }}" defer></script>
@endpush
