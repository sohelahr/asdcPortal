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


    Route::get('/attendance-import-page', 'AttendanceController@newAttendance')->name('attendance_import');
    Route::post('/attendance-dump-file', 'AttendanceController@dumpAttendance')->name('dump_attendance');
    Route::post('/attendance-preview-file', 'AttendanceController@previewAttendance')->name('preview_attendance');
    Route::post('/publish-dump-data', 'AttendanceController@publishAttendance')->name('publish_attendance');

    Route::get('/abort-dump-data', 'AttendanceController@abortAttendance')->name('abort_attendance');

    Route::post('/get-admissionwise-attendance/{id}','AttendanceController@admissionwiseAttendance')->name('get_admissionwise_attendance');

    Route::post('/get-all-attendance/{courseid}/{slotid}/{batchid}','AttendanceController@allAttendance')->name('get_all_attendance');

    Route::get('/getforminputs/{id}','AttendanceController@getFormData')->name('attendance_input_select');

    Route::get('/import_summaries','AttendanceController@importSummary');
    Route::post('/import_summaries/data','AttendanceController@importSummaryData');
	Route::get('/import_summaries/download/{file_name}/{flag}','AttendanceController@downloadImportSummary');
    Route::post('/import_summaries/logs/{id}/data','AttendanceController@importLogsData');
    Route::get('/import_summaries/logs/{id}','AttendanceController@importLogs');

});
