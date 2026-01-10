window.openCreateModal = function () {
    resetCreateForm();
    $("#createKategoriModal").removeClass("hidden");
    document.body.style.overflow = "hidden";
};

function closeCreateKategoriModal() {
    $("#createKategoriModal").addClass("hidden");
    document.body.style.overflow = "auto";
}

function resetCreateForm() {
    $("#createKategoriForm")[0].reset();
    $("[id^=create_]").addClass("hidden").text("");
}

$("#createKategoriForm").on("submit", function (e) {
    e.preventDefault();

    const btn = $("#createKategoriSubmitBtn");
    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.KATEGORI_STORE_URL,
        method: "POST",
        data: $(this).serialize(),
        success: function () {
            resetCreateForm();
            closeCreateKategoriModal();
            reloadKategoriTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "Kategori berhasil ditambahkan",
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
