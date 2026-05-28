<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;

// ─────────────────────────────────────────────
//  PUBLIC ROUTES
// ─────────────────────────────────────────────
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{id}', [CatalogController::class, 'show'])->name('catalog.show');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post')->middleware('guest');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Invoice (public: customer bisa lihat tanpa login)
Route::get('/invoice/{code}', [InvoiceController::class, 'show'])->name('invoice.show');

// ─────────────────────────────────────────────
//  AUTHENTICATED ROUTES
// ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Akun / Profile
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/akun', [AkunController::class, 'update'])->name('akun.update');

    // Cart Actions
    Route::post('/cart/add', [CatalogController::class, 'cartAdd'])->name('cart.add');
    Route::post('/cart/update', [CatalogController::class, 'cartUpdate'])->name('cart.update');
    Route::post('/cart/remove', [CatalogController::class, 'cartRemove'])->name('cart.remove');
    Route::post('/cart/clear', [CatalogController::class, 'cartClear'])->name('cart.clear');
    Route::post('/cart/checkout', [CatalogController::class, 'checkout'])->name('cart.checkout');
});

// ─────────────────────────────────────────────
//  ADMIN ROUTES
// ─────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Order actions
    Route::post('/orders/complete', [AdminController::class, 'completeOrder'])->name('orders.complete');
    Route::post('/orders/cancel', [AdminController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{order}/details', [AdminController::class, 'orderDetails'])->name('orders.details');

    // Product CRUD
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    // Export
    Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
});
