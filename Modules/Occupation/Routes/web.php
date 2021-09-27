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

Route::prefix('occupation')->group(function() {
    Route::get('/', 'OccupationController@index')->name('occupations');
    Route::get('/create','OccupationController@create');
    Route::post('/create','OccupationController@store');
    Route::get('/edit/{id}','OccupationController@edit');
    Route::post('/edit/{id}','OccupationController@update');
    Route::post('/delete/{id}','OccupationController@destroy');
});
