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

use Modules\Instructor\Http\Controllers\InstructorController;

Route::prefix('instructor')->middleware(['auth'])->group(function() {
    Route::get('/', 'InstructorController@index');
    Route::get('/{id}/view', 'InstructorController@show')->name('instructor');
    Route::get('/create',[InstructorController::class,'create'])->name('create_instructor');
    Route::post('/create',[InstructorController::class,'store'])->name('create_instructor');
    Route::get('{id}/update',[InstructorController::class,'edit'])->name('instructor_update');
    Route::post('{id}/update',[InstructorController::class,'update'])->name('instructor_update');
    Route::post('/data',[InstructorController::class,'InstructorData'])->name('instructor_data');
});