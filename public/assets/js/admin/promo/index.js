$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    window.promoTable = $("#promoTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        lengthChange: false,
        info: false,
        paging: true,
        dom: "rt",
        ajax: {
            url: window.PROMO_INDEX_URL,
            data: function (d) {
                d.search = $("#searchInput").val();
                d.status = $("#statusFilter").val();
            },
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false },
            { data: "nama" },
            { data: "kode" },
            {
                data: "tipe",
                render: (d) => (d === "percent" ? "Persen" : "Nominal"),
            },
            { data: "jumlah" },
            { data: "periode", orderable: false },
            {
                data: "status",
                render: (d) => `
                    <span class="px-2 py-1 text-xs rounded ${
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
    });

    $("#searchInput, #statusFilter").on("keyup change", function () {
        promoTable.draw();
    });

    window.resetFilters = function () {
        $("#searchInput").val("");
        $("#statusFilter").val("");
        promoTable.draw();
    };
});
