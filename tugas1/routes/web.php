<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

// Redirect halaman awal langsung ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route untuk yang BELUM login (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route yang DILINDUNGI (harus login / auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Ubah Role (Hanya Admin dengan ability 'manage-roles')
    Route::patch('/admin/users/{user}/role', [RoleController::class, 'update'])
        ->middleware('can:manage-roles')
        ->name('admin.users.role.update');

    // Simulasi Route Keranjang W06 (Hanya Customer dengan ability 'use-cart')
    Route::post('/cart/add', function () {
        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang (stateless)']);
    })->middleware('can:use-cart')->name('cart.add');
});