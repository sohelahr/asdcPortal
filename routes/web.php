<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Course\Entities\Course;

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

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/mail', function () {
    $content['user_name'] = 'Naseem';
    $content['course_name'] = 'BCA';
    //$content = 'Naseem';
    $content['documents'] = ['1'=>'asdnas'];
    return view('email.course_registrations_template',compact('content'));
    //return view('email.user_registration_mail',compact('content'));
}); */


Route::get('/dashboard', function () {
    if(Auth::user()->user_type == '2' || Auth::user()->user_type == '1'){
        return redirect('/admin/dashboard');
    }
    $courses = Course::all();
    $profile = Auth::user()->UserProfile;
    return view('dashboard',compact(['courses','profile']));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
