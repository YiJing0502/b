<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\CartController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/product', [FrontController::class, 'product'])->name('product');
Route::get('/menu', [FrontController::class, 'menu'])->name('menu');

Route::middleware(['auth', 'verified'])->group(function () {
    // 新增購物車
    Route::post('/addCart', [FrontController::class, 'addCart'])->name('product.addCart');
    // 查看購物車清單
    Route::get('/shopCart', [CartController::class, 'shopCart'])->name('shopCart');
});
