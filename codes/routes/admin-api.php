<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/wishlist', [WishlistController::class, 'fetchWishlists']);
    Route::get('/cart', [CartController::class, 'fetchCarts']);

    Route::resource('/category', CategoryController::class);
});
