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

Route::prefix('attendance')->middleware(['auth'])->group(function() {
    Route::get('/', 'AttendanceController@index');  

    Route::post('create', 'AttendanceController@store')->name('attendance_create');

    Route::post('/update/{id}','AttendanceController@update')->name('student_employment_update');
    Route::get('/view/{id}','AttendanceController@show')->name('employment_view');

    Route::post('/get-admissionwise-attendance/{id}','AttendanceController@admissionwiseAttendance')->name('get_admissionwise_attendance');

    Route::post('/get-all-attendance/{courseid}/{slotid}/{batchid}/{monthid}','AttendanceController@allAttendance')->name('get_all_attendance');

    Route::get('/getforminputs/{id}','AttendanceController@getFormData')->name('attendance_input_select');

    Route::get('/getbatchmonths/{id}','AttendanceController@getBatchMonths')->name('attendance_input_months');


});
