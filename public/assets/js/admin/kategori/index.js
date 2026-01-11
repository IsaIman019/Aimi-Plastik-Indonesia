$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#kategoriTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        dom: "rt",
        responsive: false,
        ajax: {
            url: window.KATEGORI_INDEX_URL,
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
            { data: "nama" },
            {
                data: "deskripsi",
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

    $("#searchInput, #statusFilter").on("keyup change", function () {
        table.draw();
    });

    window.resetFilters = function () {
        $("#searchInput").val("");
        $("#statusFilter").val("");
        table.draw();
    };

    window.reloadKategoriTable = function () {
        if ($("#kategoriTable").DataTable()) {
            $("#kategoriTable").DataTable().ajax.reload(null, false);
        }
    };
});
window.editKategori = async function (id) {
    // console.log("EDIT DIKLIK, ID:", id);

    try {
        const response = await axios.get(`/admin/kategori/${id}/edit`);

        if (window.openEditModal) {
            window.openEditModal(response.data.data || response.data);
        } else {
            console.error("openEditModal tidak ditemukan");
        }
    } catch (error) {
        console.error(error);
    }
};
window.deleteKategori = function (id, nama) {
    Swal.fire({
        title: "Hapus Kategori?",
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">
                    Kategori <strong>"${nama}"</strong> akan dihapus permanen.
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
                const response = await axios.delete(`/admin/kategori/${id}`);

                if (!response.data || response.data.success === false) {
                    throw new Error(
                        response.data?.message ||
                            "Gagal menghapus data kategori"
                    );
                }

                return response.data;
            } catch (error) {
                let errorMessage = "Gagal menghapus data kategori";

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
                title:
                    result.value?.message || "Data Kategori berhasil dihapus",
                position: "top-end",
                showConfirmButton: false,
                timer: 2500,
            });

            if (window.reloadKategoriTable) {
                reloadKategoriTable();
            }
        }
    });
};
