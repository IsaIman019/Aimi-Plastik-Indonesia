$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    const table = $("#stokTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        dom: "rt",
        responsive: false,
        ajax: {
            url: window.STOK_INDEX_URL,
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

            {
                data: "stok",
                className: "text-center",
                render: (d) => `<span class="stok-view">${d}</span>`,
            },
            {
                data: "status",
                className: "text-center",
                render: (d) => {
                    const cls =
                        d === "ACTIVE"
                            ? "bg-green-100 text-green-700"
                            : "bg-red-100 text-red-700";
                    return `<span class="px-2 py-1 text-xs rounded ${cls}">${d}</span>`;
                },
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: "text-center",
                render: (row) => `
                    <button
                        onclick="editStok(${row.id})"
                        class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded">
                        ✏️ Update
                    </button>
                `,
            },
        ],
        order: [[1, "asc"]],
        drawCallback: function () {
            updatePagination();
        },
    });

    /* ================= PAGINATION ================= */
    function updatePagination() {
        const pageInfo = table.page.info();

        $("#tableInfo").html(
            `Menampilkan <span class="font-semibold">${
                pageInfo.start + 1
            }</span>
                sampai <span class="font-semibold">${pageInfo.end}</span>
                dari <span class="font-semibold">${
                    pageInfo.recordsTotal
                }</span> data`,
        );

        $("#tableInfoTop").html(
            `Total: <span class="font-semibold">${pageInfo.recordsTotal}</span> data`,
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
            pageInfo.page - Math.floor(maxVisiblePages / 2),
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
            `<div class="custom-pagination">${paginationHtml}</div>`,
        );
    }

    /* ================= FILTER ================= */
    let searchTimeout;
    $("#searchInput").on("keyup", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => table.draw(), 400);
    });

    $("#statusFilter, #kategoriFilter").on("change", () => table.draw());
    $("#pageLength").on("change", function () {
        table.page.len(this.value).draw();
    });

    window.resetFilters = function () {
        $("#searchInput, #statusFilter, #kategoriFilter").val("");
        table.draw();
    };

    window.reloadStokTable = function () {
        table.ajax.reload(null, false);
    };

    /* ================= INLINE EDIT ================= */
    window.editStok = function (id) {
        const tr = $(`button[onclick="editStok(${id})"]`).closest("tr");
        const row = table.row(tr);
        const data = row.data();

        tr.find("td:eq(4)").html(`
        <input type="number" id="stok-${id}"
            value="${data.stok}"
            class="w-20 px-2 py-1 border rounded text-center">
    `);

        tr.find("td:eq(5)").html(`
        <select id="status-${id}" class="px-2 py-1 border rounded">
            <option value="ACTIVE" ${data.status === "ACTIVE" ? "selected" : ""}>ACTIVE</option>
            <option value="INACTIVE" ${data.status === "INACTIVE" ? "selected" : ""}>INACTIVE</option>
        </select>
    `);

        tr.find("td:eq(6)").html(`
        <button onclick="updateStok(${id})"
            class="px-3 py-1 text-sm bg-green-600 text-white rounded mr-1">Simpan</button>
        <button onclick="reloadStokTable()"
            class="px-3 py-1 text-sm bg-gray-200 rounded">Batal</button>
    `);
    };

    window.updateStok = async function (id) {
        try {
            const stok = $(`#stok-${id}`).val();
            const status = $(`#status-${id}`).val();

            await axios.put(`/admin/stok/${id}`, {
                stok,
                status,
            });

            Swal.fire({
                toast: true,
                icon: "success",
                title: "Stok berhasil diperbarui",
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
            });

            reloadStokTable();
        } catch (error) {
            console.error(error.response);

            Swal.fire(
                "Gagal",
                error.response?.data?.message ?? "Tidak bisa update stok",
                "error",
            );
        }
    };
});
