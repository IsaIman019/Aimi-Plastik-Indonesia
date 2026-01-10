$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#usersTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        responsive: false,
        ajax: {
            url: window.USERS_INDEX_URL,
            data: function (d) {
                d.search = $("#searchInput").val();
                d.role = $("#roleFilter").val();
                d.status = $("#statusFilter").val();
                d.length = $("#pageLength").val();
            },
            beforeSend: function () {
                $("#loadingState").show();
                $("#emptyState").hide();
                $("#tableBody").hide();
            },
            complete: function () {
                $("#loadingState").hide();
                $("#tableBody").show();
            },
        },
        columns: [
            {
                data: "DT_RowIndex",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
            {
                data: "nama",
                render: function (data) {
                    return data
                        ? `<span class="font-medium text-gray-900">${data}</span>`
                        : "-";
                },
            },
            {
                data: "email",
                render: function (data) {
                    return data
                        ? `<span class="text-gray-600">${data}</span>`
                        : "-";
                },
            },
            {
                data: "role",
                render: function (data) {
                    return `<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">${data}</span>`;
                },
            },
            {
                data: "status",
                render: function (data) {
                    const isActive = data === "ACTIVE";
                    const badgeClass = isActive
                        ? "status-active"
                        : "status-inactive";
                    const icon = isActive ? "✓" : "✗";
                    console.log("STATUS:", data, typeof data);
                    return `
                            <span class="status-badge ${badgeClass}">
                                <span class="mr-1">${icon}</span>
                                <span>${data}</span>
                            </span>
                        `;
                },
            },
            {
                data: "created_at",
                className: "hidden lg:table-cell",
                render: function (data) {
                    if (!data) return "-";
                    const date = new Date(data);
                    return `
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-900">
                                    ${date.toLocaleDateString("id-ID", {
                                        day: "2-digit",
                                        month: "short",
                                        year: "numeric",
                                    })}
                                </span>
                                <span class="text-xs text-gray-500">
                                    ${date.toLocaleTimeString("id-ID", {
                                        hour: "2-digit",
                                        minute: "2-digit",
                                    })}
                                </span>
                            </div>
                        `;
                },
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
                className: "text-center",
                width: "100px",
            },
        ],
        order: [[5, "desc"]],
        drawCallback: function () {
            updatePagination();
        },
    });

    function updatePagination() {
        const pageInfo = table.page.info();

        $("#tableInfo").html(
            `Menampilkan <span class="font-semibold">${
                pageInfo.start + 1
            }</span>
                sampai <span class="font-semibold">${pageInfo.end}</span>
                dari <span class="font-semibold">${
                    pageInfo.recordsTotal
                }</span> data`
        );

        $("#tableInfoTop").html(
            `Total: <span class="font-semibold">${pageInfo.recordsTotal}</span> data`
        );

        if (pageInfo.recordsTotal === 0) {
            $("#emptyState").show();
        } else {
            $("#emptyState").hide();
        }

        let paginationHtml = "";

        paginationHtml +=
            pageInfo.page === 0
                ? `<button disabled class="text-gray-400 cursor-not-allowed">‹</button>`
                : `<button onclick="table.page(${
                      pageInfo.page - 1
                  }).draw('page')">‹</button>`;

        const maxVisiblePages = 5;
        let startPage = Math.max(
            0,
            pageInfo.page - Math.floor(maxVisiblePages / 2)
        );
        let endPage = Math.min(pageInfo.pages, startPage + maxVisiblePages);

        for (let i = startPage; i < endPage; i++) {
            paginationHtml += `
                    <button
                        onclick="table.page(${i}).draw('page')"
                        class="${i === pageInfo.page ? "current" : ""}">
                        ${i + 1}
                    </button>`;
        }

        paginationHtml +=
            pageInfo.page < pageInfo.pages - 1
                ? `<button onclick="table.page(${
                      pageInfo.page + 1
                  }).draw('page')">›</button>`
                : `<button disabled class="text-gray-400 cursor-not-allowed">›</button>`;

        $("#paginationContainer").html(
            `<div class="custom-pagination">${paginationHtml}</div>`
        );
    }

    /* ================= FILTER HANDLER ================= */
    let searchTimeout;
    $("#searchInput").on("keyup", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => table.draw(), 500);
    });

    $("#roleFilter, #statusFilter").on("change", function () {
        table.draw();
    });

    $("#pageLength").on("change", function () {
        table.page.len(this.value).draw();
    });

    window.resetFilters = function () {
        $("#searchInput").val("");
        $("#roleFilter").val("");
        $("#statusFilter").val("");
        $("#pageLength").val("10");
        table.search("").draw();
    };

    window.reloadUsersTable = function () {
        if ($("#usersTable").DataTable()) {
            $("#usersTable").DataTable().ajax.reload(null, false);
        }
    };
});

window.openModal = function () {
    if (window.openCreateModal) {
        window.openCreateModal();
    } else {
        console.error("Fungsi openCreateModal tidak ditemukan!");
    }
};

window.editUser = async function (id) {
    console.log("EDIT DIKLIK, ID:", id);

    try {
        const response = await axios.get(`/admin/users/${id}/edit`);

        if (window.openEditModal) {
            window.openEditModal(response.data.data || response.data);
        } else {
            console.error("openEditModal tidak ditemukan");
        }
    } catch (error) {
        console.error(error);
    }
};
window.deleteUser = function (id, name) {
    Swal.fire({
        title: "Hapus User?",
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">
                    User <strong>"${name}"</strong> akan dihapus permanen.
                </p>
            </div>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        reverseButtons: true,
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
        preConfirm: async () => {
            try {
                const response = await axios.delete(`/admin/users/${id}`);

                if (response.data && response.data.success === false) {
                    throw new Error(
                        response.data.message || "Gagal menghapus user"
                    );
                }

                return response.data;
            } catch (error) {
                let errorMessage = "Gagal menghapus user";

                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }

                throw new Error(errorMessage);
            }
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                title: "Terhapus!",
                text: result.value?.message || "User berhasil dihapus",
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: "top-end",
            }).then(() => {
                if ($("#usersTable").DataTable()) {
                    $("#usersTable").DataTable().ajax.reload(null, false);
                }
            });
        }
    });
};
