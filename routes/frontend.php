<?php

use App\Http\Controllers\FrontController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'home'])->name('home');
