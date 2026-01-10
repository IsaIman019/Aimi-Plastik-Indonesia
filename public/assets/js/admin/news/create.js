window.openCreateModal = function () {
    resetCreateForm();
    $("#createNewsModal").removeClass("hidden");
    document.body.style.overflow = "hidden";
};

function closeCreateNewsModal() {
    $("#createNewsModal").addClass("hidden");
    document.body.style.overflow = "auto";
}

function resetCreateForm() {
    $("#createNewsForm")[0].reset();
    $("[id^=create_]").addClass("hidden").text("");
}

$("#createNewsForm").on("submit", function (e) {
    e.preventDefault();

    const form = $(this)[0];
    const formData = new FormData(form);
    const btn = $("#createNewsSubmitBtn");

    // Reset errors
    $("[id$='-error']").addClass("hidden").text("");

    // Validasi file di client side
    const fileInput = $("#createGambar")[0];
    if (fileInput.files[0] && fileInput.files[0].size > 2097152) {
        $("#create_gambar-error")
            .removeClass("hidden")
            .text("Ukuran gambar maksimal 2MB");
        return;
    }

    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.NEWS_STORE_URL,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            resetCreateForm();
            closeCreateNewsModal();
            reloadNewsTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "News berhasil ditambahkan",
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
