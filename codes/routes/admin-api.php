<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StyleController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'fetchWishlists']);
    Route::get('/cart', [CartController::class, 'fetchCarts']);

    Route::resource('/category', CategoryController::class);
    Route::resource('/sub-category', SubCategoryController::class);
    Route::resource('/brand', BrandController::class);
    Route::resource('/style', StyleController::class);
    Route::resource('/gender', GenderController::class);
    Route::resource('/user', UserController::class);

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'fetchProducts']);
        Route::get('/{id}', [ProductController::class, 'fetchProduct']);
        Route::put('/{id}', [ProductController::class, 'updateProductStatus']);
        Route::get('/{id}/colors', [ProductController::class, 'fetchProductColors']);

        Route::get('color/{id}', [ProductController::class, 'fetchProductColor']);
        Route::put('color/{id}', [ProductController::class, 'updateProductColorStatus']);
        Route::post('color/{id}/delete-image', [ProductController::class, 'deleteImage']);
        Route::post('color/{id}/upload-images', [ProductController::class, 'uploadImages']);
        Route::post('color/{id}/main-image', [ProductController::class, 'uploadMainImage']);

        Route::get('{product_id}/color/{color_id}/sizes', [ProductController::class, 'fetchSizesByColorId']);
        Route::get('{product_id}/color/{color_id}/sizes/{size_id}', [ProductController::class, 'fetchSizeById']);
        Route::put('{product_id}/color/{color_id}/sizes/{size_id}', [ProductController::class, 'updateSizeById']);


    });
});
