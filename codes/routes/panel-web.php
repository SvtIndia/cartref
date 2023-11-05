<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('{any}', function () {
        return view('panel.admin.app');
    })->where('any', '.*');

    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
});
