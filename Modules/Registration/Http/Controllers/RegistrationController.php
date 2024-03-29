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

    function __construct()
    {
        $this->middleware('admin')->except('create','store','UserRegistrationData','getRegFormData','destroy');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('registration::index');
    }

    function UserRegistrationData(){
        $userregistrations = Registration::where('student_id',Auth::user()->id)
                                ->where('status','<>','3')
                                ->orderBy('id','DESC')->get();
        $data = array();
        $status = true;
        if(count($userregistrations) > 0)
        {
            foreach ($userregistrations as $userregistration)
            {
                $nestedData['id'] = $userregistration->id;
                $nestedData['course_name'] = $userregistration->Course->name;
                $nestedData['registration_no'] = $userregistration->registration_no;
                $nestedData['course_slot'] = strtok($userregistration->CourseSlot->name,'(') ;
                $nestedData['course_slug'] = $userregistration->Course->slug;
                $nestedData['date'] = date('d M Y',strtotime($userregistration->created_at));
                $nestedData['status'] = $userregistration->status;
                $data[] = $nestedData;
            }
            $status = true;
        }
        else{
            $status = false;
        }
        $json_data = array(
            "status" => $status,
            "data" => $data
        );
        return json_encode($json_data);
    }
    function AllRegistrationData(Request $request){
        //dd($request->start());
        //$registrations = Registration::where('status','1')->get();
        $limit = $request->length;
        $start = $request->start;
        $search = $request->search['value'];

        $registrations = Registration::query();
        
        $registrations = $registrations;
        
        //$totalApplicationCount = $registrations->count();
        $totalRegistrationRecord = $registrations->count();
        
        if(isset($search))
        {
            
            $registrations = $registrations->where('registration_no','LIKE','%'.$search.'%')
                                            ->OrWhereIn('course_id',function($query) use($search) {
                                                $query->select('id')->from('courses')->where('name','LIKE','%'.$search.'%');
                                            })
                                            ->OrWhereIn('student_id',function($query) use($search) {
                                                $query->select('id')->from('users')->where('name','LIKE','%'.$search.'%');
                                            })->where('status','1');
        }
        $filteredRegistrationCount = $registrations->count();
        $registrations = $registrations->where('status','1')->orderBy('id','DESC')->skip($start)->limit($limit)->get();
        //dd($registrations);

        if(isset($search))
        {
            $totalFiltered = $filteredRegistrationCount;
        }
        else
        {
            $totalFiltered = $totalRegistrationRecord;
        }
        //dd($registrations);
        return Datatables::of($registrations)
                ->addIndexColumn()
                ->addColumn('student_name',function($registration){
                    return $registration->Student->name;
                    //return ['id'=> $user->id,'name'=> $user->name];
                })
                
                ->addColumn('student_id',function($registration){
                    return $registration->Student->id;
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
                    /* $suspeneded = $registration->Student->UserProfile->status; */
                    if (\App\Http\Helpers\CheckPermission::hasPermission('create.admissions') /* && $suspeneded != '2'  */){
                        return true;
                    }
                    else{
                        return false;
                    }
                })
                ->setTotalRecords($totalRegistrationRecord)
                ->setOffset($start)
                ->setFilteredRecords($totalFiltered)
                ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   
        if(Auth::user()->UserProfile->is_profile_completed){
            
            $count_registrations = Auth::user()->Registrations->count();
            if($count_registrations >= 5)
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
        
        if(count($all_registration_course_id) < 5){

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
            return response()->json(['status' => 'restricted','msg' => 'You cant register for more than five courses',]);
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
    public function destroy(Request $request,$id)
    {
        //
        $registration = Registration::find($id);
        if($registration->student_id == Auth::user()->id){
           $registration->status = '3';
            $registration->cancel_reason = $request->reason;
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
