window.openCreateModal = function () {
    resetCreateForm();
    document.getElementById("createProdukModal").classList.remove("hidden");
    document.body.style.overflow = "hidden";
};

function closeCreateProdukModal() {
    $("#createProdukModal").addClass("hidden");
    document.body.style.overflow = "auto";
}

function resetCreateForm() {
    $("#createProdukForm")[0].reset();
    $("[id^=create_]").addClass("hidden").text("");
}

$("#createProdukForm").on("submit", function (e) {
    e.preventDefault();

    const form = $(this)[0];
    const formData = new FormData(form);
    const btn = $("#createProdukSubmitBtn");

    // Reset errors
    $("[id$='-error']").addClass("hidden").text("");

    // Validasi file di client side
    const fileInput = $("#createImage")[0];
    if (fileInput.files[0] && fileInput.files[0].size > 2097152) {
        $("#create_image-error")
            .removeClass("hidden")
            .text("Ukuran image maksimal 2MB");
        return;
    }

    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.PRODUK_STORE_URL,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            resetCreateForm();
            closeCreateProdukModal();
            reloadProdukTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "Produk berhasil ditambahkan",
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
