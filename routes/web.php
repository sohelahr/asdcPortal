<?php

use App\Http\Controllers\CronJobController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\VerifyMailController;
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


Route::get('/verfiy/email/{id}',[VerifyMailController::class,'Verify'])->name('verify_mail');

Route::get('/mail', function () {
    //$content['user_name'] = 'Naseem';
    //$content['course_name'] = 'BCA';
    $content = 'Naseem';
    //$content['documents'] = ['1'=>'asdnas'];
    //return view('email.course_registrations_template',compact('content')); 
    /* $content = [
                'name' =>  'Naseem',
                'mail' =>  'nk4822805@gmai.com',
                'pwd' =>   'naseem'.'@asdc'.date('Y')
            ]; */
           MailController::sendRegistrationEmail("asdci nstitute@gmail.com",$content,'12');
    //return view('email.admin_user_registrations_mail',compact('content'));
});


Route::get('/dashboard', function () {
    if(Auth::user()->user_type == '2' || Auth::user()->user_type == '1'){
        return redirect('/admin/dashboard');
    }
    $courses = Course::all();
    $profile = Auth::user()->UserProfile;
    return view('dashboard',compact(['courses','profile']));
})->middleware(['auth'])->name('dashboard');

Route::get('/testmail', function () {
    return view('email.course_readmission_template');
});

Route::get('/markcurrentbatches',[CronJobController::class,'MarkCurrentBatches']);
Route::get('/markadmissioncomplete',[CronJobController::class,'MarkAdmissionComplete']);
Route::get('/removesuspension',[CronJobController::class,'RemoveSuspension']);


require __DIR__.'/auth.php';
