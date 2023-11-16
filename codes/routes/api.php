<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DependentDropdownController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/shiprocket-test',function(){
    return;
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
 });

Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'namespace' => 'Api\\V1\\'], function() {
    // Route::post('/dependent-dropdown', ['uses' => 'DependentDropdownController@index', 'as' => 'dropdown']);
    Route::post('/dependent-dropdown', [ DependentDropdownController::class, 'index'])->name('dropdown');
 });

 Route::group(['prefix' => 'api'], function(){
    Route::post('/dtdc/checkservice', function(){
        $url = 'http://fareyesvc.ctbsplus.dtdc.com/ratecalapi/PincodeApiCall';

        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will dump a beauty json :3
        var_dump(json_decode($result, true));

        // { 
        // "orgPincode":"560040", 
        // "desPincode":"586103"
        // } 
            
    });
 });
 Route::get('/fetch/showroom-orders/{order_id}',[\App\Http\Controllers\ShowcaseAtHomeController::class, 'getOrder']);