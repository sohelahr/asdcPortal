<?php

namespace Modules\Registration\Http\Controllers;

use App\Http\Controllers\MailController;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Entities\Course;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\DocumentList\Entities\DocumentList;
use Modules\Registration\Entities\Registration;
use Modules\SerialNumberConfigurations\Http\Controllers\SerialNumberConfigurationsController;
use Modules\UserProfile\Entities\UserProfile;
use Yajra\Datatables\Datatables;
class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('registration::index');
    }

    function UserRegistrationData(){
        $userregistrations = Auth::user()->Registrations;

        return Datatables::of($userregistrations)
                ->addIndexColumn()
                ->addColumn('course_name',function($registration){
                    return $registration->Course->name;
                })
                ->addColumn('course_slot',function($registration){
                    return $registration->CourseSlot->name;
                })
                
                ->addColumn('date',function($registration){
                    $time = strtotime(($registration->created_at));
                    return date('d M Y',$time) ;
                })
                ->make();
    }
    function AllRegistrationData(){
        $registrations = Registration::where('status','1')->get();

        return Datatables::of($registrations)
                ->addIndexColumn()
                ->addColumn('student_name',function($registration){
                    return $registration->Student->name;
                })
                ->addColumn('course_name',function($registration){
                    return $registration->Course->name;
                })
                ->addColumn('course_slot',function($registration){
                    return $registration->CourseSlot->name;
                })
                
                ->addColumn('date',function($registration){
                    $time = strtotime(($registration->created_at));
                    return date('d M Y',$time) ;
                })
                ->addColumn('action',function($registration){
                    return \App\Http\Helpers\CheckPermission::hasPermission('create.admissions');
                })
                ->make();
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        if(Auth::user()->UserProfile->is_profile_completed){
            
            $count_registrations = Auth::user()->Registrations->count();
            if($count_registrations >= 2)
                return redirect('/dashboard')->with('already_registered','not complete');
            else{
                $courses = Course::all();
                return view('registration::create',compact('courses'));
            }
        }
        return redirect('/dashboard')->with('profile_not_complete','not complete');
    }

    function OneRegistrationData($id){
        $userregistrations = UserProfile::find($id)->User->Registrations;
        return Datatables::of($userregistrations)
                ->addIndexColumn()
                ->addColumn('course_name',function($registration){
                    return $registration->Course->name;
                })
                ->addColumn('course_slot',function($registration){
                    return $registration->CourseSlot->name;
                })
                
                ->addColumn('date',function($registration){
                    $time = strtotime(($registration->created_at));
                    return date('d M Y',$time) ;
                })
                ->make();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $registration = new Registration();
        $registration->student_id = Auth::user()->id;
        $registration->course_id = $request->course_id;
        $registration->course_slot_id = $request->courseslot_id;
        $registration->status = "1";
    
       // $registration->registration_no = 'RG-'.$this->generateRandomString()."".$registration->student_id;
        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();   
        
        $all_registration_course_id = Auth::user()->Registrations
                                        ->where('status','!=','3')
                                        ->pluck(['course_id'])->toArray();
        
        if(count($all_registration_course_id) < 2){

            if(in_array($registration->course_id,$all_registration_course_id)){
                return response()->json(['status' => 'restricted','msg' => 'You cant register for the same course twice please choose another one',]);
            }
            else{
                if($registration->save()){
                    SerialNumberConfigurationsController::incrementRegistrationNumber();
                    $mailcontent = ['user_name'=>Auth::user()->name,
                                    'registration_no' => $registration->registration_no,
                                    'course_name' => $registration->Course->name,
                                    'documents'=>DocumentList::all()->pluck('name')->toArray() 
                                ];
                    MailController::sendCourseEnrollmentEmail(Auth::user()->email,$mailcontent);
                    return response()->json(['status' => 'success','msg' => 'You have successfully enrolled for a course',]);
                }
                else{
                    return response()->json(['status' => 'error','msg' => 'Something Went Wrong',]);
                }
            }
        }
        else
        {    
            return response()->json(['status' => 'restricted','msg' => 'You cant register for more than two courses',]);
        }
    }

    function getRegFormData($id)
    {
        $course = Course::find($id);
        $course_slots = $course->CourseSlots;  
        return response()->json(['course_duration'=>$course->Duration,'course_slots'=>$course_slots]);
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('registration::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('registration::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $registration = Registration::find($id);
        if($registration->student_id == Auth::user()->id){
           $registration->status = '3';
           $registration->save();
            return json_encode(array('data'=>'success'));
        }
        else{
            return json_encode(array('data'=>'unauthorized'));
        }

    }

    function generateRandomString($length = 6) {
        $characters = '0123456789876543210';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
