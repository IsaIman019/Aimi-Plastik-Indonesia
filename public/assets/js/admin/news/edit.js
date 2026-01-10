window.openEditModal = function (data) {
    $("#edit_id").val(data.id);
    $("#edit_key").val(data.key);
    $("#edit_value").val(data.value);
    $("#edit_description").val(data.description ?? "");
    $("#edit_status").val(data.status);

    $("[id^=edit_][id$=-error]").addClass("hidden").text("");

    $("#editNewsModal").removeClass("hidden");
    $("body").css("overflow", "hidden");
};

window.closeEditNewsModal = function () {
    $("#editNewsModal").addClass("hidden");
    $("body").css("overflow", "auto");
};

$("#editNewsForm").on("submit", function (e) {
    e.preventDefault();

    const id = $("#edit_id").val();
    const btn = $("#editNewsSubmitBtn");

    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.NEWS_UPDATE_URL.replace(":id", id),
        method: "POST",
        data: $(this).serialize(),
        headers: { "X-HTTP-Method-Override": "PUT" },
        success: function () {
            closeEditNewsModal();
            reloadNewsTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "News berhasil diperbarui",
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
