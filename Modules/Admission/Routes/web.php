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

Route::prefix('admission')->group(function() {
    Route::get('/', 'AdmissionController@index');
    Route::get('/mydata','AdmissionController@UserAdmissionData')->name('user_admission');
    Route::get('/data','AdmissionController@AllAdmissionData')->name('all_admissions');
    Route::get('/data/{id}','AdmissionController@OneAdmissionData')->name('view_admission');
    Route::get('/create/{id}','AdmissionController@create')->name('user_admission_create');
    Route::post('/create','AdmissionController@store')->name('user_admission_create');
    Route::get('/getforminputs/{id}','AdmissionController@getFormData')->name('admission_input_select');
    Route::get('/view/{id}','AdmissionController@show')->name('admission_show');
    Route::get('/print/{id}','AdmissionController@PrintForm')->name('print_admission_form');
});
