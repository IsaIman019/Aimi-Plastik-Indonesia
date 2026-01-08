@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.admin-sidebar')

    <div class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto h-screen">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 lg:mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Kategori Produk</h1>
                <p class="text-gray-500 text-sm md:text-base mt-1 md:mt-2">
                    Kelola pengelompokan produk (Lakban, Bubble Wrap, dll).
                </p>
            </div>
            <button type="button" onclick="openModal()"
                class="flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2.5 md:px-5 md:py-3 rounded-xl font-bold transition-all duration-200 shadow-lg shadow-orange-200 hover:shadow-orange-300 w-full sm:w-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Kategori</span>
            </button>
        </div>

        <!-- SweetAlert Notifications -->
        @if(session('success'))
        <div class="mb-4 animate-fade-in">
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
                        position: 'top-end',
                        background: '#f0fdf4',
                        color: '#166534'
                    });
                });
            </script>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 animate-fade-in">
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
                        position: 'top-end',
                        background: '#fef2f2',
                        color: '#991b1b'
                    });
                });
            </script>
        </div>
        @endif

        <!-- Filter & Search Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="searchInput"
                            class="block w-full pl-10 pr-4 py-2.5 md:py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                            placeholder="Cari nama atau deskripsi kategori...">
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <select id="statusFilter"
                            class="appearance-none bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 md:py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 w-full lg:w-auto">
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
                        class="px-4 py-2.5 md:py-3 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-all duration-200 hover:shadow-sm w-full lg:w-auto">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600" id="categoriesTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-4 py-3 md:px-6 md:py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">
                                No</th>
                            <th
                                class="px-4 py-3 md:px-6 md:py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Nama Kategori</th>
                            <th
                                class="px-4 py-3 md:px-6 md:py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Deskripsi</th>
                            <th
                                class="px-4 py-3 md:px-6 md:py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-3 md:px-6 md:py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                Dibuat</th>
                            <th
                                class="px-4 py-3 md:px-6 md:py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Data akan diisi oleh DataTables secara otomatis -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mb-4"></div>
                <p class="text-gray-500">Memuat data...</p>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden p-8 text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium mb-2">Belum ada kategori</p>
                <p class="text-gray-400 text-sm mb-4">Mulai dengan menambahkan kategori pertama Anda</p>
                <button onclick="openModal()"
                    class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kategori
                </button>
            </div>

            <!-- Table Footer -->
            <div class="px-4 py-3 md:px-6 md:py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="text-sm text-gray-500" id="tableInfo">
                        Menampilkan 0 sampai 0 dari 0 entri
                    </div>
                    <div class="flex items-center gap-2" id="pagination">
                        <!-- Pagination akan diisi oleh DataTables -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Include Modal Form -->
@include('admin.categories.modal-form')

