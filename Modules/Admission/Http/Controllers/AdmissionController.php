<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Node\Block\Document;
use Modules\Admission\Entities\Admission;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\DocumentList\Entities\Admission_DocumentList;
use Modules\DocumentList\Entities\AdmissionDocumentList;
use Modules\DocumentList\Entities\DocumentList;
use Modules\Registration\Entities\Registration;
use Modules\SerialNumberConfigurations\Http\Controllers\SerialNumberConfigurationsController;
use Modules\UserProfile\Entities\UserProfile;
use Yajra\DataTables\DataTables;
use PDF;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct()
    {
        $this->middleware('admin');
    }

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
        $initial_course_batches = $selected_course->CourseBatches->where('status','1'); 
        $current_course_batch = $selected_course->CourseBatches->where('is_current','1')->first();
        $documents =    DocumentList::all();

        return view('admission::create',compact('current_course_batch','documents','student','registration_id','selected_course','selected_course_slot','courses','initial_course_slots','initial_course_batches'));
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
        $admission->cancellation_reason = $request->cancellation_reason;
        $admission->admission_remarks = $request->admission_remarks;
        $admission->status = "1";
        $admission->student_id = $request->student_id;

        if($admission->course_id == $request->registered_course_id){
            $admission->is_course_changed = false;
        }
        else{
            $admission->is_course_changed = true;
        }


        //get Current Values Of Admission and Roll NUMBERS
        $current_numbers = SerialNumberConfigurationsController::getCurrentNumbers($request->course_id);
        
        //Create new Admission Numbers using that 
        $course_slug = Course::find($request->course_id)->slug;
        
        $admission->admission_form_number = "ASDC/". $course_slug . date("y")."-". $current_numbers->currentAdmissionNumber;
        
        $admission->roll_no =  $course_slug . date("y")."-". $current_numbers->currentRollNumber;
        if($admission->save()){                

            //Incrrement Numbers if data saves
            SerialNumberConfigurationsController::incrementNumbers($request->course_id);

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

            return redirect()->route('admission_show',[$admission->id])->with('created','created');
            }
            else{
                return redirect('/admission')->with('error','Something Went Wrong');
            }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $admission = Admission::find($id);
        $documents = DocumentList::all();
        $documents_submitted =  AdmissionDocumentList::where('admission_id',$admission->id)->pluck('document_id')->toArray();/* $admission->documents()->get(['pivot_document_id'])->toArray(); */
        
        return view('admission::view',compact('admission','documents_submitted','documents'));
    }

    function getFormData($id)
    {
        $course = Course::find($id);
        $course_slots = $course->CourseSlots;
        $course_batches = $course->CourseBatches->where('status','1');
        
        return response()->json(['course_slots'=>$course_slots,'course_batches'=>$course_batches]);
    }

    function cancelAdmission(Request $request)
    {
        $admission = Admission::find($request->admission_id);
        $admission->cancellation_reason = $request->cancellation_reason;
        $admission->status = '4';
        if($admission->save()){
            return redirect()->route('admission_show',[$admission->id])->with('cancelled','created');
        }
        else{
            return redirect('/admission')->with('error','Something Went Wrong');
        }

    }

    function reAdmit($id)
    {
        $admission = Admission::find($id);
        $admission->status = '1';
        if($admission->save()){
            return redirect()->route('admission_show',[$id])->with('readmitted','created');
        }
        else{
            return redirect('/admission')->with('error','Something Went Wrong');
        }

    }

    function terminateAdmission(Request $request)
    {
        $admission = Admission::find($request->admission_id);
        $admission->cancellation_reason = $request->cancellation_reason;
        $admission->status = '5';
        if($admission->save()){

            $student = $admission->Student->UserProfile;
            $student->status = '2';
            $student->suspended_till = date('y-m-d', strtotime('+1 year'));
            $student->save();
            return redirect()->route('admission_show',[$admission->id])->with('terminated','created');
        }
        else{
            return redirect('/admission')->with('error','Something Went Wrong');
        }

    }

    function PrintForm($id)
    {
        $admission = Admission::find($id);
        $userprofile = $admission->Student->UserProfile;
        $data = [];
        $data['name'] = $admission->Student->name;
        $data['photo'] = $userprofile->photo;
        $data['dob'] =  $userprofile->dob;
        $data['email'] = $userprofile->User->email;
        $data['gender'] = $userprofile->gender;
        $data['mobile'] = $userprofile->mobile;
        $data['aadhaar'] = $userprofile->aadhaar;
        $data['qualification'] = $userprofile->Qualification->name;
        $data['occupation'] = $userprofile->Occupation->name;
        $data['school_name'] = $userprofile->school_name;
        $data['father_name'] = $userprofile->father_name;
        $data['father_occupation'] = $userprofile->father_occupation;
        $data['fathers_mobile'] = $userprofile->fathers_mobile;
        $data['fathers_income'] = $userprofile->fathers_income;
        $data['address'] = $userprofile->house_details.", ".$userprofile->street.", ".$userprofile->landmark.", ".$userprofile->city.", ".$userprofile->state.", ".$userprofile->pincode;
        $data['course'] = $admission->Course->name;
        $data['course_slot'] = $admission->CourseSlot->name;
        $data['documents'] = DocumentList::all();
        $data['documents_name'] = $admission->documents()->get();
        $data['current_date'] = Date('d M Y');
        $data['admission_number'] = $admission->admission_form_number;
        $data['admission_remarks'] = $admission->admission_remarks;
        $data['documents_submitted'] =  AdmissionDocumentList::where('admission_id',$admission->id)->pluck('document_id')->toArray();/* $admission->documents()->get(['pivot_document_id'])->toArray(); */
        
        $pdf = PDF::loadView('admission::admission_form',compact('data'),[], [
                                'format' => [216, 280]]);
        return $pdf->stream('document.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        
        $admission = Admission::find($id);
        $student = $admission->Student;
        $selected_course_id = $admission->Registration->Course->id;

        $courses = Course::all();

        $documents = DocumentList::all();
        $submitted_documents =  AdmissionDocumentList::where('admission_id',$admission->id)->pluck('document_id')->toArray();/* $admission->documents()->get(['pivot_document_id'])->toArray(); */
        
        $initial_course_slots = $admission->Course->CourseSlots; 
        $initial_course_batches = $admission->Course->CourseBatches; 
        
        return view('admission::edit',compact('selected_course_id','documents','submitted_documents','student','courses','initial_course_slots','initial_course_batches','admission'));
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
        $admission = Admission::find($id);
        $admission->admitted_by = Auth::user()->id;
        $admission->cancellation_reason = $request->cancellation_reason;
        $admission->admission_remarks = $request->admission_remarks;
        $admission->status = "2";
        $admission->courseslot_id = $request->course_slot_id;
        $admission->coursebatch_id = $request->coursebatch_id;

        if($admission->course_id == $request->registered_course_id){
            $admission->is_course_changed = false;
        }
        else{
            $admission->is_course_changed = true;
        }
    
        if($admission->course_id != $request->course_id){
        
            $admission->course_id = $request->course_id;
            //get Current Values Of Admission and Roll NUMBERS
            $current_numbers = SerialNumberConfigurationsController::getCurrentNumbers($request->course_id);
            
            //Create new Admission Numbers using that 
            $course_slug = Course::find($request->course_id)->slug;
            $admission->admission_form_number = "asdc/". $course_slug . date("y")."-". $current_numbers->currentAdmissionNumber;

            $admission->roll_no =  $course_slug . date("y") ."-". $current_numbers->currentRollNumber;
    
            SerialNumberConfigurationsController::incrementNumbers($request->course_id);
            
        }
        if($admission->save()){                

            //Increment Numbers if data saves

            $documents = DocumentList::all();
            foreach($documents as $document){
                $admission->documents()->detach([$document->id]);
                $document_input_name = "document_".$document->id;
                if($request->$document_input_name){
                    $admission->documents()->attach([$request->$document_input_name => ['student_id' => $request->student_id ] ]);
                }
            }

            $course_slot = CourseSlot::find($request->course_slot_id);
            $course_slot->CurrentCapacity = $course_slot->CurrentCapacity - 1;
            $course_slot->save();

            return redirect()->route('admission_show',[$admission->id])->with('created','created');
            }
            else{
                return redirect('/admission')->with('error','Something Went Wrong');
            }
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
