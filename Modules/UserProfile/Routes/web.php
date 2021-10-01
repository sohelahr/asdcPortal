<?php

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

use Modules\UserProfile\Http\Controllers\UserProfileController;

Route::prefix('userprofile')->group(function() {
    Route::get('/', 'UserProfileController@index');
    Route::get('/update',[UserProfileController::class,'edit'])->name('profile_update');
    Route::post('/update',[UserProfileController::class,'update'])->name('profile_update');

});
