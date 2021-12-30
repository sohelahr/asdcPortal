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

    Route::post('/get-all-feedback-headers/{courseid}','FeedbackController@allFeedbackHeaders')->name('get_all_headers');
    Route::get('/create','FeedbackController@create')->name('feedback_header_create');
    Route::post('/create','FeedbackController@store')->name('feedback_header_create');

    Route::get('/get-form-inputs/{id}','FeedbackController@getFormData')->name('feedback_header_inputs');

});
