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

Route::prefix('subadmin')->middleware(['auth'])->group(function() {
    Route::get('/', 'SubAdminController@index')->name('subadmin_list');

    Route::post('/create', 'SubAdminController@store')->name('subadmin_create');
    Route::get('/edit/{id}', 'SubAdminController@edit')->name('subadmin_edit');
    Route::post('/edit/{id}', 'SubAdminController@update')->name('subadmin_edit');

    Route::post('/delete/{id}', 'SubAdminController@destroy')->name('subadmin_delete');

});
