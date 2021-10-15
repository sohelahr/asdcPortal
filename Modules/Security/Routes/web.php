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

Route::prefix('security')->middleware(['auth'])->group(function() {
    Route::get('/', 'SecurityController@index');
    Route::get('/permissions/{id}', 'SecurityController@setPermission')->name('permissions');
    Route::post('/set/permissions', 'SecurityController@setSecurityPermission')->name('set_security_permissions');
 
});
