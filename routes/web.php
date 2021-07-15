<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/upload-video', [UploadsController::class, 'uploadVideo'])->name('upload.video');
Route::post('/save-video',  [UploadsController::class, 'saveVideo'])->name('save.video');

Auth::routes(['register=>false']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'master'], function () {
    Route::get('/category', [App\Http\Controllers\Master\CategoryController::class, 'index'])->name('master.category')->middleware('auth');
    Route::post('/category/store', [App\Http\Controllers\Master\CategoryController::class, 'store'])->name('master.category.store')->middleware('auth');
    Route::get('/category/edit/{id}', [App\Http\Controllers\Master\CategoryController::class, 'edit'])->name('master.category.edit')->middleware('auth');
    Route::get('/episode', [App\Http\Controllers\Master\EpisodeController::class, 'create'])->name('master.episode')->middleware('auth');
    Route::post('/episode/store', [App\Http\Controllers\Master\EpisodeController::class, 'store'])->name('master.episode.store')->middleware('auth');
});

Route::group(['prefix' => 'videos'], function () {
    Route::get('/index', [App\Http\Controllers\Master\EpisodeController::class, 'index'])->name('videos.episode.index')->middleware('auth');
    Route::get('/create/{uuid}', [App\Http\Controllers\Videos\VideoController::class, 'create'])->name('videos.episode.create')->middleware('auth');
    Route::get('/store', [App\Http\Controllers\Videos\VideoController::class, 'store'])->name('videos.episode.store')->middleware('auth');
});



