<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('remove_acc', [AuthController::class, 'remove_acc'])->name('remove_acc');
    Route::resource('order', OrderController::class);
});
Route::resource('produk', ProdukController::class);
Route::resource('kategori', KategoriController::class);
Route::get('orders/report', [OrderController::class, 'report'])->name('report');