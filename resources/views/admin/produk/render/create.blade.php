<div id="createProdukModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen bg-black/50 px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-4xl sm:w-full">

            <!-- HEADER -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-500 text-white rounded-xl">
                        📦
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Tambah Produk</h2>
                        <p class="text-xs text-gray-500">Tambah produk baru ke katalog</p>
                    </div>
                </div>
                <button onclick="closeCreateProdukModal()" class="text-gray-400 hover:text-gray-600 transition">
                    ✕
                </button>
            </div>

            <!-- BODY -->
            <form id="createProdukForm" class="p-6 space-y-4" enctype="multipart/form-data">
                @csrf

                <!-- NAMA PRODUK -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="createNama" placeholder="Contoh: Plastik Kresek Besar"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <p class="mt-1 text-xs text-gray-500">
                        Nama produk maksimal 255 karakter
                    </p>
                    <p id="create_nama-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Kategori
                    </label>
                    <select name="kategori_id" id="createKategoriId"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    <p id="create_kategori_id-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- VARIAN -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Varian Produk <span class="text-red-500">*</span>
                    </label>
                    <select name="varian_id" id="createVarianId" class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
            text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
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
                    <p id="create_varian_id-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- HARGA -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="number" name="harga" id="createHarga" min="0" step="0.01" placeholder="0.00"
                            class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <p id="create_harga-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- STOK -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" id="createStok" min="0" value="0" placeholder="0"
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <p id="create_stok-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" id="createDeskripsi" rows="4" placeholder="Deskripsi detail produk..."
                        class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                            text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                    <p id="create_deskripsi-error" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <!-- GAMBAR -->
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Gambar Produk
                    </label>
                    <div class="mt-1">
                        <input type="file" name="image" id="createImage"
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                            class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Format: JPEG, PNG, JPG, GIF. Maksimal 2MB
                    </p>
                    <p id="create_image-error" class="text-xs text-red-500 mt-1 hidden"></p>

                    <!-- Image Preview -->
                    <div id="createImagePreview" class="mt-2 hidden">
                        <p class="text-sm text-gray-600 mb-1">Preview:</p>
                        <img id="createPreviewImage" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                </div>

                <!-- DIMENSI PRODUK -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Berat
                        </label>
                        <input type="text" name="berat" id="createBerat" placeholder="500gr"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Panjang
                        </label>
                        <input type="text" name="panjang" id="createPanjang" placeholder="30 cm"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Lebar
                        </label>
                        <input type="text" name="lebar" id="createLebar" placeholder="20 cm"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Tinggi
                        </label>
                        <input type="text" name="tinggi" id="createTinggi" placeholder="10 cm"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- STATUS & FEATURED -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="createStatus"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-300 rounded-xl
                                text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                        <p id="create_status-error" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">
                            Produk Unggulan
                        </label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_featured" id="createIsFeatured" value="1"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Tandai sebagai produk unggulan</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeCreateProdukModal()"
                        class="px-4 py-2 border border-gray-300 rounded-xl text-sm text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" id="createProdukSubmitBtn"
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
    window.PRODUK_STORE_URL = "{{ route('admin.produk.store') }}";
</script>
<script src="{{ asset('assets/js/admin/produk/create.js') }}" defer></script>
@endpush