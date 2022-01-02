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

Route::prefix('feedback')->group(function() {
    Route::get('/', 'FeedbackController@index');
    Route::get('/lines/{headerid}', 'FeedbackController@indexLines');

    Route::post('/get-all-feedback-headers/{courseid}','FeedbackController@allFeedbackHeaders')->name('get_all_headers');
    Route::post('/get-all-feedback-headers-per-admission/','FeedbackController@allFeedbackHeadersPerAdmission')->name('get_all_headers_per_admission');

    Route::get('/create','FeedbackController@create')->name('feedback_header_create');
    Route::post('/create','FeedbackController@store')->name('feedback_header_create');


    Route::post('/get-all-feedback-lines/{headerid}','FeedbackController@allFeedbackLines')->name('get_all_lines');
    Route::get('/lines/view/{linesid}','FeedbackController@ViewLine')->name('get_one_line');
    
    
    Route::get('/lines/create/{id}','FeedbackController@createLines')->name('feedback_lines_create');
    Route::post('/lines/create/{id}','FeedbackController@storeLines')->name('feedback_lines_create');

    Route::get('/get-form-inputs/{id}','FeedbackController@getFormData')->name('feedback_header_inputs');

});
