<!-- resources/views/admin/categories/create.blade.php -->
<div id="createCategoryModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
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
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Tambah Kategori Baru</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Kelola informasi kategori produk</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeCreateModal()"
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
            <form id="createCategoryForm" class="bg-white">
                @csrf

                <div class="px-6 py-5 space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="create_nama" class="block text-sm font-medium text-gray-700 mb-2">
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
                            <input type="text" id="create_nama" name="nama"
                                class="block w-full pl-10 pr-3 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                placeholder="Contoh: Lakban, Bubble Wrap, dll." required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Nama yang akan ditampilkan pada produk</p>
                        <div id="create_nama-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="create_deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <div class="relative">
                            <textarea id="create_deskripsi" name="deskripsi" rows="4"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 resize-none"
                                placeholder="Deskripsi singkat tentang kategori ini..."></textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400" id="create_charCount">0/500
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Penjelasan singkat tentang kategori (opsional)</p>
                        <div id="create_deskripsi-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="create_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="create_status" name="status"
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 appearance-none">
                                <option value="" disabled selected>Pilih Status</option>
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
                        <div id="create_status-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="closeCreateModal()"
                            class="flex-1 sm:flex-none px-5 py-3 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-xl font-medium transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit" id="create_submitBtn"
                            class="flex-1 sm:flex-none px-5 py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center gap-2" id="create_submitBtnText">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Kategori
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // CREATE MODAL FUNCTIONS
    function initCreateModal() {
        // Character counter
        const createDeskripsi = document.getElementById('create_deskripsi');
        const createCharCount = document.getElementById('create_charCount');

        if (createDeskripsi && createCharCount) {
            createDeskripsi.addEventListener('input', function() {
                const maxLength = 500;
                const currentLength = this.value.length;

                createCharCount.textContent = `${currentLength}/${maxLength}`;

                // Update color
                createCharCount.className = 'absolute bottom-3 right-3 text-xs';
                if (currentLength > maxLength) {
                    createCharCount.classList.add('text-red-500');
                } else if (currentLength > maxLength * 0.8) {
                    createCharCount.classList.add('text-orange-500');
                } else {
                    createCharCount.classList.add('text-gray-400');
                }
            });
        }

        // Form submission
        const createForm = document.getElementById('createCategoryForm');
        const createSubmitBtn = document.getElementById('create_submitBtn');
        const createSubmitBtnText = document.getElementById('create_submitBtnText');

        if (createForm) {
            createForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Reset errors
                document.querySelectorAll('[id^="create_"][id$="-error"]').forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });

                // Show loading
                const originalHtml = createSubmitBtnText.innerHTML;
                createSubmitBtnText.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                    <span>Menambahkan...</span>
                </div>
            `;
                createSubmitBtn.disabled = true;

                try {
                    const formData = new FormData(this);

                    // Send request
                    const response = await axios.post('/admin/categories', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });

                    // Reset button
                    createSubmitBtnText.innerHTML = originalHtml;
                    createSubmitBtn.disabled = false;

                    // Show success
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.data.message || 'Kategori berhasil ditambahkan',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    }).then(() => {
                        // Close modal
                        closeCreateModal();

                        // Reload table
                        if (window.reloadCategoriesTable) {
                            window.reloadCategoriesTable();
                        }
                    });

                } catch (error) {
                    // Reset button
                    createSubmitBtnText.innerHTML = originalHtml;
                    createSubmitBtn.disabled = false;

                    if (error.response?.status === 422) {
                        // Validation errors
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach(field => {
                            const errorElement = document.getElementById(`create_${field}-error`);
                            const inputElement = document.getElementById(`create_${field}`);

                            if (errorElement) {
                                errorElement.textContent = errors[field][0];
                                errorElement.classList.remove('hidden');
                            }

                            if (inputElement) {
                                inputElement.classList.add('border-red-500');
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
                            text: error.response?.data?.message || 'Gagal menambahkan kategori',
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
        createForm?.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            });
        });
    }

    // Global functions for create modal
    window.openCreateModal = function() {
        const modal = document.getElementById('createCategoryModal');
        const form = document.getElementById('createCategoryForm');

        if (form) {
            form.reset();

            // Reset errors
            document.querySelectorAll('[id^="create_"][id$="-error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            // Reset character counter
            const charCount = document.getElementById('create_charCount');
            if (charCount) {
                charCount.textContent = '0/500';
                charCount.className = 'absolute bottom-3 right-3 text-xs text-gray-400';
            }

            // Reset input borders
            form.querySelectorAll('input, textarea, select').forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
            });
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            document.getElementById('create_nama')?.focus();
        }, 100);
    };

    window.closeCreateModal = function() {
        const modal = document.getElementById('createCategoryModal');
        const submitBtn = document.getElementById('create_submitBtn');
        const submitBtnText = document.getElementById('create_submitBtnText');

        // Reset button if loading
        if (submitBtn && submitBtn.disabled) {
            submitBtn.disabled = false;
            if (submitBtnText) {
                submitBtnText.innerHTML = `
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kategori
                </span>
            `;
            }
        }

        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    };

    // Initialize on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        initCreateModal();

        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('createCategoryModal').classList.contains(
                    'hidden')) {
                closeCreateModal();
            }
        });

        // Close on background click
        const modal = document.getElementById('createCategoryModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCreateModal();
                }
            });
        }
    });
</script>