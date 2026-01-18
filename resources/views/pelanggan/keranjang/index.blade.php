@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">🛒 Keranjang Belanja</h1>
                <p class="text-gray-600 mt-2">Total <span id="total-items-header">{{ $keranjangs->count() }}</span>
                    jenis produk di keranjang</p>
            </div>
            <a href="{{ route('pelanggan.produk') }}"
                class="flex items-center text-orange-600 hover:text-orange-700 font-medium">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Lanjut Belanja
            </a>
        </div>

        <!-- Session Messages -->
        @if(session('success'))
        <div id="success-message"
            class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm transition-opacity duration-500">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Cart Content -->
        @if($keranjangs->count() > 0)
        <div id="cart-container" class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block">
                <div
                    class="grid grid-cols-12 bg-gray-50 text-gray-600 text-sm font-semibold uppercase tracking-wider py-4 px-6">
                    <div class="col-span-6">Produk</div>
                    <div class="col-span-2 text-center">Harga</div>
                    <div class="col-span-2 text-center">Jumlah</div>
                    <div class="col-span-1 text-right">Subtotal</div>
                    <div class="col-span-1 text-center">Aksi</div>
                </div>

                <div class="divide-y divide-gray-100">
                    @php $grandTotal = 0; @endphp
                    @foreach($keranjangs as $keranjang)
                    @php
                    $subtotal = $keranjang->produk->harga * $keranjang->qty;
                    $grandTotal += $subtotal;
                    @endphp
                    <div id="cart-item-{{ $keranjang->id }}" data-product-price="{{ $keranjang->produk->harga }}"
                        class="grid grid-cols-12 items-center py-6 px-6 hover:bg-gray-50 transition duration-200">
                        <!-- Info Produk -->
                        <div class="col-span-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                                    @if($keranjang->produk->image)
                                    <img src="{{ asset('storage/' . $keranjang->produk->image) }}"
                                        class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">N/A</div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $keranjang->produk->nama }}</h3>
                                    <span
                                        class="text-xs font-medium bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full">
                                        {{ $keranjang->produk->kategori->nama ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Harga Satuan -->
                        <div class="col-span-2 text-center font-bold text-gray-900">
                            Rp {{ number_format($keranjang->produk->harga, 0, ',', '.') }}
                        </div>

                        <!-- Quantity -->
                        <div class="col-span-2">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" onclick="updateQuantity({{ $keranjang->id }}, -1)"
                                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-100">-</button>
                                <input type="number" id="quantity-{{ $keranjang->id }}" value="{{ $keranjang->qty }}"
                                    min="1" max="{{ $keranjang->produk->stok }}"
                                    class="w-16 border border-gray-300 rounded-lg text-center font-bold py-1"
                                    onchange="updateQuantity({{ $keranjang->id }}, 0, this.value)">
                                <button type="button" onclick="updateQuantity({{ $keranjang->id }}, 1)"
                                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-100">+</button>
                            </div>
                        </div>

                        <!-- Subtotal -->
                        <div class="col-span-1 text-right font-bold text-gray-900">
                            Rp <span
                                id="subtotal-{{ $keranjang->id }}">{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <!-- Hapus -->
                        <div class="col-span-1 text-center">
                            <button onclick="removeItem({{ $keranjang->id }})" class="text-red-500 hover:text-red-700">
                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($keranjangs as $keranjang)
                <div id="cart-item-mobile-{{ $keranjang->id }}" data-product-price="{{ $keranjang->produk->harga }}"
                    class="p-4">
                    <div class="flex space-x-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/' . $keranjang->produk->image) }}"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-gray-900 text-sm">{{ $keranjang->produk->nama }}</h3>
                                <button onclick="removeItem({{ $keranjang->id }})" class="text-red-500"><svg
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg></button>
                            </div>
                            <p class="text-gray-600 text-sm mt-1">Rp
                                {{ number_format($keranjang->produk->harga, 0, ',', '.') }}</p>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center space-x-2">
                                    <button onclick="updateQuantity({{ $keranjang->id }}, -1)"
                                        class="w-7 h-7 border rounded">-</button>
                                    <input type="number" id="quantity-mobile-{{ $keranjang->id }}"
                                        value="{{ $keranjang->qty }}"
                                        class="w-10 text-center text-sm font-bold border-none" readonly>
                                    <button onclick="updateQuantity({{ $keranjang->id }}, 1)"
                                        class="w-7 h-7 border rounded">+</button>
                                </div>
                                <div class="font-bold text-gray-900">Rp <span
                                        id="subtotal-mobile-{{ $keranjang->id }}">{{ number_format($keranjang->produk->harga * $keranjang->qty, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="bg-gray-50 px-6 py-8 border-t border-gray-200">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                    <div class="w-full lg:w-1/3">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Ringkasan Belanja</h3>
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item</span>
                            <span id="summary-item-count" class="font-bold">{{ $keranjangs->sum('qty') }} item</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 mt-2">
                            <span>Total Harga</span>
                            <span>Rp <span id="grand-total">{{ number_format($grandTotal, 0, ',', '.') }}</span></span>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 flex flex-col sm:flex-row gap-4">
                        <button onclick="clearCart()"
                            class="flex-1 px-6 py-3 border-2 border-red-500 text-red-500 rounded-xl font-bold hover:bg-red-50 transition-all">
                            Kosongkan Keranjang
                        </button>
                        <a href="{{ route('checkout.index') }}"
                            class="flex-1 px-6 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-orange-600 text-center transition-all shadow-lg">
                            Checkout Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @else
        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="w-48 h-48 mx-auto mb-6 opacity-20">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Keranjang Masih Kosong</h3>
            <p class="text-gray-500 mt-2 mb-8">Yuk cari produk impianmu dan mulai belanja!</p>
            <a href="{{ route('pelanggan.produk') }}"
                class="inline-flex items-center px-8 py-3 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition-all">
                Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// 1. Fungsi Update Quantity (dengan Debounce)
let debounceTimer;

function updateQuantity(cartId, change, newValue = null) {
    clearTimeout(debounceTimer);

    const input = document.getElementById(`quantity-${cartId}`);
    const mobileInput = document.getElementById(`quantity-mobile-${cartId}`);
    const maxStock = parseInt(input.max);
    let currentQty = parseInt(input.value);

    let newQty = (newValue !== null) ? parseInt(newValue) : (currentQty + change);

    // Validasi
    if (newQty < 1) newQty = 1;
    if (newQty > maxStock) {
        newQty = maxStock;
        showToast('error', `Stok maksimal hanya ${maxStock}`);
    }

    // Update tampilan input sementara
    input.value = newQty;
    if (mobileInput) mobileInput.value = newQty;

    debounceTimer = setTimeout(async () => {
        try {
            const response = await fetch(`/pelanggan/keranjang/${cartId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: newQty
                })
            });

            if (response.ok) {
                updateSubtotal(cartId, newQty);
                updateGrandTotal();
            } else {
                const data = await response.json();
                showToast('error', data.message || 'Gagal update');
            }
        } catch (error) {
            showToast('error', 'Koneksi error');
        }
    }, 500);
}

// 2. Update Subtotal Real-time
function updateSubtotal(cartId, qty) {
    const item = document.getElementById(`cart-item-${cartId}`);
    const price = parseInt(item.dataset.productPrice);
    const subtotal = price * qty;

    const subtotalElement = document.getElementById(`subtotal-${cartId}`);
    const mobileSubtotalElement = document.getElementById(`subtotal-mobile-${cartId}`);

    if (subtotalElement) subtotalElement.textContent = subtotal.toLocaleString('id-ID');
    if (mobileSubtotalElement) mobileSubtotalElement.textContent = subtotal.toLocaleString('id-ID');
}

// 3. Update Grand Total & Counter
function updateGrandTotal() {
    let grandTotal = 0;
    let totalItems = 0;
    let uniqueProducts = 0;

    document.querySelectorAll('[id^="cart-item-"]:not([id*="mobile"])').forEach(item => {
        const cartId = item.id.replace('cart-item-', '');
        const price = parseInt(item.dataset.productPrice);
        const qty = parseInt(document.getElementById(`quantity-${cartId}`).value);

        grandTotal += (price * qty);
        totalItems += qty;
        uniqueProducts++;
    });

    document.getElementById('grand-total').textContent = grandTotal.toLocaleString('id-ID');
    document.getElementById('summary-item-count').textContent = totalItems + ' item';
    document.getElementById('total-items-header').textContent = uniqueProducts;

    if (uniqueProducts === 0) location.reload();
}

// 4. Hapus Satu Item
async function removeItem(cartId) {
    const result = await Swal.fire({
        title: 'Hapus item?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!'
    });

    if (result.isConfirmed) {
        const response = await fetch(`/pelanggan/keranjang/${cartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        if (response.ok) {
            document.getElementById(`cart-item-${cartId}`).remove();
            document.getElementById(`cart-item-mobile-${cartId}`)?.remove();
            updateGrandTotal();
            showToast('success', 'Item dihapus');
        }
    }
}

// 5. Kosongkan Keranjang
async function clearCart() {
    const result = await Swal.fire({
        title: 'Kosongkan keranjang?',
        text: "Semua item akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Kosongkan!'
    });

    if (result.isConfirmed) {
        const response = await fetch('{{ route("keranjang.clear") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        if (response.ok) location.reload();
    }
}

function showToast(icon, title) {
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    }).fire({
        icon,
        title
    });
}

// Auto-hide success message
setTimeout(() => {
    const msg = document.getElementById('success-message');
    if (msg) msg.style.opacity = '0';
}, 3000);
</script>

<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
</style>
@endsection
