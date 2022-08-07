<?php

namespace Modules\Attendance\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admission\Entities\Admission;
use Modules\Attendance\Entities\Attendance;
use Modules\Attendance\Entities\AttendanceImport;
use Modules\Attendance\Entities\ImportSummary;
use Modules\Attendance\Http\Export\AttendanceExportUtil;
use Modules\Attendance\Http\Import\AttendanceImportUtil;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Str;
//use Modules\Attendance\Http\Import\AttendanceImportData;

class AttendanceController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    function getFormData($id)
    {
        $course = Course::find($id);
        $course_slots = $course->CourseSlots;
        $course_batches = $course->CourseBatches;
        return response()->json(['course_slots'=>$course_slots,
                                'course_batches'=>$course_batches,
                                ]);
    }

    public function getMonths($startdate,$enddate){
        $start    = (new DateTime($startdate))->modify('first day of this month');
        $end      = (new DateTime($enddate))->modify('last day of this month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $months = [];

        foreach ($period as $dt) {
            array_push($months,['value'=>$dt->format("n"),'label'=>$dt->format("F")]);
        }
        return $months;
    }

    public function index(){
        $courses = Course::all();
        $firstbatches = CourseBatch::where('course_id',$courses[0]->id)->orderBy('id','DESC')->get();
        $firstslots = CourseSlot::where('course_id',$courses[0]->id)->get();
        $firstmonths = $this->getMonths($firstbatches[0]->start_date,$firstbatches[0]->expiry_date);
        return view('attendance::index',compact('courses','firstbatches','firstslots','firstmonths'));
    }

    public function store(Request $request){
        $employement = new Attendance();
        $employement->admission_id = $request->admission_id;
        $employement->course_id = $request->course_id;
        $employement->user_id = $request->user_id;
        $employement->coursebatch_id = $request->coursebatch_id;
        $employement->courseslot_id = $request->courseslot_id;
        
        $employement->present_days = $request->present_days;
        $employement->absent_days = $request->absent_days;
        $employement->total_days = $request->absent_days + $request->present_days;

        $employement->month_id = $request->month_id;
        if($employement->save())
        {
            return redirect()->route('admission_show',[$request->admission_id])->with('attendance_created','created');
        }
        else{
            return redirect()->route('admission_show',[$request->admission_id])->with('error','created');
        }
    }

    public function admissionwiseAttendance($id,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
        $months = ['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'];
        

        $attendance = Attendance::query();
        $attendance = $attendance->where('admission_id',$id)->orderBy('id', 'DESC');
        //$totalApplicationCount = $registrations->count();
        $totalData = $attendance->count();

        $totalFiltered = $totalData;

        $attendance = $attendance->skip($start)->limit($limit)->get();
        //data table code without yajara datatable
        $data = array();
        if(count($attendance) > 0)
        {
            foreach ($attendance as $attendance)
            {
                $nestedData['month'] = $months[$attendance->month_id];
                $nestedData['absent'] = $attendance->absent_days;
                $nestedData['present'] = $attendance->present_days;
                $nestedData['total'] = $attendance->total_days;
                $nestedData['remarks'] = $attendance->remarks ? $attendance->remarks : 'There are no remarks';
                $nestedData['attendance'] = number_format((float)(($attendance->present_days / $nestedData['total']) * 100), 2, '.', '');
                
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

    public function allAttendance($courseid,$slotid,$batchid,$monthid,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
        $attendance = Attendance::query();
        $attendance = $attendance->where('course_id',$courseid)
                                    ->where('courseslot_id',$slotid)
                                    ->where('coursebatch_id',$batchid)
                                    ->where('month_id',$monthid)
                                    ->orderBy('id', 'DESC');
        //$totalApplicationCount = $registrations->count();
        $attendance = $attendance->skip($start)->limit($limit)->get();
        $totalData = count($attendance);

        $totalFiltered = $totalData;

        //$attendance = $attendance->skip($start)->limit($limit)->toSql();
        //dd($attendance);
        //data table code without yajara datatable
        $data = array();
        if(count($attendance) > 0)
        {
            foreach ($attendance as $attendance)
            {
                $nestedData['roll_no'] = Admission::find($attendance->admission_id)->roll_no;
                $nestedData['student_name'] = User::find($attendance->user_id)->name;
                $nestedData['student_id'] = $attendance->user_id;
                $nestedData['absent'] = $attendance->absent_days;
                $nestedData['present'] = $attendance->present_days;
                $nestedData['total'] = $attendance->total_days;
                $nestedData['remarks'] = $attendance->remarks ? $attendance->remarks : 'There are no remarks';
                $nestedData['attendance'] = number_format((float)(($attendance->present_days / $nestedData['total']) * 100), 2, '.', '');
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

}
