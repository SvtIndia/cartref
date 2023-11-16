<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CronJobController;

/*
|--------------------------------------------------------------------------
| Cron Job Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'cron'], function () {
    Route::group(['prefix' => 'showroom-at-home'], function () {
        Route::get('/order-five-min',[CronJobController::class, 'showcaseOrderFiveMin']);
        Route::get('/order-fifteen-min',[CronJobController::class, 'showcaseOrderFifteenMin']);
        Route::get('/order-thirty-min',[CronJobController::class, 'showcaseOrderThirtyMin']);
    });
});