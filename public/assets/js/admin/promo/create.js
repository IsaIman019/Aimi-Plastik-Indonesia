window.openCreateModal = function () {
    resetCreateForm();
    $("#createPromoModal").removeClass("hidden");
    document.body.style.overflow = "hidden";
};

window.closeCreatePromoModal = function () {
    $("#createPromoModal").addClass("hidden");
    document.body.style.overflow = "auto";
};

function resetCreateForm() {
    $("#createPromoForm")[0].reset();
    $("[id^=create_]").addClass("hidden").text("");

    $(".produk-checkbox").prop("checked", false).prop("disabled", false);
}

$("#isAllProduct").on("change", function () {
    if (this.checked) {
        $(".produk-checkbox").prop("checked", false).prop("disabled", true);
    } else {
        $(".produk-checkbox").prop("disabled", false);
    }
});

$("#createPromoForm").on("submit", function (e) {
    e.preventDefault();
    $("#isAllProduct").on("change", function () {
        if (this.checked) {
            $("#produkSelect").prop("disabled", true);
            $("#produkSelect option").prop("selected", false);
        } else {
            $("#produkSelect").prop("disabled", false);
        }
    });

    const btn = $("#createPromoSubmitBtn");
    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.PROMO_STORE_URL,
        method: "POST",
        data: $(this).serialize(),
        success: function () {
            closeCreatePromoModal();
            resetCreateForm();
            promoTable.ajax.reload(null, false);

            Swal.fire({
                toast: true,
                icon: "success",
                title: "Promo berhasil ditambahkan",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                Object.entries(errors).forEach(([key, val]) => {
                    $("#create_" + key + "-error")
                        .removeClass("hidden")
                        .text(val[0]);
                });
            }
        },
        complete: function () {
            btn.prop("disabled", false).text("Simpan");
        },
    });
});
$("#isAllProduct").on("change", function () {});
