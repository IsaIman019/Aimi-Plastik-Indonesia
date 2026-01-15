window.openEditModal = function (data) {
    $("#editProdukForm")[0].reset();
    $("#editImagePreview").addClass("hidden");
    $("[id^=edit_][id$=-error]").addClass("hidden").text("");

    window.currentEditImage = data.image || null;

    $("#edit_id").val(data.id);
    $("#edit_nama").val(data.nama);
    $("#edit_kategori_id").val(data.kategori_id);
    $("#edit_deskripsi").val(data.deskripsi);
    $("#edit_varian_id").val(data.varian_id);
    $("#edit_harga").val(data.harga);
    $("#edit_stok").val(data.stok);
    $("#edit_berat").val(data.berat);
    $("#edit_panjang").val(data.panjang);
    $("#edit_lebar").val(data.lebar);
    $("#edit_tinggi").val(data.tinggi);
    $("#edit_status").val(data.status);

    const currentImageDiv = $("#editCurrentImage");
    currentImageDiv.empty();

    if (data.image) {
        const imageUrl = data.image.startsWith("http")
            ? data.image
            : "/storage/" + data.image;
        currentImageDiv.html(`
            <div id="currentImageContainer">
                <p class="text-sm text-gray-600 mb-2">Image Saat Ini:</p>
                <div class="relative inline-block">
                    <img src="${imageUrl}"
                         alt="${data.nama || "Image Produk"}"
                         class="w-40 h-32 object-cover rounded-lg border border-gray-200"
                         id="editCurrentImageDisplay">
                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 rounded-lg transition-all duration-200 flex items-center justify-center opacity-0 hover:opacity-100 cursor-pointer"
                         onclick="showImageModal('${imageUrl}', '${
            data.nama
        }')">
                        <span class="text-white text-xs font-medium bg-black bg-opacity-50 px-2 py-1 rounded">Lihat</span>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500" id="currentImageNote">
                    Upload image baru untuk mengganti
                </p>
            </div>
        `);
    } else {
        currentImageDiv.html(`
            <div id="currentImageContainer">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Tidak ada image</span>
                </div>
                <p class="mt-1 text-xs text-gray-500" id="currentImageNote">
                    Upload image baru
                </p>
            </div>
        `);
    }

    $("#editProdukModal").removeClass("hidden");
    $("body").css("overflow", "hidden");
};

$(document).on("change", "#edit_image", function (e) {
    const file = this.files[0];
    const preview = $("#editImagePreview");
    const previewImg = $("#editPreviewImage");
    const currentImageContainer = $("#currentImageContainer");

    if (file) {
        if (file.size > 2097152) {
            Swal.fire({
                icon: "error",
                title: "Ukuran file terlalu besar",
                text: "Maksimal 2MB",
                toast: true,
                position: "top-end",
                timer: 3000,
            });
            $(this).val("");
            preview.addClass("hidden");
            return;
        }

        const validTypes = [
            "image/jpeg",
            "image/png",
            "image/jpg",
            "image/gif",
            "image/webp",
        ];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: "error",
                title: "Format tidak didukung",
                text: "Hanya JPEG, PNG, JPG, GIF, WEBP",
                toast: true,
                position: "top-end",
                timer: 3000,
            });
            $(this).val("");
            preview.addClass("hidden");
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.attr("src", e.target.result);
            preview.removeClass("hidden");

            // Sembunyikan/sorot image lama
            if (currentImageContainer.length) {
                $("#editCurrentImageDisplay").addClass("opacity-50");
                $("#currentImageNote").html(`
                    <span class="text-amber-600 font-medium">⚠ Image akan diganti</span>
                    <span class="text-gray-500 block text-xs mt-1">
                        Image sebelumnya akan dihapus saat disimpan
                    </span>
                `);

                if (!$("#imageChangeWarning").length) {
                    currentImageContainer.append(`
                        <div id="imageChangeWarning" class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded">
                            <p class="text-amber-800 text-xs">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Image baru telah dipilih
                            </p>
                        </div>
                    `);
                }
            }
        };
        reader.readAsDataURL(file);
    } else {
        preview.addClass("hidden");
        // Pulihkan tampilan image lama
        restoreCurrentImage();
    }
});

// Pulihkan tampilan image saat ini
function restoreCurrentImage() {
    $("#editCurrentImageDisplay").removeClass("opacity-50");
    $("#imageChangeWarning").remove();

    const currentImageNote = $("#currentImageNote");
    if (currentImageNote.length) {
        if (window.currentEditImage) {
            currentImageNote.html("Upload image baru untuk mengganti");
        } else {
            currentImageNote.html("Upload image baru");
        }
    }
}

// Hapus preview image baru
window.removeEditImagePreview = function () {
    $("#edit_image").val("");
    $("#editImagePreview").addClass("hidden");
    restoreCurrentImage();
};

window.closeEditProdukModal = function () {
    $("#editProdukModal").addClass("hidden");
    $("body").css("overflow", "auto");

    // Reset preview
    $("#editImagePreview").addClass("hidden");
    restoreCurrentImage();
};

// Submit form edit
$("#editProdukForm").on("submit", function (e) {
    e.preventDefault();
    console.log("Edit form submitted");

    const id = $("#edit_id").val();
    const btn = $("#editProdukSubmitBtn");

    // Reset errors
    $("[id^=edit_][id$=-error]").addClass("hidden").text("");

    // Validasi file jika ada
    const fileInput = document.getElementById("edit_image");
    if (fileInput.files[0] && fileInput.files[0].size > 2097152) {
        $("#edit_image-error")
            .removeClass("hidden")
            .text("Ukuran image maksimal 2MB");
        btn.prop("disabled", false).text("Simpan");
        return;
    }

    const formData = new FormData(this);
    formData.append("_method", "PUT");

    // Debug: log FormData contents
    console.log("FormData entries:");
    for (let pair of formData.entries()) {
        console.log(pair[0] + ": ", pair[1]);
    }

    btn.prop("disabled", true).text("Menyimpan...");

    $.ajax({
        url: window.PRODUK_UPDATE_URL.replace(":id", id),
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { "X-HTTP-Method-Override": "PUT" },
        success: function () {
            closeEditProdukModal();
            reloadProdukTable();

            Swal.fire({
                toast: true,
                icon: "success",
                title: "Produk berhasil diperbarui",
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
