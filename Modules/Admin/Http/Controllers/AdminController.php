<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admission\Entities\Admission;
use Modules\Course\Entities\Course;
use Modules\CourseBatch\Entities\BatchSlotTransaction;
use Modules\CourseBatch\Entities\CourseBatch;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Registration\Entities\Registration;
use Modules\UserProfile\Entities\UserProfile;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     * 
     * 
     */
    function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $courses = Course::all();
        
        $data['total_registrations'] = Registration::where('status','<>','3')->count();
        $data['total_admissions'] = Admission::count();
        $data['total_batches'] = CourseBatch::where('is_current','1')->count();
        
        $data['total_slots'] = DB::select('SELECT COUNT(DISTINCT courseslot_id) as count FROM `admissions` 
                                            JOIN course_batches ON 
                                            admissions.coursebatch_id = course_batches.id 
                                            WHERE course_batches.is_current = 1');
                                            //dd($data['total_slots']);
        $data['total_slots'] = $data['total_slots'][0]->count;
        $data['total_terminations'] = Admission::where('status','5')->count();
        $data['total_cancellations'] = Admission::where('status','4')->count();
        $data['total_employments'] = Admission::where('status','3')->count();
        $user_stats = $this->getUsersStats();
        $firstbatches = CourseBatch::where('course_id',1)->get();
        return view('admin::dashboard',compact('courses','user_stats','data','firstbatches'));
    }

    public function getCourseAdmissionGraphChart(){
        $courses = Course::all();
        $admission_counts = [];
        $labels = [];
        $colors = [];
        foreach ($courses as $course) {
          array_push($admission_counts,$course->Admissions->count());  
          array_push($labels,$course->name);
          array_push($colors,'#' . dechex(rand(256,16777215)));
        }
        return json_encode(['labels'=>$labels,'count'=>$admission_counts,'colors'=>$colors]);
    }
    public function getCourseEmploymentGraphChart(){
        $admission_counts = DB::select("SELECT R1.CourseId,R1.CourseName,R5.AdmittedCount,R1.CompletedCount,R2.EmployedCount,(R1.CompletedCount - R2.EmployedCount) AS NotEmployedCount ,R3.CancelledCount,R4.TerminatedCount, (R5.AdmittedCount+R1.CompletedCount+R3.CancelledCount+R4.TerminatedCount) AS TotalAdmissions
                                        FROM
                                            (
                                            SELECT DISTINCT U.CourseId ,CS.name AS CourseName, COUNT(AD.course_id) AS CompletedCount 
                                            FROM (SELECT C.id AS CourseId FROM courses C 
                                                        UNION 
                                                    SELECT DISTINCT A.course_id AS CourseId FROM admissions A
                                                ) U 
                                                LEFT JOIN admissions AD on U.CourseId = AD.course_id AND AD.status IN (2,3) 
                                                LEFT JOIN courses CS ON U.CourseId = CS.id     
                                                GROUP BY U.CourseId,CS.name
                                            ) R1
                                        JOIN 
                                            (
                                            SELECT DISTINCT U.CourseId ,CS.name AS CourseName, COUNT(AD.course_id) EmployedCount 
                                            FROM (SELECT C.id AS CourseId FROM courses C 
                                                        UNION 
                                                    SELECT DISTINCT A.course_id AS CourseId FROM admissions A
                                                ) U 
                                                    LEFT JOIN admissions AD on U.CourseId = AD.course_id AND AD.status = 3 
                                                    LEFT JOIN courses CS ON U.CourseId = CS.id     
                                                    GROUP BY U.CourseId,CS.name
                                            ) R2 ON R1.CourseId = R2.CourseID
                                        JOIN 
                                            (
                                            SELECT DISTINCT U.CourseId ,CS.name AS CourseName, COUNT(AD.course_id) AS CancelledCount 
                                            FROM (SELECT C.id AS CourseId FROM courses C 
                                                        UNION 
                                                    SELECT DISTINCT A.course_id AS CourseId FROM admissions A
                                                ) U 
                                                    LEFT JOIN admissions AD on U.CourseId = AD.course_id AND AD.status = 4 
                                                    LEFT JOIN courses CS ON U.CourseId = CS.id     
                                                    GROUP BY U.CourseId,CS.name
                                            ) R3 ON R1.CourseId = R3.CourseID
                                        JOIN 
                                            (
                                            SELECT DISTINCT U.CourseId ,CS.name AS CourseName, COUNT(AD.course_id) AS TerminatedCount 
                                            FROM (SELECT C.id AS CourseId FROM courses C 
                                                        UNION 
                                                    SELECT DISTINCT A.course_id AS CourseId FROM admissions A
                                                ) U 
                                                    LEFT JOIN admissions AD on U.CourseId = AD.course_id AND AD.status = 5
                                                    LEFT JOIN courses CS ON U.CourseId = CS.id     
                                                    GROUP BY U.CourseId,CS.name
                                            ) R4 ON R1.CourseId = R4.CourseID
                                        JOIN 
                                            (
                                            SELECT DISTINCT U.CourseId ,CS.name AS CourseName, COUNT(AD.course_id) AS AdmittedCount 
                                            FROM (SELECT C.id AS CourseId FROM courses C 
                                                        UNION 
                                                    SELECT DISTINCT A.course_id AS CourseId FROM admissions A
                                                ) U 
                                                    LEFT JOIN admissions AD on U.CourseId = AD.course_id AND AD.status = 1
                                                    LEFT JOIN courses CS ON U.CourseId = CS.id     
                                                    GROUP BY U.CourseId,CS.name
                                            ) R5 ON R1.CourseId = R5.CourseID"
                                    );
        $labels = [];
        $completed_count = [];
        $employed_count = [];
        $not_employed_count = [];
        $admitted_count = [];
        $cancelled_count = [];
        $terminated_count = [];
        
        $highestCount = 0;

        foreach ($admission_counts as $count) {
            array_push($labels,$count->CourseName);
            array_push($completed_count,$count->CompletedCount);
            array_push($employed_count,$count->EmployedCount);
            array_push($not_employed_count,$count->NotEmployedCount);
            array_push($admitted_count,$count->AdmittedCount);
            array_push($cancelled_count,$count->CancelledCount);
            array_push($terminated_count,$count->TerminatedCount);
            if($highestCount < $count->TotalAdmissions){
                $highestCount = $count->TotalAdmissions;
            }
        }


        //dd($admission_counts);
        return json_encode(['labels'=>$labels,
                'completed_admissions_counts'=>$completed_count,
                'employed_admissions_counts'=>$employed_count,
                'not_employed_admissions_counts'=>$not_employed_count,
                'admitted_counts'=>$admitted_count,
                'cancelled_counts'=>$cancelled_count,
                'terminated_counts'=>$terminated_count,
                'highest_count' => $highestCount,
            ]);
    }

    public function getReachSourceGraphChart(){
        $raw_count = DB::table('user_profiles')->select(DB::raw('count(how_know_us) as count'))
                                        ->where('is_profile_completed','1')
                                        ->groupby('how_know_us')
                                        ->orderBy('how_know_us')
                                        ->get();
        $labels = ['Newspaper','From a Friend','From a relative','Other','Social Media',];
        $colors = [];
        $count = [];
        foreach($raw_count as $get_count){
          array_push($count,$get_count->count);
        }

        for($i=0;$i<4;$i++){
          array_push($colors,'#' . dechex(rand(256,16777215)));
        }
        return json_encode(['labels'=>$labels,'count'=>$count,'colors'=>$colors]);
    }

    public function getRegistrationGraphChart(){
        $raw_count =  DB::table('registrations')->select(DB::raw('DATE_FORMAT(created_at,"%m")as month ,count(id) as count'))
                            ->orderBy('created_at')
                            ->groupBy('month')
                            ->get();

        //store months as associative so that later we can retireve them via there keys that we get from sql
        $labels_indexes = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
        $labels= [];
        $count = [];
        foreach($raw_count as $get_count){
            array_push($labels,$labels_indexes[$get_count->month]);
            array_push($count,$get_count->count);
        }
        return json_encode(['labels'=>$labels,'count'=>$count]);
    }

    public function getCourseCapacities($course_id = 1){
        $slot_transaction = BatchSlotTransaction::where('course_id',$course_id)->where('is_current','1')->get();
        $course_slots = CourseSlot::where('course_id',$course_id)->get();
        return json_encode(['course_slots'=>$course_slots,'slot_transaction'=>$slot_transaction]);
    }

    public function getBatchWiseAdmissions($batch_id = 1){
        $admission_counts = DB::select("SELECT 
                                CASE WHEN status = '1' THEN 'Admitted'
                                WHEN status = '2' THEN 'Completed'
                                WHEN status = '3' THEN 'Employed'
                                WHEN status = '4' THEN 'Cancelled'
                                WHEN status = '5' THEN 'Terminated'
                                END AS status,
                                COUNT(id) AS admissioncount FROM admissions 
                                WHERE coursebatch_id = ".$batch_id."
                                GROUP BY status");
        $labels = [];
        $colors = ['#36a2eb','#ff6384','#4bc0c0','#ffcd56','#ffa449'];
        $count = [];
        foreach($admission_counts as $admissioncount){
            array_push($count,$admissioncount->admissioncount);  
            array_push($labels,$admissioncount->status);
        }
        return json_encode(['labels'=>$labels,'count'=>$count,'colors'=>$colors]);
                    
    }
    public function getBatches($courseid){
        $coursebatches = Course::find($courseid)->CourseBatches;
        return json_encode(['coursebatch'=>$coursebatches]);
    }

    public function getUsersStats(){

        $yesterday = Carbon::now()->subDays(1);//get yesterday
        $one_week_ago = Carbon::now()->subWeeks(1);//get one week ago
        $two_weeks_ago = Carbon::now()->subWeeks(2);//

        $new_users = User::where('user_type','3')
            ->whereBetween('created_at',[$one_week_ago,$yesterday])
            ->count();//get new users in aweek
        $last_week_new_users = User::where('user_type','3')
            ->whereBetween('created_at',[$two_weeks_ago,$one_week_ago])
            ->count();
        if($last_week_new_users < $new_users){
            if($last_week_new_users >0){
                $percent_from = $new_users - $last_week_new_users;
                $percent = $percent_from / $last_week_new_users * 100; //increase percent
            }else{
                $percent = 100; //increase percent
            }
            $user_count_type = 1;//decreased
        }
        else{
            $percent_from = $last_week_new_users -$new_users;
            $percent = $percent_from / $last_week_new_users * 100; //decrease percent
            $user_count_type = -1;//decreased
        }
        return ['new_count'=>$new_users,'percent'=>floor($percent),'type'=>$user_count_type];
    }
}
