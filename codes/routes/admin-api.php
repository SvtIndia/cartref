<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WishlistController;

Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/wishlist', [WishlistController::class, 'fetchWishlists']);
});
