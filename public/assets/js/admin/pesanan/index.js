$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#pesananTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        dom: "rt",
        responsive: false,
        ajax: {
            url: window.PESANAN_INDEX_URL,
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
            { data: "user", name: "user.nama" },
            { data: "no_pesanan" },
            { data: "no_resi" },
            { data: "tanggal_pesanan" },
            { data: "total_harga" },
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

    $("#searchInput, #statusFilter").on("keyup change", function () {
        table.draw();
    });

    window.resetFilters = function () {
        $("#searchInput").val("");
        $("#statusFilter").val("");
        table.draw();
    };

    window.reloadPesananTable = function () {
        if ($("#pesananTable").DataTable()) {
            $("#pesananTable").DataTable().ajax.reload(null, false);
        }
    };
});
window.editPesanan = async function (id) {
    // console.log("EDIT DIKLIK, ID:", id);

    try {
        const response = await axios.get(`/admin/pesanan/${id}/edit`);

        if (window.openEditModal) {
            window.openEditModal(response.data.data || response.data);
        } else {
            console.error("openEditModal tidak ditemukan");
        }
    } catch (error) {
        console.error(error);
    }
};
