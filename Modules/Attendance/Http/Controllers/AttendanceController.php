<?php

namespace Modules\Attendance\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admission\Entities\Admission;
use Modules\Attendance\Entities\Attendance;
use Modules\Attendance\Entities\AttendanceImport;
use Modules\Attendance\Http\Import\AttendanceImportUtil;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;

//use Modules\Attendance\Http\Import\AttendanceImportData;

class AttendanceController extends Controller
{

    function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        $courses = Course::all();
        $firstbatches = CourseBatch::where('course_id',$courses[0]->id)->get();
        $firstslots = CourseSlot::where('course_id',$courses[0]->id)->get();
        return view('attendance::index',compact('courses','firstbatches','firstslots'));
    }

    public function newAttendance(){
        return view('attendance::import');
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


    public function dumpAttendance(Request $request){
        try
        {
            AttendanceImport::truncate();
            Excel::import(new AttendanceImportUtil,request()->file('uploaded_file'));
            //BeneficiaryImportHelper::importBeneficiary($request);
            return json_encode(['status' => '1', 'type' => 'beneficiary_import', 'message' => ' File imported successfully...!']);              
        }
        catch (\Exception $e)
        {
            $failures = $e->getMessage();
            return json_encode(['status' => '0', 'type' => 'error', 'message' => $failures]);
        } 
    }

    public function previewAttendance(Request $request){
        $limit = $request->length;
        $start = $request->start;
        
        $attendancedump = AttendanceImport::query();
        /* $attendancedump = $attendancedump->where('created_at','>',Carbon::today()); */
        //$totalApplicationCount = $registrations->count();
        $totalData = $attendancedump->count();

        $totalFiltered = $totalData;

        $attendancedump = $attendancedump->skip($start)->limit($limit)->get();
        //data table code without yajara datatable
        $data = array();
        if(count($attendancedump) > 0)
        {
            foreach ($attendancedump as $attendancedump)
            {
                $nestedData['Date'] = $attendancedump->Date;
                $nestedData['EmployeeCode'] = $attendancedump->EmployeeCode;
                $nestedData['EmployeeName'] = $attendancedump->EmployeeName;
                $nestedData['Department'] = $attendancedump->Department;
                $nestedData['Status'] = $attendancedump->Status;
                $nestedData['PunchRecords'] = $attendancedump->PunchRecords;
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

    public function publishAttendance(){
        $dumpdata = AttendanceImport::all();
        //declare array for mapping status
        $status_array = ["Absent" => '0',"Absent(NoOutPunch)"=>'1',"Present"=>'2',"WeeklyOff"=>'3' , "Holiday" =>'4'];
        //start importing excel file first
        foreach($dumpdata as $data){

            //archive the record
            DB::table('attendance_archive')->insert([
                'Date' => $data->Date,
                'EmployeeCode' => $data->EmployeeCode,
                'EmployeeName' => $data->EmployeeName,
                'Department' => $data->Department,
                'Status' => $data->Status,
                'PunchRecords' => $data->PunchRecords,
            ]);

            try{
                $attendance_date = substr($data->Date,0,10);
                $roll_number = '';
                $temp_roll_no = explode(' ',$data->EmployeeCode);
                $roll_number = $temp_roll_no[1] . "-" . $temp_roll_no[0]; 
            
                $admission = Admission::where('roll_no',$roll_number)->first();
                if($admission != null){
                    $attendance = new Attendance();
                    $attendance->attendance_date = $attendance_date;
                    $attendance->roll_number =  $admission->roll_no;
                    $attendance->course_id = $admission->course_id;
                    $attendance->courseslot_id = $admission->courseslot_id;
                    $attendance->coursebatch_id = $admission->coursebatch_id;
                    $attendance->student_id = $admission->student_id;
                    $attendance->admission_id = $admission->id;
                    $attendance->status = $status_array[$data->Status];
                    $attendance->punch_record = $data->PunchRecords;

                    //dd($attendance);
                    $attendance->save();
                }
                else{
                    DB::table('attendance_error')->insert([
                        'roll_no' => $data->EmployeeCode,
                        'name' => $data->EmployeeName,
                        'reason' => "roll number not found check roll number field again in biometric",
                        'date' => $data->Date
                    ]);
                }
            
            }
            catch(\Exception $e){
                DB::table('attendance_error')->insert([
                    'roll_no' => $data->EmployeeCode,
                    'name' => $data->EmployeeName,
                    'reason' => $e->getMessage(),
                    'date' => $data->Date
                ]);
            }

        }

        AttendanceImport::truncate();
        return redirect('attendance/')->with('published','123');

        
    }

    public function abortAttendance(){
        AttendanceImport::truncate();
        return redirect()->route('attendance_import')->with('aborted','123');
    }
/* 
    public function userAttendance($id){
        $admission_wise_attendance =  
    } */

    public function admissionwiseAttendance($id,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
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
                $nestedData['date'] = $attendance->attendance_date;
                $nestedData['status'] = $attendance->status;
                $nestedData['punch_records'] = $attendance->punch_record;
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

    public function allAttendance($courseid,$slotid,$batchid,Request $request){
        $limit = $request->length;
        $start = $request->start;
        
        $attendance = Attendance::query();
        $attendance = $attendance->where('course_id',$courseid)
                                    ->where('courseslot_id',$slotid)
                                    ->where('coursebatch_id',$batchid)
                                    ->orderBy('id', 'DESC');
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
                $nestedData['date'] = $attendance->attendance_date;
                $nestedData['status'] = $attendance->status;
                $nestedData['punch_records'] = $attendance->punch_record;
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
