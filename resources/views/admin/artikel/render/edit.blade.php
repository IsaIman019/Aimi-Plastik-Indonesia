<div id="editNewsModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex justify-between">
                <h3 class="text-lg font-bold">Edit News</h3>
                <button onclick="closeEditNewsModal()">✕</button>
            </div>

            <!-- BODY -->
            <form id="editNewsForm" class="p-6 space-y-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <!-- JUDUL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit_judul" name="judul" placeholder="Masukkan judul berita"
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                            placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">
                        Judul berita maksimal 100 karakter
                    </p>
                    <div id="edit_judul-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="edit_kategori_id" name="kategori_id" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                    <div id="edit_kategori_id-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- GAMBAR -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar <span class="text-gray-400">(Opsional)</span>
                    </label>

                    <!-- Current Image -->
                    <div id="editCurrentImage" class="mb-3">
                        <!-- Gambar saat ini akan dimuat via JavaScript -->
                    </div>

                    <!-- New Image Input -->
                    <div class="mt-2">
                        <input type="file" id="edit_gambar" name="gambar"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB
                    </p>
                    <div id="edit_gambar-error" class="mt-1 text-sm text-red-600 hidden"></div>

                    <!-- New Image Preview -->
                    <div id="editImagePreview" class="mt-3 hidden">
                        <p class="text-sm text-gray-600 mb-2">Preview Gambar Baru:</p>
                        <div class="relative inline-block">
                            <img id="editPreviewImage" class="w-40 h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" onclick="removeEditImagePreview()"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KONTEN -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea id="edit_konten" name="konten" rows="5" placeholder="Tulis isi berita di sini..."
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                            placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Konten maksimal 1000 karakter
                    </p>
                    <div id="edit_konten-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- STATUS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="edit_status" name="status" class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="DRAFT">DRAFT</option>
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="INACTIVE">INACTIVE</option>
                    </select>
                    <div id="edit_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeEditNewsModal()">Batal</button>
                    <button id="editNewsSubmitBtn" type="submit" class="px-5 py-2 bg-orange-500 text-white rounded-xl">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.NEWS_UPDATE_URL = "{{ route('admin.news.update', ':id') }}";
</script>
<script src="{{ asset('assets/js/admin/news/edit.js') }}" defer></script>
@endpush