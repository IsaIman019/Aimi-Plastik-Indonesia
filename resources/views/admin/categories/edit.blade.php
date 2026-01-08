<!-- resources/views/admin/categories/edit.blade.php -->
<div id="editCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div
            class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Modal header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-amber-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Edit Kategori</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola informasi kategori produk</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeEditModal()"
                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal body -->
            <form id="editCategoryForm" class="bg-white">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="px-6 py-5 space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                            </div>
                            <input type="text" id="edit_nama" name="nama"
                                class="block w-full pl-10 pr-3 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                placeholder="Contoh: Lakban, Bubble Wrap, dll." required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Nama yang akan ditampilkan pada produk</p>
                        <div id="edit_nama-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="edit_deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <div class="relative">
                            <textarea id="edit_deskripsi" name="deskripsi" rows="4"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 resize-none"
                                placeholder="Deskripsi singkat tentang kategori ini..."></textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400" id="edit_charCount">0/500</div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Penjelasan singkat tentang kategori (opsional)</p>
                        <div id="edit_deskripsi-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="edit_status" name="status"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 appearance-none">
                                <option value="" disabled>Pilih Status</option>
                                <option value="ACTIVE">ACTIVE - Tampilkan di website</option>
                                <option value="INACTIVE">INACTIVE - Sembunyikan di website</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Tentukan visibilitas kategori</p>
                        <div id="edit_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 sm:flex-none px-5 py-3 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-xl font-medium transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit" id="edit_submitBtn"
                            class="flex-1 sm:flex-none px-5 py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center gap-2" id="edit_submitBtnText">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
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

<script>
    // EDIT MODAL FUNCTIONS
    function initEditModal() {
        // Character counter
        const editDeskripsi = document.getElementById('edit_deskripsi');
        const editCharCount = document.getElementById('edit_charCount');

        if (editDeskripsi && editCharCount) {
            editDeskripsi.addEventListener('input', function() {
                const maxLength = 500;
                const currentLength = this.value.length;

                editCharCount.textContent = `${currentLength}/${maxLength}`;

                // Update color
                editCharCount.className = 'absolute bottom-3 right-3 text-xs';
                if (currentLength > maxLength) {
                    editCharCount.classList.add('text-red-500');
                } else if (currentLength > maxLength * 0.8) {
                    editCharCount.classList.add('text-orange-500');
                } else {
                    editCharCount.classList.add('text-gray-400');
                }
            });
        }

        // Form submission - SESUAI DENGAN ROUTE RESOURCE
        const editForm = document.getElementById('editCategoryForm');
        const editSubmitBtn = document.getElementById('edit_submitBtn');
        const editSubmitBtnText = document.getElementById('edit_submitBtnText');

        if (editForm) {
            editForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const categoryId = document.getElementById('edit_id').value;
                if (!categoryId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'ID kategori tidak ditemukan',
                        timer: 3000
                    });
                    return;
                }

                // Reset errors
                document.querySelectorAll('[id^="edit_"][id$="-error"]').forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });

                // Show loading
                const originalHtml = editSubmitBtnText.innerHTML;
                editSubmitBtnText.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                    <span>Menyimpan...</span>
                </div>
            `;
                editSubmitBtn.disabled = true;

                try {
                    const formData = new FormData(this);

                    // Route::resource menggunakan PUT untuk update
                    // URL: /admin/categories/{id}
                    const response = await axios.post(`/admin/categories/${categoryId}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    });

                    // Reset button
                    editSubmitBtnText.innerHTML = originalHtml;
                    editSubmitBtn.disabled = false;

                    // Show success
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.data.message || 'Kategori berhasil diperbarui',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    }).then(() => {
                        // Close modal
                        closeEditModal();

                        // Reload table
                        if (window.reloadCategoriesTable) {
                            window.reloadCategoriesTable();
                        }
                    });

                } catch (error) {
                    console.error('Error updating category:', error);

                    // Reset button
                    editSubmitBtnText.innerHTML = originalHtml;
                    editSubmitBtn.disabled = false;

                    if (error.response?.status === 422) {
                        // Validation errors
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach(field => {
                            const errorElement = document.getElementById(`edit_${field}-error`);
                            const inputElement = document.getElementById(`edit_${field}`);

                            if (errorElement) {
                                errorElement.textContent = errors[field][0];
                                errorElement.classList.remove('hidden');
                            }

                            if (inputElement) {
                                inputElement.classList.add('border-red-500');
                                inputElement.classList.remove('border-gray-300');
                            }
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Harap periksa data yang dimasukkan',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response?.data?.message || 'Gagal memperbarui kategori',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                }
            });
        }

        // Reset input borders on focus
        editForm?.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            });
        });
    }

    // Global functions for edit modal
    window.openEditModal = function(categoryData) {
        if (!categoryData || !categoryData.id) {
            console.error('No category data provided:', categoryData);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Data kategori tidak valid',
                timer: 3000
            });
            return;
        }

        console.log('Opening edit modal with data:', categoryData);

        const modal = document.getElementById('editCategoryModal');
        const form = document.getElementById('editCategoryForm');

        if (!modal || !form) {
            console.error('Modal elements not found!');
            return;
        }

        // Fill form with data
        document.getElementById('edit_id').value = categoryData.id;
        document.getElementById('edit_nama').value = categoryData.nama || '';
        document.getElementById('edit_deskripsi').value = categoryData.deskripsi || '';

        // Set status - pastikan ada nilai default
        const statusSelect = document.getElementById('edit_status');
        if (statusSelect) {
            statusSelect.value = categoryData.status || 'ACTIVE';
        }

        // Reset errors
        document.querySelectorAll('[id^="edit_"][id$="-error"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });

        // Update character counter
        const editDeskripsi = document.getElementById('edit_deskripsi');
        const editCharCount = document.getElementById('edit_charCount');
        if (editDeskripsi && editCharCount) {
            editDeskripsi.dispatchEvent(new Event('input'));
        }

        // Reset input borders
        form.querySelectorAll('input, textarea, select').forEach(input => {
            input.classList.remove('border-red-500');
            input.classList.add('border-gray-300');
        });

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Focus on first input
        setTimeout(() => {
            const namaInput = document.getElementById('edit_nama');
            if (namaInput) namaInput.focus();
        }, 100);
    };

    window.closeEditModal = function() {
        const modal = document.getElementById('editCategoryModal');
        const submitBtn = document.getElementById('edit_submitBtn');
        const submitBtnText = document.getElementById('edit_submitBtnText');

        // Reset button if loading
        if (submitBtn && submitBtn.disabled) {
            submitBtn.disabled = false;
            if (submitBtnText) {
                submitBtnText.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </span>
            `;
            }
        }

        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    };

    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        initEditModal();

        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('editCategoryModal').classList.contains(
                    'hidden')) {
                closeEditModal();
            }
        });

        // Close on background click
        const modal = document.getElementById('editCategoryModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });
        }
    });
</script>