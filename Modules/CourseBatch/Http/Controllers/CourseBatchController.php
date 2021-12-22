<?php

namespace Modules\CourseBatch\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Yajra\DataTables\DataTables;

class CourseBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $courses = Course::all();
        return view('coursebatch::index',compact('courses'));
    }

    function CourseBatchData(){
        $coursebatches = CourseBatch::all();
        
        return DataTables::of($coursebatches)
                ->addIndexColumn()
                ->addColumn('course_name',function($coursebatch){
                    return ($coursebatch->Course) ? $coursebatch->Course->name : 'not found';
                })
                ->addColumn('start_date',function($coursebatch){
                    return date('d M Y',strtotime($coursebatch->start_date));
                })
                
                ->addColumn('expiry_date',function($coursebatch){
                    return date('d M Y',strtotime($coursebatch->expiry_date));
                })
                ->addColumn('action',function($coursebatch){
                    $perm = [];
                    if(\App\Http\Helpers\CheckPermission::hasPermission('update.coursebatch')){
                        array_push($perm,true);
                    }
                    else{
                        array_push($perm,false);
                    }

                    if(\App\Http\Helpers\CheckPermission::hasPermission('delete.coursebatch')){
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
        $coursebatch = new CourseBatch();
        $coursebatch->course_id = $request->course_id;
        $coursebatch->batch_number = $request->batch_number;
        $coursebatch->start_date = $request->start_date;
        $coursebatch->expiry_date = $request->end_date;
        $coursebatch->status = "1";

        $date_now = time();
        if(strtotime($request->start_date) <= $date_now && $date_now < strtotime($request->end_date) ){
            $coursebatch->is_current = 1;
        }
        
        $coursebatch->batch_identifier = Date('Y')."-".$request->batch_number;
        
        $check_coursebatch = CourseBatch::where('course_id',$request->course_id)
                            ->where('batch_number',$request->batch_number)    
                            ->where('start_date',$request->start_date)
                                ->where('expiry_date',$request->end_date)
                                ->get();

        if(count($check_coursebatch) == 0){
            $coursebatch->save();
            $coursebatch_id = $coursebatch->id;
            $course_id = $coursebatch->course_id;
            
            $courseslots = CourseSlot::where('course_id',$coursebatch->course_id)->get();
            foreach($courseslots as $slot)
            {
                $slotbatch = new BatchSlotTransaction();
                $slotbatch->course_id = $course_id;
                $slotbatch->batch_id = $coursebatch_id;
                $slotbatch->slot_id = $slot->id;
                $slotbatch->is_current = ($coursebatch->is_current == 1) ? '1':'0';
                $slotbatch->status = '1';
                $slotbatch->total_capacity = $slot->TotalCapacity;
                $slotbatch->current_capacity = $slot->TotalCapacity;
                $slotbatch->save();
            }

        }
        else{
            return redirect()->route('coursebatch_list')->with('already','course created successfully');
        }    
        return redirect()->route('coursebatch_list')->with('created','course created successfully');
    }

    function changeStatus($id)
    {
        $coursebatch = CourseBatch::find($id);
        $date_now = time();

        if($coursebatch->status == "1"){
            // todays date 
            /* if todays date is greater than start date and less than end date  or
                if start date is greater than current date :- future batch
                if end date is less than todays date : - past batch
             */ 
            $coursebatch->status = "2";
        }
        else{
            
            $all_course_slots = CourseSlot::where('course_id',$coursebatch->course_id)->get();
            foreach ($all_course_slots as $slot) {
            
                if($date_now < strtotime($coursebatch->start_date) ){
            
                    $transaction = BatchSlotTransaction::firstOrNew(['slot_id'=>$slot->id,'batch_id'=>$coursebatch->id]);
                    if(isset($transaction))
                    {
                        $transaction->course_id = $coursebatch->course_id;
                        $transaction->batch_id = $coursebatch->id;
                        $transaction->slot_id = $slot->id;
                        $transaction->is_current = $coursebatch->is_current ? '1':'0';
                        $transaction->status = $coursebatch->status == '1' ? '1' : '0';
                        $transaction->total_capacity = $slot->TotalCapacity;
                        $transaction->current_capacity = $slot->TotalCapacity;
                        $transaction->save();
                    }
                }
            }   
            $coursebatch->status = "1";
        }

        if($coursebatch->save()){
            return redirect()->route('coursebatch_list')->with('status','course created successfully');    
        }
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

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {       
        $coursebatch = CourseBatch::find($id);
        return json_encode($coursebatch);
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
        $coursebatch = CourseBatch::find($id);
        $coursebatch->course_id = $request->course_id;
        $coursebatch->batch_number = $request->batch_number;
        $coursebatch->start_date = $request->start_date;
        $coursebatch->expiry_date = $request->end_date;
        $coursebatch->status = $coursebatch->status;
        $date_now = time();
        if(strtotime($request->start_date) <= $date_now && $date_now < strtotime($request->end_date) ){
            $coursebatch->is_current = 1;
        }
        $coursebatch->batch_identifier = Date('Y')."-".$request->batch_number;
        $coursebatch->save();
        return redirect()->route('coursebatch_list')->with('updated','course Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $coursebatch = CourseBatch::find($id);
        if($coursebatch->Admissions->count() > 0){
           return redirect()->route('coursebatch_list')->With('prohibited','123'); 
        }

        if($coursebatch->delete()){
            $slot_batch_transactions = $coursebatch->BatchSlots;
            foreach($slot_batch_transactions as $transactions){
                $transactions->delete();
            }
            return redirect()->route('coursebatch_list')->with('deleted','course Updated successfully');
        
        }
        else{
            return redirect()->route('coursebatch_list')->with('error','Something went Wrong');
        }
    }
}
