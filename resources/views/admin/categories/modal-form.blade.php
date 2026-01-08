<!-- Category Modal -->
<div id="categoryModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-4 w-full max-w-md">
        <div class="relative bg-white rounded-2xl shadow-lg">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-900"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="categoryId" name="id">

                <div class="p-6 space-y-4">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            placeholder="Contoh: Lakban, Bubble Wrap, etc." required>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            placeholder="Deskripsi singkat tentang kategori..."></textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition appearance-none">
                            <option value="">Pilih Status</option>
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                        </select>
                    </div>

                    <!-- Warna Kategori (Opsional) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Warna Kategori (Opsional)
                        </label>
                        <div class="flex gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="color" value="#f59e0b" class="sr-only peer">
                                <div
                                    class="w-8 h-8 rounded-lg bg-orange-100 peer-checked:ring-2 peer-checked:ring-orange-500">
                                </div>
                                <span class="text-sm text-gray-600">Orange</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="color" value="#3b82f6" class="sr-only peer">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-100 peer-checked:ring-2 peer-checked:ring-blue-500">
                                </div>
                                <span class="text-sm text-gray-600">Blue</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="color" value="#10b981" class="sr-only peer">
                                <div
                                    class="w-8 h-8 rounded-lg bg-green-100 peer-checked:ring-2 peer-checked:ring-green-500">
                                </div>
                                <span class="text-sm text-gray-600">Green</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="color" value="#8b5cf6" class="sr-only peer">
                                <div
                                    class="w-8 h-8 rounded-lg bg-purple-100 peer-checked:ring-2 peer-checked:ring-purple-500">
                                </div>
                                <span class="text-sm text-gray-600">Purple</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 border-t border-gray-100 gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-orange-600 text-white hover:bg-orange-700 rounded-xl font-medium transition shadow-lg shadow-orange-200">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>