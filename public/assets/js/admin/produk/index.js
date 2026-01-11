$(document).ready(function () {
    var table = $("#productsTable").DataTable({
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
