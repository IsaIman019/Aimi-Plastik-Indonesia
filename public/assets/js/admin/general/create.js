window.openCreateModal = function () {
    resetCreateForm();
    $("#createGeneralModal").removeClass("hidden");
    document.body.style.overflow = "hidden";
};

function closeCreateGeneralModal() {
    $("#createGeneralModal").addClass("hidden");
    document.body.style.overflow = "auto";
}

function resetCreateForm() {
    $("#createGeneralForm")[0].reset();
    $("[id^=create_]").addClass("hidden").text("");
}

$("#createGeneralForm").on("submit", function (e) {
    e.preventDefault();

    const btn = $("#createGeneralSubmitBtn");
    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.GENERAL_STORE_URL,
        method: "POST",
        data: $(this).serialize(),
        success: function () {
            resetCreateForm();
            closeCreateGeneralModal();
            reloadGeneralTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "General berhasil ditambahkan",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach((key) => {
                    $("#create_" + key + "-error")
                        .removeClass("hidden")
                        .text(errors[key][0]);
                });
            }
        },
        complete: function () {
            btn.prop("disabled", false).text("Simpan");
        },
    });
});
