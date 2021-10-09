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

use Modules\Course\Http\Controllers\CourseController;

Route::prefix('course')->group(function() {
    Route::get('/', 'CourseController@index')->name('course_list');
    Route::get('/create','CourseController@create');
    Route::post('/create','CourseController@store');
    Route::get('/edit/{id}','CourseController@edit');
    Route::post('/edit/{id}','CourseController@update');
    Route::post('/delete/{id}','CourseController@destroy');
    Route::get('/enrollment/data',[CourseController::class,'EnrollmentData'])->name('enrollmentData');
});
