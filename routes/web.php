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

Route::get('/upload-video', [UploadsController::class, 'uploadVideo'])->name('upload.video')->middleware('is_admin');
Route::post('/save-video',  [UploadsController::class, 'saveVideo'])->name('save.video')->middleware('is_admin');
#Route::get('/test',  [UploadsController::class, 'uploadVideo1'])->name('test');
Auth::routes(['register=>false']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'master'], function () {
    Route::get('/category', [App\Http\Controllers\Master\CategoryController::class, 'index'])->name('master.category')->middleware('is_admin');
    Route::post('/category/store', [App\Http\Controllers\Master\CategoryController::class, 'store'])->name('master.category.store')->middleware('is_admin');
    Route::get('/category/edit/{id}', [App\Http\Controllers\Master\CategoryController::class, 'edit'])->name('master.category.edit')->middleware('is_admin');
    Route::get('/episode', [App\Http\Controllers\Master\EpisodeController::class, 'create'])->name('master.episode')->middleware('is_admin');
    Route::post('/episode/store', [App\Http\Controllers\Master\EpisodeController::class, 'store'])->name('master.episode.store')->middleware('is_admin');
});

Route::group(['prefix' => 'videos'], function () {
    Route::get('/index', [App\Http\Controllers\Master\EpisodeController::class, 'index'])->name('videos.episode.index')->middleware('is_admin');
    Route::get('/create/{uuid}', [App\Http\Controllers\Videos\VideoController::class, 'create'])->name('videos.episode.create')->middleware('is_admin');
    Route::get('/store', [App\Http\Controllers\Videos\VideoController::class, 'store'])->name('videos.episode.store')->middleware('is_admin');
    Route::get('/info/{id}', [App\Http\Controllers\Videos\VideoController::class, 'info'])->name('videos.episode.info')->middleware('is_admin');
    Route::post('/info/store', [App\Http\Controllers\Videos\VideoController::class, 'infoStore'])->name('videos.episode.info.store')->middleware('is_admin');
    Route::get('/list/{uuid}', [App\Http\Controllers\Videos\VideoController::class, 'list'])->name('videos.episode.list')->middleware('is_admin');
    Route::post('/delete', [App\Http\Controllers\Videos\VideoController::class, 'destroy'])->name('videos.episode.delete')->middleware('is_admin');
    Route::get('/edit/{uuid}', [App\Http\Controllers\Videos\VideoController::class, 'edit'])->name('videos.episode.edit')->middleware('is_admin');
    Route::post('/update', [App\Http\Controllers\Videos\VideoController::class, 'update'])->name('videos.episode.update')->middleware('is_admin');
});



