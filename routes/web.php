<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');

});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::get('/{category_id}/edit', [CategoryController::class, 'edit']);

});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::post('/store', [ProductController::class, 'store'])->name('products.store');
    Route::post('/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/{product_id}/edit', [ProductController::class, 'edit']);
    Route::post('/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
});