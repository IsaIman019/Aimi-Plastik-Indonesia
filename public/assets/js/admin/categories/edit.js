window.openEditModal = function (data) {
    $("#edit_id").val(data.id);
    $("#edit_nama").val(data.nama);
    $("#edit_deskripsi").val(data.deskripsi ?? "");
    $("#edit_status").val(data.status);

    $("[id^=edit_][id$=-error]").addClass("hidden").text("");

    $("#editKategoriModal").removeClass("hidden");
    $("body").css("overflow", "hidden");
};

window.closeEditKategoriModal = function () {
    $("#editKategoriModal").addClass("hidden");
    $("body").css("overflow", "auto");
};

$("#editKategoriForm").on("submit", function (e) {
    e.preventDefault();

    const id = $("#edit_id").val();
    const btn = $("#editKategoriSubmitBtn");

    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.KATEGORI_UPDATE_URL.replace(":id", id),
        method: "POST",
        data: $(this).serialize(),
        headers: { "X-HTTP-Method-Override": "PUT" },
        success: function () {
            closeEditKategoriModal();
            reloadKategoriTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "Kategori berhasil diperbarui",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                Object.entries(xhr.responseJSON.errors).forEach(
                    ([key, val]) => {
                        $("#edit_" + key + "-error")
                            .removeClass("hidden")
                            .text(val[0]);
                    }
                );
            }
        },
        complete: function () {
            btn.prop("disabled", false).text("Simpan");
        },
    });
});
