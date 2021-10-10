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

Route::prefix('coursebatch')->group(function() {
    Route::get('/', 'CourseBatchController@index')->name('coursebatch_list');
    Route::get('/create','CourseBatchController@create');
    Route::post('/create','CourseBatchController@store');
    Route::get('/edit/{id}','CourseBatchController@edit');
    Route::post('/edit/{id}','CourseBatchController@update');
    Route::post('/delete/{id}','CourseBatchController@destroy');
    Route::get('/changestatus/{id}','CourseBatchController@changeStatus')->name('batch_change_status');
});
