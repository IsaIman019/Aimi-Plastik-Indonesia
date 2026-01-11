$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#newsTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        dom: "rt",
        responsive: false,
        ajax: {
            url: window.NEWS_INDEX_URL,
            data: function (d) {
                d.search = $("#searchInput").val();
                d.status = $("#statusFilter").val();
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
            { data: "DT_RowIndex", orderable: false, className: "text-center" },
            {
                data: "judul",
                render: (d) => d ?? "-",
            },
            {
                data: "gambar",
                render: function (data, type, row, meta) {
                    if (data) {
                        // Pastikan URL gambar benar
                        let imageUrl = data.startsWith("http")
                            ? data
                            : "/storage/" + data;

                        return `
                            <div class="flex justify-center">
                                <div class="relative group">
                                    <img src="${imageUrl}"
                                         alt="${row.judul || "Gambar artikel"}"
                                         class="w-16 h-16 object-cover rounded-lg border border-gray-200 cursor-pointer"
                                         onclick="showImageModal('${imageUrl}', '${
                            row.judul
                        }')">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <span class="text-white text-xs font-medium">Lihat</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    return `
                        <div class="flex justify-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    `;
                },
            },
            {
                data: "kategori_id",
                render: (d) => d ?? "-",
            },
            {
                data: "konten",
                render: (d) => d ?? "-",
            },
            {
                data: "status",
                render: (d) =>
                    `<span class="px-2 py-1 text-xs rounded ${
                        d === "ACTIVE"
                            ? "bg-green-100 text-green-700"
                            : "bg-gray-200"
                    }">${d}</span>`,
            },
            {
                data: "action",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
        ],
        order: [[1, "asc"]],
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

    $("#searchInput, #statusFilter").on("change keyup", function () {
        table.draw();
    });

    window.resetFilters = function () {
        $("#searchInput").val("");
        $("#statusFilter").val("");
        table.draw();
    };
    window.reloadNewsTable = function () {
        if ($("#newsTable").DataTable()) {
            $("#newsTable").DataTable().ajax.reload(null, false);
        }
    };
});
window.editNews = async function (id) {
    // console.log("EDIT DIKLIK, ID:", id);

    try {
        const response = await axios.get(`/admin/news/${id}/edit`);

        if (window.openEditModal) {
            window.openEditModal(response.data.data || response.data);
        } else {
            console.error("openEditModal tidak ditemukan");
        }
    } catch (error) {
        console.error(error);
    }
};

window.deleteNews = function (id, value) {
    Swal.fire({
        title: "Hapus News?",
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">
                    Data News <strong>"${value}"</strong> akan dihapus permanen.
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
                const response = await axios.delete(`/admin/news/${id}`);

                if (!response.data || response.data.success === false) {
                    throw new Error(
                        response.data?.message || "Gagal menghapus data news"
                    );
                }

                return response.data;
            } catch (error) {
                let errorMessage = "Gagal menghapus data news";

                if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }

                Swal.showValidationMessage(errorMessage);
            }
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                toast: true,
                icon: "success",
                title: result.value?.message || "Data News berhasil dihapus",
                position: "top-end",
                showConfirmButton: false,
                timer: 2500,
            });

            if (window.reloadNewsTable) {
                reloadNewsTable();
            }
        }
    });
};
