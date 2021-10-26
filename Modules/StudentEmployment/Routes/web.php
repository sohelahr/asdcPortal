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

Route::prefix('studentemployment')->group(function() {
    Route::get('/', 'StudentEmploymentController@index');
    Route::post('create', 'StudentEmploymentController@store')->name('student_employment_create');

    Route::get('/data','StudentEmployementController@AllStudentEmployementData')->name('all_student_employements');

    //Route::post('//{id}','StudentEmployementController@destroy');
    Route::get('/update/{id}','StudentEmployementController@update');


});
