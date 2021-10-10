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
    Route::get('/', 'UserProfileController@index')->name('user_profile_list');
    Route::get('/view', 'UserProfileController@show')->name('user_profile');
    Route::get('/update',[UserProfileController::class,'edit'])->name('profile_update');
    Route::post('/update',[UserProfileController::class,'update'])->name('profile_update');
    Route::get('/data',[UserProfileController::class,'UserProfileData'])->name('user_profile_data');
    Route::get('/admin/{id}/view', 'UserProfileController@Adminshow')->name('user_profile_admin');
    Route::get('/admin/{id}/edit', 'UserProfileController@AdminEdit')->name('user_profile_edit');
    Route::post('/admin/{id}/edit', 'UserProfileController@AdminEdit')->name('user_profile_edit');

});
