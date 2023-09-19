<?php

use App\Http\Controllers\ProductController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Backend/Dashboard');
    })->name('dashboard');
    // 產品
    Route::prefix('/product')->group(function () {
        // 後台＿產品列表頁
        Route::get('/', [ProductController::class, 'index'])->name('product.list');
        // 後台＿新增產品頁
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        // 後台＿新增產品頁＿儲存新增
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        // 後台＿編輯產品頁
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        // 後台＿編輯產品頁_儲存編輯
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        // 後台＿刪除產品
        Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    });
});
