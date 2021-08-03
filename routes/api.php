<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\REST\AuthController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/validate-otp', [AuthController::class, 'otp_verify']);
#Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/get-user-details', [AuthController::class, 'getUserDetails']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
