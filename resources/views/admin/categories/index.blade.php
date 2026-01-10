    @extends('layouts.app')

    @section('content')
    <div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
        @include('components.admin-sidebar')

        <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto h-screen">
            <!-- Header Section -->
            <div class="mb-6 lg:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Kategori Produk</h1>
                        <p class="text-gray-500 text-sm md:text-base mt-1">
                            Kelola pengelompokan produk (Lakban, Bubble Wrap, dll).
                        </p>
                    </div>
                    <button type="button" onclick="openCreateModal()"
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2.5 md:px-5 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-md w-full sm:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Kategori</span>
                    </button>
                </div>
            </div>

            <!-- SweetAlert Notifications -->
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('
                        success ') }}',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '{{ session('
                        error ') }}',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            </script>
            @endif

            <!-- Filter & Search Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchInput"
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                placeholder="Cari nama atau deskripsi kategori...">
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative min-w-[150px]">
                            <select id="statusFilter"
                                class="w-full appearance-none bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-4 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                                <option value="">Semua Status</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="INACTIVE">INACTIVE</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        <button onclick="resetFilters()"
                            class="px-4 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg font-medium transition hover:shadow-sm whitespace-nowrap">
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div
                    class="px-4 py-3 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-sm text-gray-700">
                        <label class="flex items-center gap-2">
                            <span>Tampilkan</span>
                            <select id="pageLength"
                                class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-orange-500">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="-1">Semua</option>
                            </select>
                            <span>data</span>
                        </label>
                    </div>
                    <div class="text-sm text-gray-500" id="tableInfoTop">
                        Total: <span class="font-semibold">0</span> data
                    </div>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="categoriesTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20 text-center">
                                    NO
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    NAMA KATEGORI
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    DESKRIPSI
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    STATUS
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    DIBUAT
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                    AKSI
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                            <!-- Data akan diisi oleh DataTables -->
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="text-sm text-gray-700" id="tableInfo">
                            Menampilkan <span class="font-semibold">0</span> sampai <span class="font-semibold">0</span>
                            dari <span class="font-semibold">0</span> data
                        </div>
                        <div class="flex items-center space-x-1" id="paginationContainer">
                            <!-- Pagination akan diisi manual -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- include modal -->
    @include('admin.categories.create')
    @include('admin.categories.edit')

    <!-- DataTables & SweetAlert -->
    <style>
        /* Reset DataTables default styling */
        #categoriesTable_wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        #categoriesTable_wrapper .dataTables_length,
        #categoriesTable_wrapper .dataTables_filter,
        #categoriesTable_wrapper .dataTables_info,
        #categoriesTable_wrapper .dataTables_paginate {
            display: none !important;
        }

        /* Custom table styling */
        #categoriesTable {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
        }

        #categoriesTable thead th {
            background-color: #f9fafb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        #categoriesTable tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }

        #categoriesTable tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Custom pagination */
        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .custom-pagination button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            border: 1px solid #d1d5db;
            background: white;
            color: #4b5563;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .custom-pagination button:hover:not(:disabled) {
            background: #f3f4f6;
            border-color: #9ca3af;
            color: #111827;
        }

        .custom-pagination button.current {
            background: #f97316;
            border-color: #f97316;
            color: white;
        }

        .custom-pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .custom-pagination .ellipsis {
            padding: 0 0.5rem;
            color: #6b7280;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            #categoriesTable thead th:nth-child(3),
            #categoriesTable thead th:nth-child(5) {
                display: none;
            }

            #categoriesTable tbody td:nth-child(3),
            #categoriesTable tbody td:nth-child(5) {
                display: none;
            }

            #categoriesTable thead th,
            #categoriesTable tbody td {
                padding: 0.75rem 0.5rem;
            }
        }

        @media (max-width: 640px) {

            #categoriesTable thead th:nth-child(4),
            #categoriesTable tbody td:nth-child(4) {
                display: none;
            }

            .custom-pagination button span {
                display: none;
            }

            .custom-pagination button {
                min-width: 2rem;
                padding: 0;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            // CSRF Token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable WITHOUT default controls
            var table = $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false, // Disable DataTables search
                lengthChange: false, // Disable DataTables length change
                info: false, // Disable DataTables info
                paging: true, // Disable DataTables pagination
                responsive: true,
                ajax: {
                    url: "{{ route('admin.categories.index') }}",
                    data: function(d) {
                        d.search = $('#searchInput').val();
                        d.status = $('#statusFilter').val();
                        d.length = $('#pageLength').val();
                    },
                    beforeSend: function() {
                        $('#loadingState').show();
                        $('#emptyState').hide();
                        $('#tableBody').hide();
                    },
                    complete: function() {
                        $('#loadingState').hide();
                        $('#tableBody').show();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data) {
                            return data ? `<span class="font-medium text-gray-900">${data}</span>` :
                                '-';
                        }
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                        className: 'hidden md:table-cell',
                        render: function(data) {
                            if (!data) return '-';
                            return `<span class="text-gray-600">${data.length > 50 ? data.substr(0, 50) + '...' : data}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            const isActive = data === 'ACTIVE';
                            const badgeClass = isActive ? 'status-active' : 'status-inactive';
                            const icon = isActive ? '✓' : '✗';

                            return `
                            <span class="status-badge ${badgeClass}">
                                <span class="mr-1">${icon}</span>
                                <span>${data}</span>
                            </span>
                        `;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'hidden lg:table-cell',
                        render: function(data) {
                            if (!data) return '-';
                            const date = new Date(data);
                            return `
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-900">${date.toLocaleDateString('id-ID', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric'
                                })}</span>
                                <span class="text-xs text-gray-500">${date.toLocaleTimeString('id-ID', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</span>
                            </div>
                        `;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '100px',
                        render: function(data, type, row) {
                            return `
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="editCategory(${row.id})"
                                            class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition"
                                            title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteCategory(${row.id}, '${row.nama ? row.nama.replace(/'/g, "\\'").replace(/"/g, '&quot;') : ''}')"
                                            class="inline-flex items-center justify-center w-8 h-8 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                order: [
                    [4, 'desc']
                ],
                drawCallback: function(settings) {
                    updatePagination();
                }
            });

            // Update pagination controls
            function updatePagination() {
                const pageInfo = table.page.info();

                // Update table info
                $('#tableInfo').html(
                    `Menampilkan <span class="font-semibold">${pageInfo.start + 1}</span> sampai <span class="font-semibold">${pageInfo.end}</span> dari <span class="font-semibold">${pageInfo.recordsTotal}</span> data`
                );

                $('#tableInfoTop').html(
                    `Total: <span class="font-semibold">${pageInfo.recordsTotal}</span> data`
                );

                // Show empty state if no records
                if (pageInfo.recordsTotal === 0) {
                    $('#emptyState').show();
                    $('#tableBody').hide();
                } else {
                    $('#emptyState').hide();
                    $('#tableBody').show();
                }

                // Build custom pagination
                let paginationHtml = '';

                // Previous button
                if (pageInfo.page === 0) {
                    paginationHtml += `<button disabled class="text-gray-400 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>`;
                } else {
                    paginationHtml += `<button onclick="table.page(${pageInfo.page - 1}).draw('page')" class="hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>`;
                }

                // Page numbers
                const maxVisiblePages = 5;
                let startPage = Math.max(0, pageInfo.page - Math.floor(maxVisiblePages / 2));
                let endPage = Math.min(pageInfo.pages, startPage + maxVisiblePages);

                if (endPage - startPage < maxVisiblePages) {
                    startPage = Math.max(0, endPage - maxVisiblePages);
                }

                if (startPage > 0) {
                    paginationHtml +=
                        `<button onclick="table.page(0).draw('page')" class="${0 === pageInfo.page ? 'current' : ''}">1</button>`;
                    if (startPage > 1) {
                        paginationHtml += `<span class="ellipsis">...</span>`;
                    }
                }

                for (let i = startPage; i < endPage; i++) {
                    paginationHtml +=
                        `<button onclick="table.page(${i}).draw('page')" class="${i === pageInfo.page ? 'current' : ''}">${i + 1}</button>`;
                }

                if (endPage < pageInfo.pages) {
                    if (endPage < pageInfo.pages - 1) {
                        paginationHtml += `<span class="ellipsis">...</span>`;
                    }
                    paginationHtml +=
                        `<button onclick="table.page(${pageInfo.pages - 1}).draw('page')" class="${pageInfo.pages - 1 === pageInfo.page ? 'current' : ''}">${pageInfo.pages}</button>`;
                }

                // Next button
                if (pageInfo.page < pageInfo.pages - 1) {
                    paginationHtml += `<button onclick="table.page(${pageInfo.page + 1}).draw('page')" class="hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>`;
                } else {
                    paginationHtml += `<button disabled class="text-gray-400 cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>`;
                }

                $('#paginationContainer').html(`<div class="custom-pagination">${paginationHtml}</div>`);
            }

            // Search input handler with debounce
            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    table.draw();
                }, 500);
            });

            // Status filter handler
            $('#statusFilter').on('change', function() {
                table.draw();
            });

            // Page length handler
            $('#pageLength').on('change', function() {
                table.page.len(this.value).draw();
            });

            // Reset filters
            window.resetFilters = function() {
                $('#searchInput').val('');
                $('#statusFilter').val('');
                $('#pageLength').val('10');
                table.search('').draw();
            };
        });

        // CSRF Token for AJAX
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Open Modal for Create

        window.openModal = function() {
            if (window.openCreateModal) {
                window.openCreateModal();
            } else {
                console.error('Fungsi openCreateModal tidak ditemukan!');
            }
        };
        window.reloadCategoriesTable = function() {
            if (typeof $ !== 'undefined' && $('#categoriesTable').DataTable()) {
                $('#categoriesTable').DataTable().ajax.reload(null, false);
            }
        };


        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Edit Category
        window.editCategory = async function(id) {
            try {
                console.log('Mengambil data kategori ID:', id);

                // Route: GET /admin/categories/{id}/edit
                const response = await axios.get(`/admin/categories/${id}/edit`);

                if (response.data && response.data.success !== false) {
                    // Jika controller mengembalikan data langsung
                    const categoryData = response.data.data || response.data;
                    console.log('Data kategori diterima:', categoryData);

                    // Panggil fungsi untuk membuka modal edit
                    if (window.openEditModal) {
                        window.openEditModal(categoryData);
                    } else {
                        console.error('Fungsi openEditModal tidak ditemukan!');
                        // Fallback ke modal create dengan data
                        if (window.openCreateModal) {
                            window.openCreateModal(categoryData);
                        }
                    }
                } else {
                    throw new Error('Data kategori tidak ditemukan');
                }

            } catch (error) {
                console.error('Error mengambil data kategori:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.response?.data?.message || 'Gagal mengambil data kategori',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        };
        // TAMBAHKAN FUNGSI UNTUK RELOAD TABLE
        window.reloadCategoriesTable = function() {
            if (typeof $ !== 'undefined' && $('#categoriesTable').DataTable()) {
                $('#categoriesTable').DataTable().ajax.reload(null, false);
            }
        };

        // Delete Category - Diperbaiki untuk handle error response
        function deleteCategory(id, name) {
            Swal.fire({
                title: 'Hapus Kategori?',
                html: `
                <div class="text-left">
                    <p class="text-gray-600 mb-3">Kategori <strong>"${name}"</strong> akan dihapus permanen.</p>
                    <p class="text-sm text-red-600 bg-red-50 border border-red-100 rounded-lg p-3">
                        ⚠️ Produk dalam kategori ini akan kehilangan kategori.
                    </p>
                </div>
            `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: async () => {
                    try {
                        const response = await axios.delete(`/admin/categories/${id}`);

                        // Check if response indicates success
                        if (response.data && response.data.success === false) {
                            throw new Error(response.data.message || 'Gagal menghapus kategori');
                        }

                        return response.data;
                    } catch (error) {
                        // Handle different types of errors
                        let errorMessage = 'Gagal menghapus kategori';

                        if (error.response) {
                            // Server responded with error
                            if (error.response.data && error.response.data.message) {
                                errorMessage = error.response.data.message;
                            } else if (error.response.status === 404) {
                                errorMessage = 'Kategori tidak ditemukan';
                            } else if (error.response.status === 400) {
                                errorMessage = error.response.data?.message || 'Kategori tidak dapat dihapus';
                            }
                        } else if (error.request) {
                            // Request made but no response
                            errorMessage = 'Tidak ada respon dari server';
                        } else {
                            // Something else
                            errorMessage = error.message || 'Terjadi kesalahan';
                        }

                        throw new Error(errorMessage);
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: result.value?.message || 'Kategori berhasil dihapus',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    }).then(() => {
                        // Reload DataTable
                        if ($('#categoriesTable').DataTable()) {
                            $('#categoriesTable').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            }).catch((error) => {
                // Error during preConfirm (already handled)
                console.error('Delete error:', error);
            });
        }
    </script>

    @endsection