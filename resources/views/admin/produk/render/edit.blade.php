<div id="editProdukModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-black/10 backdrop-blur-sm"></div>

        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-500 text-white rounded-xl">
                        📦
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Edit Produk</h3>
                        <p class="text-xs text-gray-500">Perbarui informasi produk</p>
                    </div>
                </div>
                <button onclick="closeEditProdukModal()" class="text-gray-400 hover:text-gray-600 transition text-lg">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <form id="editProdukForm" class="p-6 space-y-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- NAMA PRODUK -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_nama" name="nama" placeholder="Masukkan nama produk"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <div id="edit_nama-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- KATEGORI -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori
                            </label>
                            <select id="edit_kategori_id" name="kategori_id"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                            <div id="edit_kategori_id-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- VARIAN -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Varian Produk <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_varian_id" name="varian_id"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Pilih Varian</option>
                                @foreach($varians as $varian)
                                <option value="{{ $varian->id }}">
                                    {{ $varian->nama }}
                                    @if($varian->description)
                                    - {{ $varian->description }}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <div id="edit_varian_id-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- HARGA -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                                <input type="text" id="edit_harga" name="harga" placeholder="0"
                                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div id="edit_harga-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- STOK -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="edit_stok" name="stok" min="0" placeholder="0"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <div id="edit_stok-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- STATUS & FEATURED -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="edit_status" name="status"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="INACTIVE">INACTIVE</option>
                                </select>
                                <div id="edit_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Produk Unggulan
                                </label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="edit_is_featured" name="is_featured" value="1"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Produk Unggulan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- DESKRIPSI -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="edit_deskripsi" name="deskripsi" rows="4"
                                placeholder="Deskripsi detail produk..."
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                    placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                            <div id="edit_deskripsi-error" class="mt-1 text-sm text-red-600 hidden"></div>
                        </div>

                        <!-- GAMBAR -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk <span class="text-gray-400">(Opsional)</span>
                            </label>

                            <!-- Current Image -->
                            <div id="editCurrentImage" class="mb-3">
                                <!-- Gambar saat ini akan dimuat via JavaScript -->
                            </div>

                            <!-- New Image Input -->
                            <div class="mt-2">
                                <input type="file" id="edit_image" name="image"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                        file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB
                            </p>
                            <div id="edit_image-error" class="mt-1 text-sm text-red-600 hidden"></div>

                            <!-- New Image Preview -->
                            <div id="editImagePreview" class="mt-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">Preview Gambar Baru:</p>
                                <div class="relative inline-block">
                                    <img id="editPreviewImage"
                                        class="w-40 h-40 object-cover rounded-lg border border-gray-200">
                                    <button type="button" onclick="removeEditImagePreview()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ✕
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- DIMENSI PRODUK -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Berat
                                </label>
                                <input type="text" id="edit_berat" name="berat" placeholder="500gr"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Panjang
                                </label>
                                <input type="text" id="edit_panjang" name="panjang" placeholder="30 cm"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Lebar
                                </label>
                                <input type="text" id="edit_lebar" name="lebar" placeholder="20 cm"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tinggi
                                </label>
                                <input type="text" id="edit_tinggi" name="tinggi" placeholder="10 cm"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                                        placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeEditProdukModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button id="editProdukSubmitBtn" type="submit"
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
window.PRODUK_UPDATE_URL = "{{ route('admin.produk.update', ':id') }}";
</script>
<script src="{{ asset('assets/js/admin/produk/edit.js') }}" defer></script>
@endpush
