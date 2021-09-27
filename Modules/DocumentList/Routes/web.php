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

Route::prefix('documentlist')->group(function() {
    Route::get('/', 'DocumentListController@index')->name('document_list');
    Route::get('/create','DocumentListController@create');
    Route::post('/create','DocumentListController@store');
    Route::get('/edit/{id}','DocumentListController@edit');
    Route::post('/edit/{id}','DocumentListController@update');
    Route::post('/delete/{id}','DocumentListController@destroy');
});
