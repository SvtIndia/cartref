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
        /* Once per minute */
        Route::get('/every-min',[CronJobController::class, 'oncePerMinute']);

        Route::get('/order-fifteen-min',[CronJobController::class, 'showcaseOrderFifteenMin']);
        Route::get('/order-thirty-min',[CronJobController::class, 'showcaseOrderThirtyMin']);
    });
});