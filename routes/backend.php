<?php

use App\Http\Controllers\ProductController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Backend/Dashboard');
    })->name('dashboard');
    // 產品列表
    Route::get('/product', [ProductController::class, 'index'])->name('product.list');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
});
