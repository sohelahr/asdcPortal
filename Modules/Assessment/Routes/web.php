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

Route::prefix('assessment')->middleware(['auth'])->group(function() {
    Route::get('/', 'AssessmentController@index');

    Route::get('/create','AssessmentController@create')->name('assessment_header_create');
    Route::get('/create-language','AssessmentController@createLanguage')->name('assessment_header_create_language');

    Route::post('/create','AssessmentController@store')->name('assessment_header_create');

    Route::get('/show-assessment-header/{headerid}','AssessmentController@viewAssessmentHeader')->name('viewAssessmentHeader');
    Route::post('/get-all-assessment-headers/{courseid}/{batchid}/{slotid}','AssessmentController@allAssessmentHeaders')->name('get_all_headers');
    Route::post('/get-all-admissions-per-assessment-header/{headerid}','AssessmentController@allAdmissionsPerAssessmentHeader')->name('get_admission_per_head');

    Route::post('/save-line/{headerid}','AssessmentController@update')->name('assessment_line_save');

    Route::post('/calculate-grade','AssessmentController@calculatingGrade')->name('assessment_grade_calc');
    Route::post('/get-admissionwise-assessment/{id}','AssessmentController@admissionwiseAssessment');

    Route::post('/delete/{id}','AssessmentController@destroy');
});
