<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/', function(){
        return 12;
    });
});
