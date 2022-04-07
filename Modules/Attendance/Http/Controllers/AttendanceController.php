<?php

namespace Modules\Attendance\Http\Controllers;

use Carbon\Carbon;
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

    public function index(){
        $courses = Course::all();
        $firstbatches = CourseBatch::where('course_id',$courses[0]->id)->orderBy('id','DESC')->get();
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

    public function publishAttendance(Request $request){
        $dumpdata = AttendanceImport::all();
        $total_records = $dumpdata->count();
        $success_transaction_arr = []; // This array holds all records which are inserted successfully
        $failed_transaction_arr = []; // This array holds all records which are failed during insertion
        $logs_arr = [];
        //declare array for mapping status
        $status_array = ["Absent" => '0',"Absent(NoOutPunch)"=>'1',"Present"=>'2',"WeeklyOff"=>'3' , "Holiday" =>'4'];
        if($total_records > 0){
            //initialize the a import summary record for this import
            $createdImportSummaryId = $this->createImportSummary('/attendance/imports', $total_records, $request);
            
            //start importing excel file first
            foreach($dumpdata as $datakey => $data){
                    $attendance_date = substr($data->Date,0,10);
                    $roll_number = $data->EmployeeCode;
                    //$temp_roll_no = explode(' ',$data->EmployeeCode);
                    //$roll_number = $temp_roll_no[1] . "-" . $temp_roll_no[0];
                
                    $admission = Admission::where('roll_no',$roll_number)->first();
                    if($admission != null){

                        //check for duplication
                        if(Attendance::where('attendance_date',$attendance_date)
                                        ->where('roll_number',$roll_number)
                                        ->where('course_id',$admission->course_id)
                                        ->count() > 0)
                        {
                            DB::table('attendance_error')->insert([
                                'import_summary_id' => $createdImportSummaryId,
                                'roll_no' => $data->EmployeeCode,
                                'name' => $data->EmployeeName,
                                'reason' => "Attendance already exists in the system.",
                                'date' => $data->Date
                            ]);

                            $failed_transaction_arr[$datakey]['Date'] = $data->Date;
                            $failed_transaction_arr[$datakey]['EmployeeCode'] = $data->EmployeeCode;
                            $failed_transaction_arr[$datakey]['EmployeeName'] = $data->EmployeeName;
                            $failed_transaction_arr[$datakey]['Department'] = $data->Department;
                            $failed_transaction_arr[$datakey]['Status'] = $data->Status;
                            $failed_transaction_arr[$datakey]['PunchRecords'] = $data->PunchRecords;
                            
                        }
                        else{
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
                            //if record saves mark it as success record
                            //archive the record
                            if($attendance->save()){
                                $success_transaction_arr[$datakey]['Date'] = $data->Date;
                                $success_transaction_arr[$datakey]['EmployeeCode'] = $data->EmployeeCode;
                                $success_transaction_arr[$datakey]['EmployeeName'] = $data->EmployeeName;
                                $success_transaction_arr[$datakey]['Department'] = $data->Department;
                                $success_transaction_arr[$datakey]['Status'] = $data->Status;
                                $success_transaction_arr[$datakey]['PunchRecords'] = $data->PunchRecords;
                            }
                            //else record failure
                            else{
                                $failed_transaction_arr[$datakey]['Date'] = $data->Date;
                                $failed_transaction_arr[$datakey]['EmployeeCode'] = $data->EmployeeCode;
                                $failed_transaction_arr[$datakey]['EmployeeName'] = $data->EmployeeName;
                                $failed_transaction_arr[$datakey]['Department'] = $data->Department;
                                $failed_transaction_arr[$datakey]['Status'] = $data->Status;
                                $failed_transaction_arr[$datakey]['PunchRecords'] = $data->PunchRecords;
                                
                                DB::table('attendance_error')->insert([
                                    'import_summary_id' => $createdImportSummaryId,
                                    'roll_no' => $data->EmployeeCode,
                                    'name' => $data->EmployeeName,
                                    'reason' => "system failure",
                                    'date' => $data->Date
                                ]);
                            }
                        }
                    }
                    else{
                        DB::table('attendance_error')->insert([
                            'import_summary_id' => $createdImportSummaryId,
                            'roll_no' => $data->EmployeeCode,
                            'name' => $data->EmployeeName,
                            'reason' => "Roll number not found, please verify the roll number.",
                            'date' => $data->Date
                        ]);

                        $failed_transaction_arr[$datakey]['Date'] = $data->Date;
                        $failed_transaction_arr[$datakey]['EmployeeCode'] = $data->EmployeeCode;
                        $failed_transaction_arr[$datakey]['EmployeeName'] = $data->EmployeeName;
                        $failed_transaction_arr[$datakey]['Department'] = $data->Department;
                        $failed_transaction_arr[$datakey]['Status'] = $data->Status;
                        $failed_transaction_arr[$datakey]['PunchRecords'] = $data->PunchRecords;      
                    }

            }

            //update the summary record to record success and failures
            $update_import_summary_arr = [];
            if(count($failed_transaction_arr) > 0)
            {
                // If there are failed transaction then log the error
                $failed_transaction_file_name = 'failed-'.Str::random(5).''.time().'.csv';
                Excel::store(new AttendanceExportUtil($failed_transaction_arr), $failed_transaction_file_name, 'attendance');
                $update_import_summary_arr['failed_record'] = count($failed_transaction_arr);
                $update_import_summary_arr['failed_transaction_file'] = $failed_transaction_file_name;
            }

            if(count($success_transaction_arr) > 0)
            {
                $sucess_transaction_file_name = 'success-'.Str::random(5).''.time().'.csv';
                Excel::store(new AttendanceExportUtil($success_transaction_arr), $sucess_transaction_file_name, 'attendance');
                $update_import_summary_arr['success_record'] = count($success_transaction_arr);
                $update_import_summary_arr['success_transaction_file'] = $sucess_transaction_file_name;
            }

            if($total_records == count($success_transaction_arr))
            {
                $update_import_summary_arr['status'] = '1';
            }
            else if($total_records == count($failed_transaction_arr))
            {
                $update_import_summary_arr['status'] = '3';
            }
            else
            {
                $update_import_summary_arr['status'] = '2';
            }
            $this->updateImportSummary($createdImportSummaryId, $update_import_summary_arr);
        }
        else
        {
            AttendanceImport::truncate();
            return redirect('attendance/')->with('error','123');
        }

        AttendanceImport::truncate();
        return redirect('attendance/')->with('published','123');
        
    }

    public function abortAttendance(){
        AttendanceImport::truncate();
        return redirect()->route('attendance_import')->with('aborted','123');
    }


    public function createImportSummary($path, $total_records, $request)
    {
        if($request->hasFile('uploaded_file'))
        {
            if (! Storage::exists(public_path().$path)) {
                Storage::makeDirectory(public_path().$path);
            }
            $fileName = 'original-'.Str::random(5).''.time().'.'.request()->uploaded_file->getClientOriginalExtension();
            //Storage::disk('public')->move(request()->uploaded_file,$path.'/'.$fileName);
            request()->uploaded_file->move(public_path('storage/'.$path), $fileName);
            $import_summary_arr['total_record'] = $total_records;
            $import_summary_arr['original_file'] = $fileName;
            $createdImportSummary = ImportSummary::create($import_summary_arr);
            return ($createdImportSummary) ? $createdImportSummary->id : '';
        }
        else
        {
            return false;
        }
    }
    
    public function updateImportSummary($import_summary_id, $summary_arr)
    {
        ImportSummary::find($import_summary_id)->update($summary_arr);
        return true;
    }

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
        
       /*  $attendance = Attendance::query();
        $attendance = $attendance->where('course_id',$courseid)
                                    ->where('courseslot_id',$slotid)
                                    ->where('coursebatch_id',$batchid)
                                    ->orderBy('id', 'DESC'); */
        //$totalApplicationCount = $registrations->count();
        $attendance = DB::select("SELECT UP.STUDENT,AB.*,PR.Present,WO.WeeklyOff,HL.Holiday,TT.Total,((PR.Present/(TT.Total - (WO.WeeklyOff + HL.Holiday))) * 100) AS Attendance FROM
                                    (
                                        (
                                            SELECT student_id,roll_number,COUNT(*) AS Absent FROM `attendances` 
                                            WHERE status IN ('0','1') and course_id = ".$courseid." and courseslot_id = ".$slotid." and coursebatch_id = ".$batchid."
                                            GROUP BY roll_number,student_id
                                        ) AB
                                        JOIN 
                                        (
                                            SELECT id,name AS STUDENT FROM `users` 
                                        ) UP
                                        ON AB.student_id = UP.id
                                        JOIN 
                                        (
                                            SELECT roll_number,COUNT(*) AS Present FROM `attendances` 
                                            WHERE status = '2' and course_id = ".$courseid." and courseslot_id = ".$slotid." and coursebatch_id = ".$batchid."
                                            GROUP BY roll_number
                                        ) PR 
                                        ON AB.roll_number = PR.roll_number
                                        JOIN 
                                        (
                                            SELECT roll_number,COUNT(*) AS WeeklyOff FROM `attendances` 
                                            WHERE status = '3' and course_id = ".$courseid." and courseslot_id = ".$slotid." and coursebatch_id = ".$batchid."
                                            GROUP BY roll_number
                                        ) WO
                                        ON AB.roll_number = WO.roll_number
                                        JOIN
                                        (
                                            SELECT roll_number,COUNT(*) AS Holiday FROM `attendances` 
                                            WHERE status ='4' and course_id = ".$courseid." and courseslot_id = ".$slotid." and coursebatch_id = ".$batchid."
                                            GROUP BY roll_number

                                            UNION

                                            SELECT roll_number,0 AS Holiday FROM `attendances` 
                                            WHERE roll_number NOT IN (SELECT DISTINCT(roll_number) FROM attendances WHERE status = '4')
                                            and course_id = ".$courseid." and courseslot_id = ".$slotid." and coursebatch_id = ".$batchid."
                                            GROUP BY roll_number
                                        ) HL
                                        ON AB.roll_number = HL.roll_number
                                        JOIN 
                                        (
                                            SELECT roll_number,COUNT(*) AS Total FROM `attendances` GROUP BY roll_number
                                        ) TT
                                        ON AB.roll_number = TT.roll_number
                                    )
                                    ORDER BY AB.roll_number DESC
                                    limit ".$limit." offset ".$start." 
                                ");
        
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
                $nestedData['roll_no'] = $attendance->roll_number;
                $nestedData['student_name'] = $attendance->STUDENT;
                $nestedData['student_id'] = $attendance->student_id;
                $nestedData['absent'] = $attendance->Absent;
                $nestedData['present'] = $attendance->Present;
                $nestedData['weekly_off'] = $attendance->WeeklyOff;
                $nestedData['holiday'] = $attendance->Holiday;
                $nestedData['total'] = $attendance->Total;
                $nestedData['attendance'] = $attendance->Attendance;
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
    
    public function importSummary()
    {
        return view('attendance::list_import_summary');
    }

    public function importSummaryData(Request $request)
    {
        $limit = $request->length;
        $start = $request->start;
        $totalSummarryCount = ImportSummary::count();
        
        $import_summary_data = ImportSummary::query();
        /* if(isset($search))
        {
            $import_summary_data = $import_summary_data->where('entity_name','LIKE','%'.$search.'%')
                                                        ->OrWhere('operation','LIKE','%'.$search.'%');
        } */
        $filteredSummaryCount = $import_summary_data->count();
        $import_summary_data = $import_summary_data->orderBy('id','DESC')->skip($start)->limit($limit)->get();

        if(isset($search))
        {
            $totalFiltered = $filteredSummaryCount;
        }
        else
        {
            $totalFiltered = $totalSummarryCount;
        }

        // $totalFiltered = $totalData;
        // $import_summary_data = ImportSummary::orderBy('id','DESC')
        //     ->skip($start)
        //     ->limit($limit)
        //     ->get();

        //data table code without yajara datatable
        $data = array();
        if(count($import_summary_data) > 0)
        {
            foreach ($import_summary_data as $import_summary)
            {
                $nestedData['id'] = $import_summary->id;
                $nestedData['total_record'] = $import_summary->total_record;
                $nestedData['success_record'] = $import_summary->success_record;
                $nestedData['failed_record'] = $import_summary->failed_record;
                $nestedData['status'] = $import_summary->status;
                $nestedData['original_file'] = $import_summary->original_file;
                $nestedData['failed_transaction_file'] = $import_summary->failed_transaction_file;
                $nestedData['success_transaction_file'] = $import_summary->success_transaction_file;
                $nestedData['created_at'] = date("d, M Y", strtotime($import_summary->created_at));
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalSummarryCount),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }

    public function downloadImportSummary($file_name, $flag)
    {
        $decoded_file_name = base64_decode($file_name);
        $file_path = '';
        if($flag == "original")
        {
            $file_path = public_path('storage/attendance/imports/'.$decoded_file_name);
        }
        else
        {
            $file_path = public_path('storage/attendance/exports/'.$decoded_file_name);
        }
        $file = $file_path;
        $name = basename($file);
        return response()->download($file, $name);
    }

    public function importLogs($id)
    {
        return view('attendance::list_error_logs',compact('id'));
    }

    public function importLogsData(Request $request,$id)
    {
        $limit = $request->length;
        $start = $request->start;
        $totalData = DB::table('attendance_error')->count();
        $totalFiltered = $totalData;
        $error_log_data = DB::table('attendance_error')->where('import_summary_id',$id)->skip($start)
            ->limit($limit)
            ->get();

        //data table code without yajara datatable
        $data = array();
        if(count($error_log_data) > 0)
        {
            foreach ($error_log_data as $log_data)
            {
                $nestedData['roll_no'] = $log_data->roll_no;
                $nestedData['name'] = $log_data->name;
                $nestedData['reason'] = $log_data->reason;
                $nestedData['attendance_date'] = date("d, M Y", strtotime($log_data->date));
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
