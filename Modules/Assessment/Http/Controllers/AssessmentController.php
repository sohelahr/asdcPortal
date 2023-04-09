<?php

namespace Modules\Assessment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admission\Entities\Admission;
use Modules\Assessment\Entities\AssessmentLine;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Instructor\Entities\Instructor;
use Modules\Attendance\Entities\Attendance;
use Modules\Admission\Entities\Exemption;

class AssessmentController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable€€
     */
    public function index()
    {
        $courses = Course::all();
        return view('assessment::index',compact('courses'));
    }

    public function allAssessmentHeaders($courseid,$batchid,$slotid,Request $request){
        $limit = $request->length;
        $start = $request->start;

        $assessment_header = '';
        if($courseid && $batchid && $slotid){
            $assessment_header = DB::table('assesment_headers')->where('course_id',$courseid)
                                    ->where('course_batch_id',$batchid)->where('course_slot_id',$slotid)
                                    ->skip($start)->limit($limit)->get();
        }
        else{
            $assessment_header = DB::table('assesment_headers')->skip($start)->limit($limit)->get();
        }
        
        $totalData = count($assessment_header);

        $totalFiltered = $totalData;

        // dd($assessment_header);
        //data table code without yajara datatable
        $data = array();
        if(count($assessment_header) > 0)
        {
            foreach ($assessment_header as $assessment_header)
            {
                $nestedData['id'] = $assessment_header->id;
                $nestedData['name'] = $assessment_header->assessment_name;
                $nestedData['course'] = Course::where('id',$assessment_header->course_id)->first()->name;
                $nestedData['coursebatch'] = CourseBatch::where('id',$assessment_header->course_batch_id)->first()->batch_identifier;
                $nestedData['courseslot'] = CourseSlot::where('id',$assessment_header->course_slot_id)->first()->name;
                $nestedData['instructor'] = Instructor::where('id',$assessment_header->instructor_id)->first()->firstname ;
                $nestedData['held_on'] = date('d M Y',strtotime($assessment_header->held_on));
                $nestedData['total_marks'] = $assessment_header->total_marks;
                $nestedData['created_by'] = $assessment_header->created_by;
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
        return view('assessment::create',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function createLanguage()
    {
        $courses = Course::all();
        return view('assessment::create_language',compact('courses'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $data = [
                'course_id' => $request->course_id,
                'course_batch_id' => $request->coursebatch_id,
                'course_slot_id' => $request->courseslot_id,
                'assessment_name' => $request->assessment_name,
                'instructor_id' => $request->instructor_id,
                'held_on' => date('Y-m-d',strtotime($request->held_on)),
                'max_theory' => $request->max_theory,
                'max_practical' => $request->max_practical,
                'total_marks' => $request->max_theory + $request->max_practical,
                'created_by' => Auth::user()->id,
        ];

        if($request->is_language_assesment){
           $data = array_merge($data,['is_language_assesment' => 1,'language_course_id' => $request->language_course_id]);
        }

        $insert = DB::table('assesment_headers')->insert($data);
        if($insert){
            return redirect('/assessment')->with('created','123');
        }
        else{
            return redirect('/assessment')->with('error','123');
        }
    }

    public function viewAssessmentHeader($header_id){
        $assessment_header = DB::table('assesment_headers')->where('id',$header_id)->first();
        $course = Course::where('id',$assessment_header->course_id)->first()->name;
        $coursebatch = CourseBatch::where('id',$assessment_header->course_batch_id)->first()->batch_identifier;
        $courseslot = CourseSlot::where('id',$assessment_header->course_slot_id)->first()->name;
        $instructor = Instructor::where('id',$assessment_header->instructor_id)->first()->firstname ;
        $created_by = User::where('id',$assessment_header->created_by)->first()->name;

        $language = $assessment_header->is_language_assesment ? Course::where('id',$assessment_header->language_course_id)->first()->name : "";


        return view('assessment::alladmissionperheader',
                        compact('assessment_header','course','coursebatch','courseslot','language','instructor','created_by'));
    }

    public function allAdmissionsPerAssessmentHeader($header_id,Request $request){
        $status = true;
        $data = array();
        $assessment_header = DB::table('assesment_headers')->where('id',$header_id)->first();
        $admissions = Admission::where('course_id',$assessment_header->course_id)
                                        ->where('coursebatch_id',$assessment_header->course_batch_id)
                                        ->where('courseslot_id',$assessment_header->course_slot_id)
                                        ->get();
        $exemptions = [];
        if($assessment_header->is_language_assesment){
            $exemptions =  Exemption::where('exempted_course',$assessment_header->language_course_id)->pluck('admission_id')->toArray();
        }   
        if($admissions->count() > 0){

            //data table code without yajara datatable
            if(count($admissions) > 0)
            {
                foreach ($admissions as $admission)
                {
                    if(!in_array($admission->id,$exemptions)){
                        $student = $admission->Student->UserProfile;
                        $line = AssessmentLine::where('header_id',$assessment_header->id)
                                                ->where('admission_id',$admission->id)
                                                ->first();
    
                        $nestedData['admission_id'] = $admission->id;
                        $nestedData['student_id'] = $admission->student_id;
                        $nestedData['header_info'] = $assessment_header;
                        $nestedData['roll_no'] = $admission->roll_no;
                        $nestedData['name'] = $student->firstname . ' ' . $student->lastname;
                        $nestedData['theory_marks'] = $line ? $line->theory_marks : 0;
                        $nestedData['practical_marks'] = $line ? $line->practical_marks : 0;
                        $nestedData['total_marks'] = $line ? $line->total_marks : 0;
                        $data[] = $nestedData;
                    }
                }
            }
            
        }
        else{
            $status = false;
        }
        $json_data = array(
            "status" => $status,
            "data"   => $data
        );
        
        return json_encode($json_data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $header_id)
    {
        //create or update lines
        $assessment_header = DB::table('assesment_headers')->where('id',$header_id)->first();

        $status = true;
        $data = array();

        $total_marks = $request->total_marks;
        $theory = $request->theory;
        $practical = $request->practical;
        if($total_marks == $theory + $practical){
            $line = AssessmentLine::updateOrCreate(
                        ['header_id' =>  $assessment_header->id,'admission_id' => $request->admission_id],
                        ['student_id' => $request->student_id],
                    );
            $line->theory_marks = $theory;
            $line->practical_marks = $practical;
            $line->total_marks = $total_marks;
            $line->created_by = Auth::user()->id;
            if($line->save()){
                $data['success_message'] = "Marks saved successfully";
            }
            else{
                $status = false;
                $data['error_message'] = "Something went wrong, please try again";    
            }
        }
        else{
            $status = false;
            $data['error_message'] = "Improper Data";    
        }

        $json_data = array(
            "status" => $status,
            "data"   => $data
        );
        
        return json_encode($json_data);
    }

    public function calculatingGrade(Request $request){
        $status = true;
        $data = array();

        $lines = AssessmentLine::where('admission_id',$request->admission_id)->get();
        $data['description'] = array();
        
        $total_marks_recieved = 0;
        $total_marks_assessed = 0;
        $total_recieved_percentage = 0;
        $average_percentage = 0;
        
        //All assessments besides languages
        if(count($lines) > 0){
            foreach ($lines as $line) {
                $header =  DB::table('assesment_headers')->where('id',$line->header_id)->first();

                if(!$header->is_language_assesment){
                    $percentage_total = number_format((float)(($line->total_marks / $header->total_marks) * 100), 2, '.', '');
                    $total_marks_recieved += $line->total_marks;
                    $total_marks_assessed += $header->total_marks;

                    $total_recieved_percentage += $percentage_total;

                    array_push($data['description'],[
                        'name' => $header->assessment_name, 
                        'theory' => $line->theory_marks."/".$header->max_theory, 
                        'practical' => $line->practical_marks."/".$header->max_practical,
                        'total' => $line->total_marks."/".$header->total_marks
                    ]);
                    
                    $average_percentage = $total_recieved_percentage / count($lines);

                    $data['marks'] = [
                        'total_marks_recieved' => $total_marks_recieved,
                        'total_marks_assessed' => $total_marks_assessed,
                        'average_percentage' => $average_percentage,
                    ];
                }
            }

        }
        else{
            $status = false;
            $data['error_message'] = "Please enter marks for atleast one assessment";    
        }

        /* Attendances */
        $attendances = Attendance::where('admission_id',$request->admission_id)->get();
        
        $total_days = 0;
        $total_present_days = 0;
        $total_attendance = 0;
        
        $average_total_attendance = 0;

        if(count($lines) > 0 && count($attendances) == $request->attendance_months_count)
        {
            foreach ($attendances as $attendance)
            {
                $total_present_days += $attendance->present_days;
                $total_days += $attendance->total_days;
                $total_attendance += number_format((float)(($attendance->present_days / $attendance->total_days) * 100), 2, '.', '');   
            }
            $average_total_attendance = round($total_attendance / count($attendances),2);

            $data['attendance'] = [
                'total_days' => $total_days,
                'total_present_days' => $total_present_days,
                'average_total_attendance' => $average_total_attendance,
            ];
        }
        else{
            $status = false;
            $data['error_message'] = "Please mark full attendance";    
        }

        $grade = 'F';
        $avg_marks_attendance = ($average_total_attendance + $average_percentage) / 2;
        //75% > A , 65 - 74 B , 50 - 64 - C , 40 - 49 D ,  40 less than F
        if($avg_marks_attendance >= 75){
            $grade = 'A';
        }
        else if($avg_marks_attendance >= 65 && $avg_marks_attendance < 75){
            $grade = 'B';
        }
        else if($avg_marks_attendance >= 50  && $avg_marks_attendance < 65){
            $grade = 'c';
        }
        else if($avg_marks_attendance >= 40  && $avg_marks_attendance < 50){
            $grade = 'D';
        }

        $data['grade'] = [ 'grade' => $grade, 'percent' => round($avg_marks_attendance,2) ];

        $json_data = array(
            "status" => $status,
            "data"   => $data
        );
        
        return json_encode($json_data);
    }

    public function admissionwiseAssessment(Request $request,$admission_id){
        //Assessments
        $status = true;
        $data = array();
        $lines = AssessmentLine::where('admission_id',$admission_id)->get();   
        $assessments = array();

        if(count($lines) > 0){
            foreach ($lines as $line) {
                $header =  DB::table('assesment_headers')->where('id',$line->header_id)->first();

                array_push($assessments,[
                    'name' => $header->assessment_name, 
                    'theory' => $line->theory_marks."/".$header->max_theory, 
                    'practical' => $line->practical_marks."/".($header->max_practical ? $header->max_practical : 0 ),
                    'total' => $line->total_marks."/".$header->total_marks
                ]);
            }
        }
        else{
            $status = false;
        }

        $json_data = array(
            "status" => $status,
            "data"   => $assessments
        );
        return json_encode($json_data);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $line = AssessmentLine::where('header_id',$id)->count();
        if($line)
        {
           return redirect('/assessment')->with('prohibited','123'); 
        }

        $del = DB::table('assesment_headers')->where('id',$id)->delete();
        if($del){
            return redirect('/assessment')->with('deleted','Assessment deleted successfully');
        }
        else{
            return redirect('/assessment')->with('error','Something went Wrong');
        }
    }
}
