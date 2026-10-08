<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// 1. Katalog Barang (Publik - Boleh dilihat tanpa login)
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// 2. Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Tambah ke keranjang (Bisa diklik siapa saja, tapi divalidasi login di controller)
Route::get('/tambah-keranjang/{id_barang}', [CartController::class, 'tambah'])->name('cart.add');

// 4. Fitur yang Membutuhkan Login (Keranjang, Checkout, Riwayat Pesanan)
Route::middleware('auth')->group(function () {
    // Shopping Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::get('/keranjang/tambah-qty/{id_barang}', [CartController::class, 'tambahQty'])->name('cart.tambahQty');
    Route::get('/keranjang/kurang-qty/{id_barang}', [CartController::class, 'kurangQty'])->name('cart.kurangQty');
    Route::get('/keranjang/hapus/{id_barang}', [CartController::class, 'hapus'])->name('cart.hapus');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'prosesCheckout'])->name('checkout.process');

    // Riwayat Pesanan
    Route::get('/pesanan', [OrderController::class, 'riwayatPesanan'])->name('orders.index');
});
