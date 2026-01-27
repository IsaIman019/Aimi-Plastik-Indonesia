let appliedPromos = [];
let totalDiscount = 0;

document.addEventListener("DOMContentLoaded", function () {
    const selectAll = document.getElementById("select-all");
    const items = document.querySelectorAll(".cart-checkbox");
    if (selectAll) {
        selectAll.checked = true;
        items.forEach((cb) => (cb.checked = true));
    }
    selectAll?.addEventListener("change", function () {
        items.forEach((cb) => (cb.checked = this.checked));
        hitungTotal();
        applyPromoCalculation();
    });
    items.forEach((cb) => {
        cb.addEventListener("change", function () {
            const allChecked = [...items].every((i) => i.checked);
            selectAll.checked = allChecked;
            hitungTotal();
            applyPromoCalculation();
        });
    });

    hitungTotal();
});

function updateQuantity(id, change, manualQty = null) {
    let qtyInput = document.getElementById(`quantity-${id}`);
    let qtyMobile = document.getElementById(`quantity-mobile-${id}`);

    let currentQty = parseInt(
        (qtyInput && qtyInput.value) || (qtyMobile && qtyMobile.value)
    );

    let qty = manualQty ? parseInt(manualQty) : currentQty + change;
    if (qty < 1) qty = 1;

    fetch(`/pelanggan/keranjang/${id}`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ qty }),
    })
        .then((res) => res.json())
        .then(() => {
            if (qtyInput) qtyInput.value = qty;
            if (qtyMobile) qtyMobile.value = qty;

            let price = document.getElementById(`cart-item-${id}`).dataset
                .productPrice;
            let subtotal = price * qty;

            const el = document.getElementById(`subtotal-${id}`);
            if (el) {
                el.innerText = subtotal.toLocaleString("id-ID");
            }

            const elMobile = document.getElementById(`subtotal-mobile-${id}`);
            if (elMobile) {
                elMobile.innerText = subtotal.toLocaleString("id-ID");
            }

            hitungTotal();
            applyPromoCalculation();
        });
}

function hitungTotal() {
    let subtotal = 0;

    document.querySelectorAll(".cart-checkbox:checked").forEach((cb) => {
        const id = cb.dataset.id;
        const qty = parseInt(document.getElementById(`quantity-${id}`).value);
        const price = parseInt(cb.dataset.price);
        subtotal += price * qty;
    });

    document.getElementById("grand-total").innerText =
        subtotal.toLocaleString("id-ID");

    applyPromoCalculation(subtotal);
}

function removeItem(id) {
    Swal.fire({
        title: "Hapus produk?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya",
    }).then((res) => {
        if (res.isConfirmed) {
            fetch(`/pelanggan/keranjang/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            }).then(() => {
                document.getElementById(`cart-item-${id}`)?.remove();
                document.getElementById(`cart-item-mobile-${id}`)?.remove();
                hitungTotal();
                applyPromoCalculation();
            });
        }
    });
}

function closePromo() {
    document.getElementById("promoModal").classList.add("hidden");
}

function openPromo() {
    let produkIds = [];

    document.querySelectorAll(".cart-checkbox:checked").forEach((cb) => {
        produkIds.push(cb.dataset.produkId);
    });

    if (produkIds.length === 0) {
        Swal.fire("Oops", "Pilih minimal 1 produk", "warning");
        return;
    }

    fetch("/pelanggan/keranjang/promo", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            produk_ids: produkIds,
        }),
    })
        .then((res) => res.json())
        .then((data) => {
            window.lastPromos = data;
            renderPromo(data);
        });

    document.getElementById("promoModal").classList.remove("hidden");
}

function renderPromo(promos) {
    let container = document.getElementById("promoList");
    if (!container) return;

    container.innerHTML = "";

    if (promos.length === 0) {
        container.innerHTML = `
            <p class="text-center text-gray-500 py-6">
                Tidak ada promo untuk produk terpilih
            </p>`;
        return;
    }

    promos.forEach((promo) => {
        const isSelected = appliedPromos.some((p) => p.id === promo.id);

        container.innerHTML += `
        <div
            onclick="togglePromo(${promo.id}, ${promo.jumlah})"
            class="relative mb-4">

            <!-- COAKAN KIRI -->
            <span class="absolute -left-3 top-1/2 -translate-y-1/2
                w-6 h-6 rounded-full bg-white z-20"></span>

            <!-- COAKAN KANAN -->
            <span class="absolute -right-3 top-1/2 -translate-y-1/2
                w-6 h-6 rounded-full bg-white z-20"></span>

            <!-- KUPON -->
            <div
                class="relative cursor-pointer rounded-2xl p-4
                    border transition-all overflow-hidden
                    ${
                        isSelected
                            ? "bg-orange-600 text-white border-orange-600 shadow-md"
                            : "bg-white text-orange-600 border-orange-300 hover:bg-orange-50"
                    }">

                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-wide opacity-80">
                            Promo
                        </p>
                        <h4 class="font-bold text-lg leading-tight">
                            ${promo.nama}
                        </h4>
                    </div>

                    <div class="text-center border-l pl-4
                        ${isSelected ? "border-orange-400" : "border-orange-200"}">
                        <p class="text-3xl font-extrabold leading-none">
                            ${promo.jumlah}%
                        </p>
                        <p class="text-xs uppercase">OFF</p>
                    </div>
                </div>
            </div>
        </div>`;
    });
}

function togglePromo(id, jumlah) {
    const index = appliedPromos.findIndex((p) => p.id === id);

    if (index >= 0) {
        appliedPromos.splice(index, 1);
    } else {
        appliedPromos.push({ id, jumlah });
    }

    applyPromoCalculation();
    renderPromo(window.lastPromos);
}

function applyPromoCalculation(subtotal = null) {
    if (subtotal === null) {
        subtotal = 0;
        document.querySelectorAll(".cart-checkbox:checked").forEach((cb) => {
            const id = cb.dataset.id;
            const qty = parseInt(
                document.getElementById(`quantity-${id}`).value
            );
            const price = parseInt(cb.dataset.price);
            subtotal += price * qty;
        });
    }

    let discount = 0;

    appliedPromos.forEach((promo) => {
        discount += subtotal * (promo.jumlah / 100);
    });

    totalDiscount = Math.floor(discount);

    document.getElementById("promo-discount").innerText =
        totalDiscount.toLocaleString("id-ID");

    document.getElementById("final-total").innerText = (
        subtotal - totalDiscount
    ).toLocaleString("id-ID");

    document.getElementById("promo-used").innerText =
        `${appliedPromos.length} promo terpakai`;
}
