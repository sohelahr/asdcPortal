<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\Block\Document;
use Modules\Admission\Entities\Admission;
use Modules\Admission\Entities\Certificate;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
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
        $this->middleware('admin')->except('getIdCard');
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
                if(\App\Http\Helpers\CheckPermission::hasPermission('view.admissions')){
                        return ['perm'=>true,'name'=> $admission->Student->name ];
                    }
                    else{
                       return ["perm"=>false,'name' =>  $admission->Student->name];
                    }
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
        $documents = DocumentList::all();
        $current_numbers = SerialNumberConfigurationsController::getCurrentNumbers($selected_course->id);
        $admission_form_number = "ASDC/". $selected_course->slug . date("y")."-". $current_numbers->currentAdmissionNumber;
        $roll_no =  $selected_course->slug . date("y")."-". $current_numbers->currentRollNumber;

        //get first slot transaction
        $transaction = null;
        //get first slot transaction
        if($current_course_batch){
            $transaction = BatchSlotTransaction::where('slot_id',$selected_course_slot->id)
                                ->where('batch_id',$current_course_batch->id)->first();
        }


        return view('admission::create',compact('transaction','roll_no','admission_form_number',
                'current_course_batch','documents','student',
                'registration_id','selected_course','selected_course_slot',
                'courses','initial_course_slots','initial_course_batches'));
    }
    
    public function store(Request $request)
    {
        
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

        //check if capacity of course full
        $batch_slot_transaction = BatchSlotTransaction::where('batch_id',$admission->coursebatch_id)
                                                ->where('slot_id',$admission->courseslot_id)->first();
        if(isset($batch_slot_transaction)){
                if($batch_slot_transaction->current_capacity == 0){
                    return redirect('admission/create/'.$admission->registration_id)->with('capacity_full','123');
                }
        }

        if($admission->course_id == $request->registered_course_id){
            $admission->is_course_changed = false;
        }
        else{
            $admission->is_course_changed = true;
        }


        //get Current Values Of Admission and Roll NUMBERS
        // $current_numbers = SerialNumberConfigurationsController::getCurrentNumbers($request->course_id);
        
        //Create new Admission Numbers using that 
        /* 
        $course_slug = Course::find($request->course_id)->slug;
        $admission->admission_form_number = "ASDC/". $course_slug . date("y")."-". $current_numbers->currentAdmissionNumber;
        
        $admission->roll_no =  $course_slug . date("y")."-". $current_numbers->currentRollNumber; */
        
        $admission->admission_form_number = $request->admission_form_number;
        
        $admission->roll_no =  $request->roll_no;
        
        
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

            /* $course_slot = CourseSlot::find($request->course_slot_id);
            $course_slot->CurrentCapacity = $course_slot->CurrentCapacity - 1;
            $course_slot->save(); *//* 
            $batch_slot_transaction = BatchSlotTransaction::where('batch_id',$admission->coursebatch_id)
                                                ->where('slot_id',$admission->courseslot_id)->first(); */
            if(isset($batch_slot_transaction)){
                $batch_slot_transaction->current_capacity = $batch_slot_transaction->current_capacity - 1;
                $batch_slot_transaction->save(); 
            }

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
        $grade = "";
        if($admission->Certificate)
            $grade = $admission->Certificate->grade;
        return view('admission::view',compact('admission','documents_submitted','documents','grade'));
    }

    function getFormData($id)
    {
        $course = Course::find($id);
        $course_slots = $course->CourseSlots;
        $course_batches = $course->CourseBatches;
        
        $current_numbers = SerialNumberConfigurationsController::getCurrentNumbers($course->id);
        
        $admission_form_number = "ASDC/". $course->slug . date("y")."-". $current_numbers->currentAdmissionNumber;
        
        $roll_no =  $course->slug . date("y")."-". $current_numbers->currentRollNumber;

        return response()->json(['course_slots'=>$course_slots,
                                'course_batches'=>$course_batches,
                                'roll_no' => $roll_no,
                                'admission_form_number'=>$admission_form_number,
                                ]);
    }

    function getTransaction($slot,$batch){
        $transaction = BatchSlotTransaction::where('slot_id',$slot)
                                    ->where('batch_id',$batch)->first();
        return response()->json(['transaction'=>$transaction]);
    }

    function cancelAdmission(Request $request)
    {
        $admission = Admission::find($request->admission_id);
        $admission->cancellation_reason = $request->cancellation_reason;
        $admission->status = '4';

        //Increase capacity of batch if terminated
        $batch_slot_transaction_old = BatchSlotTransaction::where('batch_id',$admission->coursebatch_id)
                                            ->where('slot_id',$admission->courseslot_id)->first();
        if(isset($batch_slot_transaction_old)){
            $batch_slot_transaction_old->current_capacity = $batch_slot_transaction_old->current_capacity + 1;
            $batch_slot_transaction_old->save(); 
        }

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
        
        //first check if capacity for that batch is 0 if yes then dont admit again instead make a new admission

        $batch_slot_transaction_new = BatchSlotTransaction::where('batch_id',$admission->coursebatch_id)
                                                ->where('slot_id',$admission->course_slot_id)->first();

        if(isset($batch_slot_transaction_new)){
                ($batch_slot_transaction_new->current_capacity == 0);
                return redirect('admission/edit/'.$admission->id)->with('capacity_readmission_full','123');
        }
        
        //now increase capacity if not 0
        if(isset($batch_slot_transaction_new)){
            $batch_slot_transaction_new->current_capacity = $batch_slot_transaction_new->current_capacity - 1;
            $batch_slot_transaction_new->save(); 
        }

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

            //Increase capacity of batch if terminated
            $batch_slot_transaction_old = BatchSlotTransaction::where('batch_id',$admission->coursebatch_id)
                                                ->where('slot_id',$admission->courseslot_id)->first();
            if(isset($batch_slot_transaction_old)){
                $batch_slot_transaction_old->current_capacity = $batch_slot_transaction_old->current_capacity + 1;
                $batch_slot_transaction_old->save(); 
            }

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
        $data['name'] = $userprofile->firstname . " ". $userprofile->lastname;
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

    function generateCertificate($id){
        $admission = Admission::find($id);
        $userprofile = $admission->Student->UserProfile;
        $data = [];
        $data['name'] = $userprofile->firstname . " ". $userprofile->lastname;
        $data['father_name'] = $userprofile->father_name;
        $data['course'] = $admission->Course->name;
        $data['roll_number'] = $admission->roll_no;
        $data['batch_start_date'] = date('d M Y',strtotime($admission->CourseBatch->start_date));
        $data['batch_end_date'] = date('d M Y',strtotime($admission->CourseBatch->expiry_date));
        $data['grade'] = $admission->Certificate->grade;
        //$data['grade'] = $admission->grade;
       // return $data;
        $pdf = PDF::loadView('admission::certificate_of_completion',compact('data'),[], [
                                'format' => [297, 210]]);
        return $pdf->stream('document.pdf');

    }

    function calculateGrade(Request $request){

        $certificate = new Certificate();
        $certificate->admission_id = $request->admission_id;
        $certificate->grade = $request->grade;
        $certificate->save();
        return redirect()->route('admission_show',[$request->admission_id])->with('graded','created');

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

        $grade = "";
        if($admission->Certificate){
            $grade = $admission->Certificate->grade;
        }
        
        //get first slot transaction
        $transaction = BatchSlotTransaction::where('slot_id',$admission->courseslot_id)
                                    ->where('batch_id',$admission->coursebatch_id)->first();
        
        return view('admission::edit',compact('grade','transaction','selected_course_id','documents','submitted_documents','student','courses','initial_course_slots','initial_course_batches','admission'));
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
        $admission->status = "1";

        if($request->grade){
            $certificate = $admission->Certificate;
            $certificate->grade = $request->grade;
            $certificate->save();
        }



        if($admission->course_id == $request->registered_course_id){
            $admission->is_course_changed = false;
        }
        else{
            $admission->is_course_changed = true;
            //Decrement Numbers if course changed
        }
    
        if($admission->course_id != $request->course_id){
            
            SerialNumberConfigurationsController::decrementNumbers($admission->course_id);
            
            $admission->roll_no = $request->roll_no;
        
            $admission->admission_form_number =  $request->admission_form_number;
        
            $admission->course_id = $request->course_id;
    
            SerialNumberConfigurationsController::incrementNumbers($request->course_id);
            
            
        }
        //if timing or batch change decrement transaction
        if($request->course_slot_id != $admission->courseslot_id || $request->coursebatch_id != $admission->coursebatch_id){
            
            //first check if the capacity isnt 0 then proceed
            $batch_slot_transaction_new = BatchSlotTransaction::where('batch_id',$request->coursebatch_id)
                                                ->where('slot_id',$request->course_slot_id)->first();

            if(isset($batch_slot_transaction_new)){
                    if($batch_slot_transaction_new->current_capacity == 0){
                        return redirect('admission/edit/'.$admission->id)->with('capacity_full','123');
                    }
            }
            //now move is capacity isnt zero
            $batch_slot_transaction_old = BatchSlotTransaction::where('batch_id',$admission->coursebatch_id)
                                                ->where('slot_id',$admission->courseslot_id)->first();
            if(isset($batch_slot_transaction_old)){
                $batch_slot_transaction_old->current_capacity = $batch_slot_transaction_old->current_capacity + 1;
                $batch_slot_transaction_old->save(); 
            }

            if(isset($batch_slot_transaction_new)){
                $batch_slot_transaction_new->current_capacity = $batch_slot_transaction_new->current_capacity - 1;
                $batch_slot_transaction_new->save(); 
            }
        }
        
        
        $admission->courseslot_id = $request->course_slot_id;
        $admission->coursebatch_id = $request->coursebatch_id;

        if($admission->save()){                

            $documents = DocumentList::all();
            foreach($documents as $document){
                $admission->documents()->detach([$document->id]);
                $document_input_name = "document_".$document->id;
                if($request->$document_input_name){
                    $admission->documents()->attach([$request->$document_input_name => ['student_id' => $request->student_id ] ]);
                }
            }

            /* $course_slot = CourseSlot::find($request->course_slot_id);
            $course_slot->CurrentCapacity = $course_slot->CurrentCapacity - 1;
            $course_slot->save(); */

            return redirect()->route('admission_show',[$admission->id])->with('updated','created');
            }
            else{
                return redirect('/admission')->with('error','Something Went Wrong');
            }
    }
    public function getIdCard($id){
        if(Auth::user()->user_type == 3){
            $admission = Registration::find($id)->Admission;
        }
        else{
            $admission = Admission::find($id);
        }

        $user = $admission->Student;
        if($user->id !== Auth::user()->id && Auth::user()->user_type == 3){
            return redirect('/dashboard')->with('unauthorized','123');
        }
        $userprofile = $user->UserProfile;
        $data = [];
        $data['name'] = $admission->Student->name;
        $data['roll_no'] = $admission->roll_no;
        $data['photo'] = $userprofile->photo;
        $data['dob'] =  $userprofile->dob;
        $data['gender'] = $userprofile->gender;
        $data['mobile'] = $userprofile->mobile;
        $data['course'] = $admission->Course->name;
        $data['batch'] = $admission->CourseBatch->batch_number;
         $pdf = PDF::loadView('admission::id_card',compact('data'),[], [
                                'format' => [53, 84]]);
        return $pdf->stream('document.pdf');
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
