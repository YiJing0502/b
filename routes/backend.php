<?php

use App\Http\Controllers\ProductController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Backend/Dashboard');
    })->name('dashboard');
    // 後台＿產品列表頁
    Route::get('/product', [ProductController::class, 'index'])->name('product.list');
    // 後台＿新增產品頁
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    // 後台＿新增產品頁＿儲存新增
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
});
