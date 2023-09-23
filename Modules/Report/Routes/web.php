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

Route::prefix('report')->middleware(['auth'])->group(function() {
    Route::get('/','ReportController@index');
    Route::get('/get/columns/{table_name}','ReportController@fetchColumns');
    Route::post('/fetch/data','ReportController@fetchData');
    Route::post("/export",'ReportController@exportReport');
    Route::get('/dev/reporting','ReportController@devReporting');
    
});
