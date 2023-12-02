<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'fetchWishlists']);
    Route::get('/cart', [CartController::class, 'fetchCarts']);

    Route::resource('/category', CategoryController::class);
    Route::resource('/sub-category', SubCategoryController::class);

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'fetchProducts']);
        Route::put('/{id}', [ProductController::class, 'updateProductStatus']);

        Route::get('/{id}', [ProductController::class, 'fetchProductColors']);
        Route::put('color/{id}', [ProductController::class, 'updateProductColorStatus']);
    });
});
