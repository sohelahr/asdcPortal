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

Route::prefix('courseslot')->group(function() {
    Route::get('/{id}', 'CourseSlotController@index')->name('courseslot');
    Route::get('/create','CourseSlotController@create');
    Route::post('/create','CourseSlotController@store');
    Route::get('/edit/{id}','CourseSlotController@edit');
    Route::post('/edit/{id}','CourseSlotController@update');
    Route::post('/delete/{id}','CourseSlotController@destroy');
});
