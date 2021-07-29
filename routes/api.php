<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'open'], function () {
    Route::get('/get-all-categories', [App\Http\Controllers\REST\ApiController::class, 'getAllCategories']);
    Route::get('/get-all-series', [App\Http\Controllers\REST\ApiController::class, 'getAllSeries']);
    Route::get('/get-all-videos', [App\Http\Controllers\REST\ApiController::class, 'getAllVideos']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
