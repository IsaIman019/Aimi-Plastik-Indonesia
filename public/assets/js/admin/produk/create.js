window.openCreateModal = function () {
    resetCreateForm();
    document.getElementById("createUserModal").classList.remove("hidden");
    document.body.style.overflow = "hidden";
};

function closeCreateUserModal() {
    $("#createUserModal").addClass("hidden");
    document.body.style.overflow = "auto";
}

function resetCreateForm() {
    $("#createUserForm")[0].reset();
    $("[id^=create_]").addClass("hidden").text("");
}

$("#createUserForm").on("submit", function (e) {
    e.preventDefault();
    const btn = $("#createSubmitBtn");
    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.USERS_STORE_URL,
        method: "POST",
        data: $(this).serialize(),
        success: function () {
            resetCreateForm();
            closeCreateUserModal();
            reloadUsersTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "User berhasil ditambahkan",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
            });
        },
        error: function (xhr) {
            console.log(xhr.responseText);
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
