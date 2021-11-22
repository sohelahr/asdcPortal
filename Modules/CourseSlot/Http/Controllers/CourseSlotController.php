<?php

namespace Modules\CourseSlot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
use Modules\CourseBatch\Entities\CourseBatch;

class CourseSlotController extends Controller
{
    function __construct()
    {
        $this->middleware('admin')->except('get_course_slot');
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $course = Course::find($id);
        $courseslot = $course->courseSlots;
        return view('courseslot::index',compact(['courseslot','course']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('courseslot::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $courseslot = new CourseSlot();
        $courseslot->course_id = $request->course_id;
        $courseslot->name = $request->name;
        $courseslot->TotalCapacity = $request->TotalCapacity;/* 
        $courseslot->CurrentCapacity = $request->CurrentCapacity; */
        $courseslot->save();

        //add batch slot transaction if any
        $batches = CourseBatch::where('course_id',$request->course_id)->get();
        if(count($batches) > 0){
            foreach($batches as $batch){
                if($batch->status == '1'){
                    $slotbatch = new BatchSlotTransaction();
                    $slotbatch->course_id = $courseslot->course_id;
                    $slotbatch->batch_id = $batch->id;
                    $slotbatch->slot_id = $courseslot->id;
                    $slotbatch->is_current = $batch->is_current ? '1':'0';
                    $slotbatch->status = $batch->status == '1' ? '1':'0';
                    $slotbatch->total_capacity = $courseslot->TotalCapacity;
                    $slotbatch->current_capacity = $courseslot->TotalCapacity;
                    $slotbatch->save();
                }
            }
        }


        return redirect()->route('courseslot',$request->course_id)->with('created','courseSlot created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('courseslot::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $courseslot = CourseSlot::find($id);
        return json_encode($courseslot);
    }

    function get_course_slot($id){
        $course = Course::find($id);
        $courseslot = $course->courseSlots;
        return json_encode($courseslot);
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
        $courseslot = CourseSlot::find($id);
        $courseslot->course_id = $request->course_id;
        $courseslot->name = $request->name;
        $courseslot->TotalCapacity = $request->TotalCapacity;/* 
        $courseslot->CurrentCapacity = $request->CurrentCapacity; */
        $courseslot->save();
        $transactions = BatchSlotTransaction::where('slot_id',$courseslot->id)
                        ->where('status','1')
                        ->get();
        if(count($transactions)){
            foreach ($transactions as $transaction) {
                //change current capacity according to new total capacity
                $transaction->current_capacity = $transaction->current_capacity + ( $courseslot->TotalCapacity - $transaction->total_capacity);
                $transaction->total_capacity = $courseslot->TotalCapacity;
                $transaction->save();
            }
        }
        return redirect()->route('courseslot',$request->course_id)->with('updated','course_Slot updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $courseslot = CourseSlot::find($id);
        if($courseslot->Registrations->count() > 0 || $courseslot->Admissions->count() > 0){
           return redirect()->route('courseslot',$courseslot->course_id)->With('prohibited','123'); 
        }

        if($courseslot->delete()){
            $transaction = BatchSlotTransaction::where('slot_id',$courseslot->id);
            $transaction->delete();
            return redirect()->route('courseslot',$courseslot->course_id)->with('deleted','courseSlot deleted successfully');
        }
        else
            return redirect()->route('courseslot',$courseslot->course_id)->with('error','Something went Wrong');
    }
}
