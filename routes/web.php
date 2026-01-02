<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// =================================================================
// 1. IMPORTS CONTROLLERS
// =================================================================

// A. Auth & Public
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicBlogController; 
use App\Http\Controllers\Pelanggan\CallbackController;
use App\Models\Product; 
use App\Models\News;    

// B. Controllers Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;

// C. Controllers Pelanggan
use App\Http\Controllers\Pelanggan\ProductController as PelangganProductController;
use App\Http\Controllers\Pelanggan\CartController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrderController;
use App\Http\Controllers\Pelanggan\ProfileController;
use App\Http\Controllers\Pelanggan\AddressController; // (BARU) Controller Alamat


// =================================================================
// 2. LANDING PAGE & HALAMAN PUBLIK
// =================================================================

// Halaman Utama (Welcome)
Route::get('/', function () {
    $featuredProducts = Product::where('is_featured', true)->where('is_active', true)->take(4)->get();
    $latestNews = collect([]);
    try { $latestNews = News::where('is_active', true)->latest()->take(3)->get(); } catch (\Exception $e) {}

    return view('welcome', compact('featuredProducts', 'latestNews'));
})->name('home');

// Halaman Tentang Kami
Route::get('/tentang-kami', function () {
    return view('about');
})->name('about');

// HALAMAN BLOG & BERITA
Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [PublicBlogController::class, 'show'])->name('blog.show');

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
    Route::resource('/products', AdminProductController::class)->names('admin.products');
    Route::resource('/categories', AdminCategoryController::class)->names('admin.categories');
    
    Route::get('/stock', [AdminStockController::class, 'index'])->name('admin.stock.index');
    Route::post('/stock/update/{id}', [AdminStockController::class, 'update'])->name('admin.stock.update');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit'); 
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update'); 
    Route::get('/orders/{id}/resi', [AdminOrderController::class, 'cetakResi'])->name('admin.orders.resi'); 

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
    Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy'])->name('admin.transactions.destroy');

    Route::resource('/promos', AdminPromoController::class)->names('admin.promos');
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::resource('/users', AdminUserController::class)->names('admin.users');
    Route::resource('/news', AdminNewsController::class)->names('admin.news');
});


// =================================================================
// 5. ROLE: PELANGGAN
// =================================================================

Route::prefix('pelanggan')->middleware(['auth', 'role:pelanggan'])->group(function () {
    // 1. Produk & Katalog
    Route::get('/produk', [PelangganProductController::class, 'index'])->name('pelanggan.products');
    Route::get('/produk/{id}', [PelangganProductController::class, 'show'])->name('pelanggan.products.show');

    // 2. Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

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