<?php

namespace Modules\CourseSlot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Course\Entities\Course;
class CourseSlotController extends Controller
{
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
        $courseslot->TotalCapacity = $request->TotalCapacity;
        $courseslot->CurrentCapacity = $request->CurrentCapacity;
        $courseslot->save();
        return redirect()->route('courseslot',$courseslot->course_id)->with('created','courseSlot created successfully');
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
        $courseslot->course_id = $request->id;
        $courseslot->name = $request->name;
        $courseslot->TotalCapacity = $request->TotalCapacity;
        $courseslot->CurrentCapacity = $request->CurrentCapacity;
        $courseslot->save();
        return redirect()->route('courseslot',$courseslot->course_id)->with('updated','course_Slot updated successfully');
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

        if($courseslot->delete())
            return redirect()->route('courseslot',$courseslot->course_id)->with('deleted','courseSlot deleted successfully');
        else
            return redirect()->route('courseslot',$courseslot->course_id)->with('error','Something went Wrong');
    }
}
