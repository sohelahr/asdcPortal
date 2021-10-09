<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admission\Entities\Admission;
use Modules\Course\Entities\Course;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\DocumentList\Entities\DocumentList;
use Modules\Registration\Entities\Registration;
use Modules\UserProfile\Entities\UserProfile;
use Yajra\DataTables\DataTables;
use PDF;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admission::index');
    }

    function UserAdmissionData(){
        $useradmissions = Auth::user()->Admissions;

        return DataTables::of($useradmissions)
            ->addColumn('course_name',function($admission){
                return $admission->Course->name;
            })
            ->addColumn('course_slot',function($admission){
                return $admission->CourseSlot->name;
            })
            ->addColumn('date',function($admission){
                $time = strtotime(($admission->created_at));
                return date('d M Y',$time) ;
            })
            ->make();
    }
    function AlladmissionData(){
        $admissions = Admission::all();

        return Datatables::of($admissions)
            ->addColumn('student_name',function($admission){
                return $admission->Student->name;
            })
            ->addColumn('admitted_by',function($admission){
                return $admission->AdmittedBy->name;
            })
            ->addColumn('course_name',function($admission){
                return $admission->Course->name;
            })
            ->addColumn('date',function($admission){
                $time = strtotime(($admission->created_at));
                return date('d M Y',$time) ;
            })
            ->make();
    }

    function OneadmissionData($id){
        $useradmissions = UserProfile::find($id)->User->Admissions;
        return Datatables::of($useradmissions)
                ->addColumn('admitted_by',function($admission){
                    return $admission->AdmittedBy->name;
                })
                ->addColumn('course_name',function($admission){
                    return $admission->Course->name;
                })
                ->addColumn('date',function($admission){
                    $time = strtotime(($admission->created_at));
                    return date('d M Y',$time) ;
                })
                ->make();
    }
    
    public function create($id)
    {
        $registration = Registration::find($id);
        $student = $registration->Student;
        $registration_id = $registration->id;
        $selected_course = $registration->Course;
        $selected_course_slot = $registration->CourseSlot;

        $courses = Course::all();
        $initial_course_slots = $selected_course->CourseSlots; 
        $initial_course_batches = $selected_course->CourseBatches; 

        $documents =    DocumentList::all();

        return view('admission::create',compact('documents','student','registration_id','selected_course','selected_course_slot','courses','initial_course_slots','initial_course_batches'));
    }
    
    public function store(Request $request)
    {
        //
        $admission = new Admission();

        $admission->course_id = $request->course_id;
        $admission->courseslot_id = $request->course_slot_id;
        $admission->registration_id = $request->registration_id;
        $admission->admitted_by = Auth::user()->id;
        $admission->coursebatch_id = $request->coursebatch_id;
        $admission->admission_form_number = 123;
        $admission->cancellation_reason = $request->cancellation_reason;
        $admission->roll_no =10001;
        $admission->admission_remarks = $request->admission_remarks;
        $admission->status = "2";
        $admission->student_id = $request->student_id;

            if($admission->save()){

                
                $documents = DocumentList::all();
                foreach($documents as $document){
                    $document_input_name = "document_".$document->id; 
                    
                    if($request->$document_input_name){
                        $admission->documents()->attach([$request->$document_input_name => ['student_id' => $request->student_id ] ]);
                    }
                }

                $registration = Registration::find($request->registration_id);
                $registration->status = "2";
                $registration->save();

                $course_slot = CourseSlot::find($request->course_slot_id);
                $course_slot->CurrentCapacity = $course_slot->CurrentCapacity - 1;
                $course_slot->save();

                return redirect()->route('admission_show'[$admission->id])->with('created','created');
            }
            else
                return redirect('/admission')->with('error','Something Went Wrong');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $admission = Admission::find($id);
        
        $documents_submitted = $admission->documents()->get();
        return view('admission::view',compact('admission','documents_submitted'));
    }

    function getFormData($id)
    {
        $course = Course::find($id);
        $course_slots = $course->CourseSlots;
        $course_batches = $course->CourseBatches;

        return response()->json(['course_slots'=>$course_slots,'course_batches'=>$course_batches]);
    }


    function PrintForm($id)
    {
        $admission = Admission::find($id);
        
        view()->share('admission',$admission);
        $pdf = PDF::loadView('admission::admission_form', $admission);
        $pdf->setPaper('a4');
        return $pdf->stream();
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admission::edit');
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
    }
}
