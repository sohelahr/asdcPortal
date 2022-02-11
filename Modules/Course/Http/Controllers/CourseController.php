<?php

namespace Modules\Course\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
use Modules\SerialNumberConfigurations\Http\Controllers\SerialNumberConfigurationsController;
use Yajra\Datatables\Datatables;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct()
    {
        $this->middleware('admin')->except('EnrollmentData');
    }

    public function index()
    {
        return view('course::index');
    }

    function CourseData(){
        $documents = Course::orderby('id','DESC')->get();
        
        return DataTables::of($documents)
                ->addIndexColumn()
                ->addColumn('coursetiming_perm',function($document){
                    if(\App\Http\Helpers\CheckPermission::hasPermission('view_courses_slots.courses')){
                        return true; 
                    }
                    else{
                        return false;
                    }
                })
                ->addColumn('perm',function($document){
                    $perm = [];
                    if(\App\Http\Helpers\CheckPermission::hasPermission('update.courses')){
                        array_push($perm,true);
                    }
                    else{
                        array_push($perm,false);
                    }

                    if(\App\Http\Helpers\CheckPermission::hasPermission('delete.courses')){
                        array_push($perm,true);
                    }
                    else{
                        array_push($perm,false);
                    }

                    return ['edit_perm' => $perm[0],'delete_perm' => $perm[1]];
                })
                ->make();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('course::create');
    } 

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
         $request->validate([
            'name' => ['unique:courses'],
            'slug' => ['unique:courses'],
        ]);



        $course = new Course();
        $course->name = $request->name;
        $course->duration = $request->duration;
        $course->slug = $request->slug;
        $course->save();

        SerialNumberConfigurationsController::generateNewSerialNumber($course->id,$course->slug);

        return redirect()->route('course_list')->with('created','course created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('course::show');
    }

    public function EnrollmentData()
    {
        $courses = Course::all();
        return Datatables::of($courses)
            ->addIndexColumn()
            ->addColumn('courseslot',function($course){
                $registrations = Auth::user()->Registrations;
                $courseslots = $course->CourseSlots->pluck(['id'])->toArray();
                    foreach($registrations as $registration){
                        if(in_array($registration->course_slot_id,$courseslots)){
                            return true;
                        }
                    }
                    return $course->CourseSlots;
                })
            ->addColumn('apply',function($course){
                $registrations = Auth::user()->Registrations;
                    foreach($registrations as $registration){
                        if($course->id == $registration->course_id)
                            return "true";
                    } 
                    return "false";  
            })
            ->make();
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {       
        $course = Course::find($id);
        return json_encode($course);
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
        $course = Course::find($id);
        $course->name = $request->name;
        $course->duration = $request->duration;
        $course->slug = $request->slug;
        $course->save();
        return redirect()->route('course_list')->with('updated','course Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $course = Course::find($id);
        $batches = $course->CourseBatches;
        $slots = $course->CourseSlots;
        
        if($course->Registrations->count() > 0 || $course->Admissions->count() > 0){
           return redirect()->route('course_list')->With('prohibited','123'); 
        }

        foreach($slots as $slot){
            $slotid = $slot->id ;
            $slot->delete();
            $transaction = BatchSlotTransaction::where('slot_id',$slotid);
            $transaction->delete();
        }
        foreach($batches as $batch){
            $batch->delete();
            
        }
        if($course->delete())
            return redirect()->route('course_list')->with('deleted','Course Updated successfully');
        else
            return redirect()->route('course_list')->with('error','Something went Wrong');
    }
}
