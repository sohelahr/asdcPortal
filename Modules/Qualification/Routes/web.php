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

Route::prefix('qualification')->middleware(['auth'])->group(function() {
    Route::get('/', 'QualificationController@index')->name('qualifications');
    Route::get('/create','QualificationController@create');
    Route::post('/create','QualificationController@store');
    Route::get('/edit/{id}','QualificationController@edit');
    Route::post('/edit/{id}','QualificationController@update');
    Route::post('/delete/{id}','QualificationController@destroy');
});
