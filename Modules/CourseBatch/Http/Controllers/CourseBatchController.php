<?php

namespace Modules\CourseBatch\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;

class CourseBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $coursebatches = CourseBatch::all();
        $courses = Course::all();
        return view('coursebatch::index',compact(['coursebatches','courses']));
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
        $coursebatch->save();
        return redirect()->route('coursebatch_list')->with('created','course created successfully');
    }

    function changeStatus($id)
    {
        $coursebatch = CourseBatch::find($id);
        if($coursebatch->status == "1")
            $coursebatch->status = "2";
        else
            $coursebatch->status = "1";

        if($coursebatch->save())
            return redirect()->route('coursebatch_list')->with('status','course created successfully');    
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
        $coursebatch->status = $coursebatch->status;
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

        if($coursebatch->delete())
            return redirect()->route('coursebatch_list')->with('deleted','course Updated successfully');
        else
            return redirect()->route('coursebatch_list')->with('error','Something went Wrong');
    }
}
