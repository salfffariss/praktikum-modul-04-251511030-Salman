<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return redirect()->route('tugas2.index');
});

Route::prefix('tugas2')->group(function () {
    Route::get('/index', [CartController::class, 'index'])->name('tugas2.index');
    Route::get('/keranjang', [CartController::class, 'keranjang'])->name('tugas2.keranjang');
    Route::get('/tambah/{id}', [CartController::class, 'tambah'])->name('tugas2.tambah');
    Route::get('/tambah-qty/{id}', [CartController::class, 'tambahJumlah'])->name('tugas2.tambahQty');
    Route::get('/kurang-qty/{id}', [CartController::class, 'kurangiJumlah'])->name('tugas2.kurangQty');
    Route::get('/hapus/{id}', [CartController::class, 'hapus'])->name('tugas2.hapus');
    Route::get('/kosongkan', [CartController::class, 'kosongkan'])->name('tugas2.kosongkan');
});
