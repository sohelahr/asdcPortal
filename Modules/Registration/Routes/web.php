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

Route::prefix('registration')->middleware(['auth','admin'])->group(function() {
    Route::get('/', 'RegistrationController@index');
    Route::get('/mydata','RegistrationController@UserRegistrationData')->name('user_registrations');
    Route::post('/data','RegistrationController@AllRegistrationData')->name('all_registrations');
    Route::get('/data/{id}','RegistrationController@OneRegistrationData')->name('profile_registrations');
    Route::get('/create','RegistrationController@create')->name('user_registration_create');
    Route::post('/create','RegistrationController@store')->name('user_registration_create');

    Route::post('/withdraw/{id}','RegistrationController@destroy');
    Route::get('/getforminputs/{id}','RegistrationController@getRegFormData');

});
  