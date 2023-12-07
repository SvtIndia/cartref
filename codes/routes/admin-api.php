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
        Route::get('/{id}', [ProductController::class, 'fetchProduct']);
        Route::put('/{id}', [ProductController::class, 'updateProductStatus']);
        Route::get('/{id}/colors', [ProductController::class, 'fetchProductColors']);

        Route::get('color/{id}', [ProductController::class, 'fetchProductColor']);
        Route::put('color/{id}', [ProductController::class, 'updateProductColorStatus']);
        Route::post('color/{id}/delete-image', [ProductController::class, 'deleteImage']);
        Route::post('color/{id}/upload-images', [ProductController::class, 'uploadImages']);

        Route::get('{product_id}/color/{color_id}/sizes', [ProductController::class, 'fetchSizesByColorId']);
        Route::get('{product_id}/color/{color_id}/sizes/{size_id}', [ProductController::class, 'fetchSizeById']);
        Route::put('{product_id}/color/{color_id}/sizes/{size_id}', [ProductController::class, 'updateSizeById']);


    });
});