<!-- DataTables & SweetAlert -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    /* Responsive table adjustments */
    @media (max-width: 768px) {

        #categoriesTable thead th:nth-child(3),
        #categoriesTable thead th:nth-child(5) {
            display: none;
        }

        #categoriesTable tbody td:nth-child(3),
        #categoriesTable tbody td:nth-child(5) {
            display: none;
        }
    }

    /* Custom DataTables styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem 1rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.5rem;
        margin: 0 0.125rem;
        border: 1px solid #e5e7eb;
        background: white;
        color: #4b5563;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #111827;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #f97316;
        border-color: #f97316;
        color: white;
    }

    /* Hover effect for table rows */
    #categoriesTable tbody tr {
        transition: background-color 0.2s;
    }

    #categoriesTable tbody tr:hover {
        background-color: #f9fafb;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
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

        // Initialize DataTable with Server-side Processing
        var table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: {
                details: {
                    type: 'column',
                    target: 0
                }
            },
            ajax: {
                url: "{{ route('admin.categories.index') }}",
                data: function(d) {
                    d.search = $('#searchInput').val();
                    d.status = $('#statusFilter').val();
                    d.draw = d.draw || 1;
                },
                beforeSend: function() {
                    $('#loadingState').show();
                    $('#emptyState').hide();
                },
                complete: function() {
                    $('#loadingState').hide();
                },
                error: function(xhr, error, thrown) {
                    $('#loadingState').hide();
                    console.error('DataTables Error:', error, thrown);

                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Gagal memuat data. Silakan coba lagi.',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '5%',
                    className: 'text-center'
                },
                {
                    data: 'nama',
                    name: 'nama',
                    render: function(data, type, row) {
                        // Mobile view with icon
                        if ($(window).width() < 768) {
                            return `
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-orange-50 text-orange-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="font-semibold text-gray-900 truncate">${data || '-'}</div>
                                    <div class="text-xs text-gray-500 truncate">${row.deskripsi ? (row.deskripsi.length > 30 ? row.deskripsi.substring(0, 30) + '...' : row.deskripsi) : '-'}</div>
                                </div>
                            </div>
                        `;
                        }
                        // Desktop view
                        return data ? (data.length > 30 ? data.substr(0, 30) + '...' : data) : '-';
                    }
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi',
                    className: 'hidden md:table-cell',
                    render: function(data) {
                        return data ? (data.length > 50 ? data.substr(0, 50) + '...' : data) : '-';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        const isActive = data === 'ACTIVE';
                        const badgeClass = isActive ?
                            'bg-green-100 text-green-800 border-green-200' :
                            'bg-red-100 text-red-800 border-red-200';

                        return `
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${badgeClass}">
                            ${isActive ? '✓' : '✗'} ${data}
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
                            <span class="text-sm text-gray-900">${date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</span>
                            <span class="text-xs text-gray-500">${date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</span>
                        </div>
                    `;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '12%',
                    className: 'text-right',
                    render: function(data, type, row) {
                        if (!data) {
                            return `
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="editCategory(${row.id})"
                                        class="p-1.5 md:p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-orange-600 hover:border-orange-300 hover:bg-orange-50 transition-all duration-200"
                                        title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <button onclick="deleteCategory(${row.id}, '${row.nama ? row.nama.replace(/'/g, "\\'") : ''}')"
                                        class="p-1.5 md:p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-red-600 hover:border-red-300 hover:bg-red-50 transition-all duration-200"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        `;
                        }
                        return data;
                    }
                }
            ],
            language: {
                processing: '<div class="flex items-center justify-center p-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div></div>',
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang sesuai",
                emptyTable: "Tidak ada data kategori",
                paginate: {
                    first: '<span class="hidden sm:inline">Pertama</span><svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>',
                    last: '<span class="hidden sm:inline">Terakhir</span><svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>',
                    next: '<span class="hidden sm:inline">Selanjutnya</span><svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                    previous: '<span class="hidden sm:inline">Sebelumnya</span><svg class="w-5 h-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>'
                }
            },
            order: [
                [4, 'desc']
            ],
            pageLength: 10,
            drawCallback: function(settings) {
                // Update table info
                const api = this.api();
                const pageInfo = api.page.info();
                $('#tableInfo').html(
                    `Menampilkan <span class="font-semibold">${pageInfo.start + 1}</span> sampai <span class="font-semibold">${pageInfo.end}</span> dari <span class="font-semibold">${pageInfo.recordsTotal}</span> kategori`
                );

                // Show empty state if no records
                if (pageInfo.recordsTotal === 0) {
                    $('#emptyState').show();
                } else {
                    $('#emptyState').hide();
                }
            },
            initComplete: function() {
                // Add responsive class to table wrapper
                $('.dataTables_wrapper').addClass('responsive');
            }
        });

        // Debounce search input
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

        // Reset filters
        window.resetFilters = function() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            table.search('').draw();
            $('#searchInput').focus();
        };

        // Responsive adjustments on window resize
        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                table.columns.adjust().responsive.recalc();
            }, 250);
        });
    });

    // CSRF Token for AJAX
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Open Modal for Create
    function openModal() {
        document.getElementById('modalTitle').textContent = 'Tambah Kategori Baru';
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';

        // Reset validation
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

        document.getElementById('categoryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Close Modal
    function closeModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Edit Category
    async function editCategory(id) {
        try {
            const {
                data: category
            } = await axios.get(`/admin/categories/${id}/edit`);

            document.getElementById('modalTitle').textContent = 'Edit Kategori';
            document.getElementById('categoryId').value = category.id;
            document.getElementById('nama').value = category.nama;
            document.getElementById('deskripsi').value = category.deskripsi || '';
            document.getElementById('status').value = category.status;

            // Reset validation
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

            document.getElementById('categoryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Auto focus on first input
            setTimeout(() => document.getElementById('nama').focus(), 100);

        } catch (error) {
            console.error('Edit error:', error);
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
    }

    // Delete Category
    function deleteCategory(id, name) {
        Swal.fire({
            title: 'Hapus Kategori?',
            html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">Anda akan menghapus kategori:</p>
                <div class="bg-red-50 border border-red-100 rounded-lg p-3 mb-4">
                    <p class="font-semibold text-red-700">${name}</p>
                </div>
                <p class="text-sm text-red-600 bg-red-50 border border-red-100 rounded-lg p-2">
                    ⚠️ Data yang dihapus tidak dapat dikembalikan. Produk dalam kategori ini akan kehilangan kategori.
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
            backdrop: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: async () => {
                try {
                    const response = await axios.delete(`/admin/categories/${id}`);
                    return response.data;
                } catch (error) {
                    throw new Error(error.response?.data?.message || 'Gagal menghapus kategori');
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.value.message,
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                }).then(() => {
                    // Reload DataTable
                    $('#categoriesTable').DataTable().ajax.reload(null, false);
                });
            }
        });
    }

    // Form Submission
    document.getElementById('categoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const id = document.getElementById('categoryId').value;
        const url = id ? `/admin/categories/${id}` : '/admin/categories';
        const method = id ? 'PUT' : 'POST';

        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = `
        <div class="flex items-center justify-center gap-2">
            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
            <span>Menyimpan...</span>
        </div>
    `;
        submitBtn.disabled = true;

        try {
            const response = await axios({
                method: method,
                url: url,
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            }).then(() => {
                closeModal();
                // Reload DataTable
                $('#categoriesTable').DataTable().ajax.reload(null, false);
            });

        } catch (error) {
            if (error.response?.status === 422) {
                // Validation errors
                const errors = error.response.data.errors;
                for (const field in errors) {
                    const input = document.getElementById(field);
                    if (input) {
                        input.classList.add('border-red-500');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message text-red-500 text-sm mt-1 flex items-center gap-1';
                        errorDiv.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        ${errors[field][0]}
                    `;
                        input.parentNode.appendChild(errorDiv);
                    }
                }

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
                    title: 'Gagal!',
                    text: error.response?.data?.message || 'Terjadi kesalahan',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        } finally {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('categoryModal').classList.contains('hidden')) {
            closeModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('categoryModal').addEventListener('click', function(e) {
        if (e.target.id === 'categoryModal') {
            closeModal();
        }
    });

    // Auto-focus search input on page load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
            }
        }, 300);
    });
</script>

@endsection