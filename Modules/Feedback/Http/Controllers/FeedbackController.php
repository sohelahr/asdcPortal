<?php

namespace Modules\Feedback\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Instructor\Entities\Instructor;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $courses = Course::all();
        $firstbatches = CourseBatch::where('course_id',$courses[0]->id)->get();
        $firstslots = CourseSlot::where('course_id',$courses[0]->id)->get();
        return view('feedback::index',compact('courses','firstbatches','firstslots'));
    }

    function getFormData($id)
    {
        $course = Course::find($id);
        $course_slots = $course->CourseSlots;
        $course_batches = $course->CourseBatches;
        $instructors = $course->Instructors;
        return response()->json(['course_slots'=>$course_slots,
                                'course_batches'=>$course_batches,
                                'instructors'=>$instructors,
                                ]);
    }

    public function allFeedbackHeaders($courseid,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
       /*  $feedback_header = feedback_header::query();
        $feedback_header = $feedback_header->where('course_id',$courseid)
                                    ->where('courseslot_id',$slotid)
                                    ->where('coursebatch_id',$batchid)
                                    ->orderBy('id', 'DESC'); */
        //$totalApplicationCount = $registrations->count();
        
        $feedback_header = DB::table('feedback_headers')->skip($start)->limit($limit)->get();
        
        $totalData = count($feedback_header);

        $totalFiltered = $totalData;

        //dd($feedback_header);
        //data table code without yajara datatable
        $data = array();
        if(count($feedback_header) > 0)
        {
            foreach ($feedback_header as $feedback_header)
            {
                $nestedData['id'] = $feedback_header->id;
                $nestedData['course'] = Course::where('id',$feedback_header->course_id)->first()->name;
                $nestedData['coursebatch'] = CourseBatch::where('id',$feedback_header->course_batch_id)->first()->batch_identifier;
                $nestedData['instructor'] = Instructor::where('id',$feedback_header->instructor_id)->first()->firstname ;
                $nestedData['start_date'] = date('d M Y',strtotime($feedback_header->start_date));
                $nestedData['end_date'] = date('d M Y',strtotime($feedback_header->end_date));
                $nestedData['status'] = $feedback_header->status;
                $nestedData['initialized_by'] = $feedback_header->initialized_by;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    public function allFeedbackLine($headerid,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
       /*  $feedback_header = feedback_header::query();
        $feedback_header = $feedback_header->where('course_id',$courseid)
                                    ->where('courseslot_id',$slotid)
                                    ->where('coursebatch_id',$batchid)
                                    ->orderBy('id', 'DESC'); */
        //$totalApplicationCount = $registrations->count();
        
        $feedback_header = DB::table('feedback_headers')->skip($start)->limit($limit)->get();
        
        $totalData = count($feedback_header);

        $totalFiltered = $totalData;

        //dd($feedback_header);
        //data table code without yajara datatable
        $data = array();
        if(count($feedback_header) > 0)
        {
            foreach ($feedback_header as $feedback_header)
            {
                $nestedData['course_'] = $feedback_header->course_id;
                $nestedData['coursebatch'] = $feedback_header->course_batch_id;
                $nestedData['instructor'] = $feedback_header->instructor_id;
                $nestedData['start_date'] = $feedback_header->start_date;
                $nestedData['end_date'] = $feedback_header->end_date;
                $nestedData['status'] = $feedback_header->status;
                $nestedData['initialized_by'] = $feedback_header->initialized_by;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $courses = Course::all();
        return view('feedback::create',compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //default active
        $status = '1';

        //if start date greater than today status initialized
        if(strtotime($request->start_date) > time()){
            $status = '0';
        }

        //if expired date less than today mark expired
        if(strtotime($request->end_date) < time())
        {
            $status = '2';
        }
        
        $insert = DB::table('feedback_headers')->insert([
                        'course_id' => $request->course_id,
                        'course_batch_id' => $request->coursebatch_id,
                        'instructor_id' => $request->instructor_id,
                        'start_date' => date('y-m-d',strtotime($request->start_date)),
                        'end_date' => date('y-m-d',strtotime($request->end_date)),
                        'status' => $status,
                        'initialized_by' => Auth::user()->id,
                    ]);
        if($insert){
            return redirect('/feedback')->with('created','123');
        }
        else{
            return redirect('/feedback')->with('error','123');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('feedback::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('feedback::edit');
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
