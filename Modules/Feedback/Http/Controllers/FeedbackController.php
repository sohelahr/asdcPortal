<?php

namespace Modules\Feedback\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admission\Entities\Admission;
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
        return view('feedback::index');
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

    public function indexLines($headerid)
    {
        $feedback_header = DB::table('feedback_headers')->where('id',$headerid)->first();
        $course = Course::where('id',$feedback_header->course_id)->first()->name;
        $coursebatch = CourseBatch::where('id',$feedback_header->course_batch_id)->first()->batch_identifier;
        $instructor = Instructor::where('id',$feedback_header->instructor_id)->first()->firstname ;
        return view('feedback::lines.index',compact('feedback_header','course','coursebatch','instructor'));
    }

    public function allFeedbackLines($headerid,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
        $feedback_lines = DB::table('feedback_lines')->where('feedback_header_id',$headerid)
                                ->skip($start)->limit($limit)->get();
        
        $totalData = count($feedback_lines);

        $totalFiltered = $totalData;

        //dd($feedback_lines);
        //data table code without yajara datatable
        $data = array();
        if(count($feedback_lines) > 0)
        {
            foreach ($feedback_lines as $feedback_lines)
            {
                $nestedData['id'] = $feedback_lines->id;
                $nestedData['student_id'] = $feedback_lines->student_id;
                $nestedData['student_name'] = User::where('id',$feedback_lines->student_id)->first()->name;
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

    public function ViewLine($feedback_line_id)
    {

        $feedback_line = DB::table('feedback_lines')->where('id',$feedback_line_id)->first();
        $feedback_header = DB::table('feedback_headers')->where('id',$feedback_line->feedback_header_id)->first();
        $course = Course::where('id',$feedback_header->course_id)->first();
        $batch = CourseBatch::where('id',$feedback_header->course_batch_id)->first();
        $instructor = Instructor::where('id',$feedback_header->instructor_id)->first();
        $student_name = User::where('id',$feedback_line->student_id)->first()->name;
//        dd(compact('course','batch','feedback_header','instructor'));
        return view('feedback::lines.view',compact('course','batch','feedback_header','student_name','instructor','feedback_line'));
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

    public function allFeedbackHeadersPerAdmission(Request $request){
        $limit = $request->length;
        $start = $request->start;
        $admitted_courses = Admission::where('student_id',Auth::user()->id)->get(['course_id','coursebatch_id']);
        $course_ids = [];
        $course_batch_ids = [];
        //dd($admitted_courses);
        foreach($admitted_courses as $admitted_courses){
            array_push($course_ids,$admitted_courses->course_id);
            array_push($course_batch_ids,$admitted_courses->coursebatch_id);
        }
        $feedback_header = DB::table('feedback_headers')->whereIn('course_id',$course_ids)
                                        ->whereIn('course_batch_id',$course_batch_ids)
                                        ->where('status','<>','0')
                                        ->skip($start)->limit($limit)->get();
        
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
                $nestedData['header_status'] = $feedback_header->status;
                $nestedData['initialized_by'] = $feedback_header->initialized_by;
                $nestedData['filled_status'] = DB::table('feedback_lines')
                                                    ->where('feedback_header_id',$feedback_header->id)
                                                    ->where('student_id',Auth::user()->id)
                                                    ->count();
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

    public function createLines($feedback_header_id)
    {
        $feedback_header_id = base64_decode($feedback_header_id);

        $feedback_header = DB::table('feedback_headers')->where('id',$feedback_header_id)->first();

        if($feedback_header->status == '2'  ){
            return redirect('/dashboard')->with('unauthorized','123');
        }

        if(DB::table('feedback_lines')
                ->where('feedback_header_id',$feedback_header_id)
                ->where('student_id',Auth::user()->id)
                ->count() > 0
        )
        {
            return redirect('/dashboard')->with('unauthorized','123');
        }
        $course = Course::where('id',$feedback_header->course_id)->first();
        $batch = CourseBatch::where('id',$feedback_header->course_batch_id)->first();
        $instructor = Instructor::where('id',$feedback_header->instructor_id)->first();
//        dd(compact('course','batch','feedback_header','instructor'));
        return view('feedback::lines.create',compact('course','batch','feedback_header','instructor'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function storeLines(Request $request,$feedback_header_id)
    {
        //dd($request);
        $feedback_header_id = base64_decode($feedback_header_id);
        $data = [];
        $data['feedback_header_id'] = $feedback_header_id;
        $data['admission_id'] = Admission::where('course_id',$request->course_id)
                                            ->where('coursebatch_id',$request->coursebatch_id)
                                            ->where('student_id',Auth::user()->id)->first()->id;
        $data['student_id'] = Auth::user()->id;
        $data['qOne'] = $request->qOne;
        $data['qTwo'] = $request->qTwo;
        $data['qThree'] = $request->qThree;
        $data['qFour'] = $request->qFour;
        $data['qFive'] = $request->qFive;
        $data['qSix'] = $request->qSix;
        $data['qSeven'] = $request->qSeven;
        $data['qEight'] = $request->qEight;
        $data['qNine'] = $request->qNine;
        $data['qTen'] = $request->qTen;
        $data['qTwelve'] = $request->qTwelve;
        $data['qThirteen'] = $request->qThirteen;
        $data['qFourteen'] = $request->qFourteen;
        $data['qFifteen'] = $request->qFifteen;
        $data['qSixteen'] = $request->qSixteen;
        $data['qSeventeen'] = $request->qSeventeen;
        $data['qEighteen'] = $request->qEighteen;
        $data['qNineteen'] = $request->qNineteen;
        $data['qTwenty'] = $request->qTwenty;
        $data['qTwentyOne'] = $request->qTwentyOne;
        $data['qTwentyTwo'] = $request->qTwentyTwo;
        $data['qTwentyThree'] = $request->qTwentyThree;
        $data['feedback'] = $request->feedback; 
        //dd($data);
        $insert = DB::table('feedback_lines')->insert($data);
        if($insert){
            return redirect('/dashboard')->with('feedback_created','123');
        }
        else{
            return redirect('/dashboard')->with('error','123');
        }
    }


}
