window.openEditPromoModal = function () {
    $("#editPromoModal").removeClass("hidden");
    document.body.style.overflow = "hidden";
};
window.closeEditPromoModal = function () {
    $("#editPromoModal").addClass("hidden");
    document.body.style.overflow = "auto";
};
function editPromo(id) {
    $.get(window.PROMO_EDIT_URL + '/' + id + '/edit', function (res) {
        fillEditForm(res);
    });
}

window.fillEditForm = function (promo) {
    openEditPromoModal();

    $("#edit_id").val(promo.id);
    $("#edit_nama").val(promo.nama);
    $("#edit_kode").val(promo.kode);
    $("#edit_tipe").val(promo.tipe);
    $("#edit_jumlah").val(promo.jumlah);
    $("#edit_status").val(promo.status);
    $("#edit_tanggal_mulai").val(promo.tanggal_mulai);
    $("#edit_tanggal_selesai").val(promo.tanggal_selesai);

    $("#edit_is_all_product").prop("checked", false);

    // ⏳ TUNGGU DOM SIAP
    setTimeout(() => {
        const checkboxes = $(".edit-produk-checkbox");

        console.log('checkbox count:', checkboxes.length);

        checkboxes.prop("checked", false).prop("disabled", false);

        if (promo.is_all_product) {
            $("#edit_is_all_product").prop("checked", true);
            checkboxes.prop("disabled", true);
        } else {
            promo.produk_ids.forEach(id => {
                checkboxes
                    .filter('[value="' + id + '"]')
                    .prop("checked", true);
            });
        }
    }, 50); // 🔑 ini kuncinya
};



$("#editPromoForm").on("submit", function (e) {
    e.preventDefault();
    const id = $("#edit_id").val();
    const btn = $("#editPromoSubmitBtn");
    btn.prop("disabled", true).text("Menyimpan...");
    $.ajax({
        url: window.PROMO_UPDATE_URL.replace(":id", id),
        method: "POST",
        data: $(this).serialize(),
        success: function () {
            closeEditPromoModal();
            promoTable.ajax.reload(null, false);
            Swal.fire({
                toast: true,
                icon: "success",
                title: "Promo berhasil diperbarui",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        },
        complete: function () {
            btn.prop("disabled", false).text("Update");
        },
    });
});

$("#edit_is_all_product").on("change", function () {
    if (this.checked) {
        $(".edit-produk-checkbox")
            .prop("checked", false)
            .prop("disabled", true);
    } else {
        $(".edit-produk-checkbox").prop("disabled", false);
    }
});
