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
    window.reloadPromoTable = function () {
        if ($("#promoTable").DataTable()) {
            $("#promoTable").DataTable().ajax.reload(null, false);
        }
    };
});
window.editPromo = function (id) {
    $.get(`${window.PROMO_EDIT_URL}/${id}/edit`, function (res) {
        openEditPromoModal();

        const form = $("#editPromoForm");

        form.find('[name="id"]').val(res.id);
        form.find('[name="nama"]').val(res.nama);
        form.find('[name="kode"]').val(res.kode);
        form.find('[name="tipe"]').val(res.tipe);
        form.find('[name="jumlah"]').val(res.jumlah);
        form.find('[name="tanggal_mulai"]').val(res.tanggal_mulai);
        form.find('[name="tanggal_selesai"]').val(res.tanggal_selesai);
        form.find('[name="status"]').val(res.status);

        $("#editIsAllProduct").prop("checked", res.is_all_product);

        $("#editProdukSelect option").prop("selected", false);
        if (!res.is_all_product) {
            res.produks.forEach((p) => {
                $("#editProdukSelect option[value='" + p.id + "']").prop(
                    "selected",
                    true,
                );
            });
        }
    });
};
window.deletePromo = function (id, kode) {
    Swal.fire({
        title: "Hapus Promo?",
        html: `
            <div class="text-left">
                <p class="text-gray-600 mb-3">
                    Data Promo <strong>"${kode}"</strong> akan dihapus permanen.
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
                const response = await axios.delete(`/admin/promo/${id}`);

                if (!response.data || response.data.success === false) {
                    throw new Error(
                        response.data?.message || "Gagal menghapus data Promo",
                    );
                }

                return response.data;
            } catch (error) {
                let errorMessage = "Gagal menghapus data Promo";

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
                title: result.value?.message || "Data Promo berhasil dihapus",
                position: "top-end",
                showConfirmButton: false,
                timer: 2500,
            });

            if (window.reloadPromoTable) {
                reloadPromoTable();
            }
        }
    });
};
