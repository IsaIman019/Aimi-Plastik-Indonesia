$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#produkTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        dom: "rt",
        responsive: false,
        ajax: {
            url: window.PRODUK_INDEX_URL,
            data: function (d) {
                d.search = $("#searchInput").val();
                d.status = $("#statusFilter").val();
                d.kategori_id = $("#kategoriFilter").val();
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
            { data: "DT_RowIndex", orderable: false, className: "text-center" },
            { data: "nama" },
            { data: "kategori" },
            { data: "harga" },
            { data: "stok" },
            { data: "status" },
            { data: "action", orderable: false, searchable: false },
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

    $("#searchInput").on("keyup", () => table.draw());
    $("#statusFilter, #kategoriFilter").on("change", () => table.draw());
    $("#pageLength").on("change", function () {
        table.page.len(this.value).draw();
    });

    window.resetFilters = function () {
        $("#searchInput, #statusFilter, #kategoriFilter").val("");
        table.draw();
    };
    window.reloadProdukTable = function () {
        if ($("#produkTable").DataTable()) {
            $("#produkTable").DataTable().ajax.reload(null, false);
        }
    };
});

window.editProduk = async function (id) {
    // console.log("EDIT DIKLIK, ID:", id);

    try {
        const response = await axios.get(`/admin/produk/${id}/edit`);

        if (window.openEditModal) {
            window.openEditModal(response.data.data || response.data);
        } else {
            console.error("openEditModal tidak ditemukan");
        }
    } catch (error) {
        console.error(error);
    }
};

window.deleteProduk = function (id, value) {
    Swal.fire({
        title: "Hapus Produk?",
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">
                    Data Produk <strong>"${value}"</strong> akan dihapus permanen.
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
                const response = await axios.delete(`/admin/produk/${id}`);

                if (!response.data || response.data.success === false) {
                    throw new Error(
                        response.data?.message || "Gagal menghapus data produk"
                    );
                }

                return response.data;
            } catch (error) {
                let errorMessage = "Gagal menghapus data produk";

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
                title: result.value?.message || "Data produk berhasil dihapus",
                position: "top-end",
                showConfirmButton: false,
                timer: 2500,
            });

            if (window.reloadProdukTable) {
                reloadProdukTable();
            }
        }
    });
};
