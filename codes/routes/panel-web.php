<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth','admin'])->get('{any}', function ($any) {
    return view('panel.admin.app');
})->where('any', '.*');
