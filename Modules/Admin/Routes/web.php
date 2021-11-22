<?php
use App\Http\Controllers\ChartJsController;

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

Route::prefix('admin')->middleware(['auth'])->group(function() {
    Route::get('/dashboard', 'AdminController@index');
    Route::get('/get-gauge/{id}','AdminController@getCourseCapacities');
    Route::get('/get-admission-by-batch/{id}','AdminController@getBatchWiseAdmissions');

    Route::get('/get-batches/{id}','AdminController@getBatches');



    Route::get('/get-course-wise-admissions','AdminController@getCourseAdmissionGraphChart');
    Route::get('/get-course-wise-employments','AdminController@getCourseEmploymentGraphChart');
    Route::get('/get-user-reach','AdminController@getReachSourceGraphChart');
    Route::get('/get-registration-counts','AdminController@getRegistrationGraphChart');

    Route::get('/import-index','ImportController@index');
    Route::get('/import-users','ImportController@importUsers');
    Route::get('/import-profiles','ImportController@importProfiles');
    Route::get('/import-registrations','ImportController@importUserRegistration');


});

