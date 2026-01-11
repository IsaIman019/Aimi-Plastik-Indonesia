window.openEditModal = function (data) {
    window.openEditUserModal(data);
};
window.openEditUserModal = function (data) {
    $("#edit_id").val(data.id);
    $("#edit_nama").val(data.nama);
    $("#edit_email").val(data.email);
    $("#edit_phone").val(data.phone ?? "");
    $("#edit_role").val(data.role);
    $("#edit_status").val(data.status);

    $("[id^=edit_][id$=-error]").addClass("hidden").text("");

    $("#editUserModal").removeClass("hidden");
    $("body").css("overflow", "hidden");
};

window.closeEditUserModal = function () {
    $("#editUserModal").addClass("hidden");
    $("body").css("overflow", "auto");
};

$("#editUserForm").on("submit", function (e) {
    e.preventDefault();

    const id = $("#edit_id").val();
    const btn = $("#editUserSubmitBtn");
    const text = $("#editUserSubmitText");

    $("[id^=edit_][id$=-error]").addClass("hidden").text("");

    btn.prop("disabled", true);
    text.html(`
        <div class="flex items-center gap-2">
            <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
            <span>Menyimpan...</span>
        </div>
    `);

    $.ajax({
        url: window.USERS_UPDATE_URL.replace(":id", id),
        method: "POST",
        data: $(this).serialize(),
        headers: { "X-HTTP-Method-Override": "PUT" },
        success: function () {
            closeEditUserModal();
            reloadUsersTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "User berhasil diperbarui",
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
            btn.prop("disabled", false);
            text.html(`
                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            `);
        },
    });
});
