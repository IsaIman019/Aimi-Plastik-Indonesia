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
    $("#produkSelect").prop("disabled", false);
}

$("#isAllProduct").on("change", function () {
    $("#produkSelect").prop("disabled", this.checked);
});

$("#createPromoForm").on("submit", function (e) {
    e.preventDefault();
    if (!$("#isAllProduct").is(":checked")) {
        if ($("input[name='is_all_product_hidden']").length === 0) {
            $("<input>")
                .attr({
                    type: "hidden",
                    name: "is_all_product",
                    value: 0,
                })
                .appendTo("#createPromoForm");
        }
    }
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
$("#isAllProduct").on("change", function () {
    $("#produkSelect").prop("disabled", this.checked);

    if (this.checked) {
        $("#produkSelect option").prop("selected", false);
    }
});
