<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =================================================================
// 1. IMPORTS CONTROLLERS
// =================================================================

// A. Auth & Public
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicArtikelController;
use App\Http\Controllers\Pelanggan\CallbackController;
use App\Models\Artikel;

// B. Controllers Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\GeneralController as AdminGeneralController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StokController as AdminStokController;
use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\KategoriController;
// C. Controllers Pelanggan
use App\Http\Controllers\Pelanggan\ProdukController as PelangganProdukController;
use App\Http\Controllers\Pelanggan\KeranjangController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrderController;
use App\Http\Controllers\Pelanggan\ProfileController;
use App\Http\Controllers\Pelanggan\AddressController; // (BARU) Controller Alamat
use App\Models\Produk;

// =================================================================
// 2. LANDING PAGE & HALAMAN PUBLIK
// =================================================================

// Halaman Utama (Welcome)
Route::get('/', function () {
    $featuredProducts = Produk::where('is_featured', true)->where('status', 'ACTIVE')->take(4)->get();
    $latestArtikel = collect([]);
    try {
        $latestArtikel = Artikel::where('status', 'ACTIVE')->latest()->take(3)->get();
    } catch (\Exception $e) {
    }

    return view('welcome', compact('featuredProducts', 'latestArtikel'));
})->name('home');

// Halaman Tentang Kami
Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');

// HALAMAN BLOG & BERITA
Route::get('/artikel', [PublicArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{id}', [PublicArtikelController::class, 'show'])->name('artikel.show');
Route::get('/artikel/kategori/{id}', [PublicArtikelController::class, 'byCategory'])->name('artikel.category');

// MIDTRANS CALLBACK (Wajib Public)
Route::post('/midtrans-callback', [CallbackController::class, 'callback']);


// =================================================================
// 3. AUTHENTICATION
// =================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// =================================================================
// 4. ROLE: ADMIN
// =================================================================

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/users', AdminUserController::class)->names('admin.users');
    Route::resource('/general', AdminGeneralController::class)->names('admin.general');
    Route::resource('/kategori', AdminKategoriController::class)->names('admin.kategori');
    Route::resource('/produk', AdminProdukController::class)->names('admin.produk');

    Route::get('/stok', [AdminStokController::class, 'index'])->name('admin.stok.index');
    Route::put('/stok/{produk}', [AdminStokController::class, 'update'])
        ->name('admin.stok.update');
    Route::resource('promo', AdminPromoController::class)->names('admin.promos');;
    Route::resource('/pesanan', AdminPesananController::class)->names('admin.pesanan');
    // Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    // Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    // Route::get('/orders/{id}/resi', [AdminOrderController::class, 'cetakResi'])->name('admin.orders.resi');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
    Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy'])->name('admin.transactions.destroy');

    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::resource('/artikel', AdminArtikelController::class)->names('admin.artikel');
});


// =================================================================
// 5. ROLE: PELANGGAN
// =================================================================

Route::prefix('pelanggan')->middleware(['auth', 'role:pelanggan'])->group(function () {
    // 1. Produk & Katalog
    Route::get('/produk', [PelangganProdukController::class, 'index'])->name('pelanggan.produk');
    Route::get('/produk/{id}', [PelangganProdukController::class, 'show'])->name('pelanggan.produk.show');
    Route::get('/kategori/all', [PelangganProdukController::class, 'all'])->name('pelanggan.kategori.all');
    Route::get('/kategori/{id}', [PelangganProdukController::class, 'kategori'])->name('pelanggan.kategori.detail');

    // 2. Keranjang Belanja
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::delete('/keranjang-clear', [KeranjangController::class, 'clear'])->name('keranjang.clear');
    Route::get('/keranjang-total', [KeranjangController::class, 'getTotal'])->name('keranjang.total');
    Route::post('/keranjang/promo', [KeranjangController::class, 'getPromoByProduk'])
        ->name('keranjang.promo');

    // 3. Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // 4. Riwayat Pesanan
    Route::get('/orders', [PelangganOrderController::class, 'index'])->name('pelanggan.orders.index');
    Route::get('/orders/{id}', [PelangganOrderController::class, 'show'])->name('pelanggan.orders.show');

    // 5. PROFIL SAYA
    Route::get('/profil', [ProfileController::class, 'index'])->name('pelanggan.profile');
    Route::put('/profil', [ProfileController::class, 'update'])->name('pelanggan.profile.update');

    // 6. ALAMAT PENGIRIMAN (BARU)
    Route::get('/alamat', [AddressController::class, 'index'])->name('pelanggan.address.index');
    Route::post('/alamat', [AddressController::class, 'store'])->name('pelanggan.address.store');
    Route::put('/alamat/{id}', [AddressController::class, 'update'])->name('pelanggan.address.update');
    Route::delete('/alamat/{id}', [AddressController::class, 'destroy'])->name('pelanggan.address.destroy');
    Route::get('/alamat/utama/{id}', [AddressController::class, 'setPrimary'])->name('pelanggan.address.primary');
});
