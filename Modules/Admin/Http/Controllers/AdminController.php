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
        $user_stats = $this->getUsersStats();
        $data['total_registrations'] = Registration::count();
        $data['total_admissions'] = Admission::count();
        $data['total_batches'] = CourseBatch::where('is_current','1')->count();
        $data['total_slots'] = CourseSlot::where('TotalCapacity','>','CurrentCapacity')->count();
        $data['total_terminations'] = Admission::where('status','5')->count();
        $data['total_cancellations'] = Admission::where('status','4')->count();
        $data['total_employments'] = Admission::where('status','3')->count();

        $course_wise_admissions_graphs = json_encode($this->getCourseAdmissionGraphChart());
        $course_wise_employments_graphs = json_encode($this->getCourseEmploymentGraphChart());
        $registration_graphs = json_encode($this->getRegistrationGraphChart());
        $reach_graphs = json_encode(($this->getReachSourceGraphChart()));
        $initial_gauges = $this->getCourseCapacities();
        return view('admin::dashboard',compact('courses','user_stats','data','course_wise_admissions_graphs','reach_graphs','registration_graphs','initial_gauges'));
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
        return ['labels'=>$labels,'count'=>$admission_counts,'colors'=>$colors];
    }
    public function getCourseEmploymentGraphChart(){
        $completed_admissions_raw_counts = DB::table('admissions')->select(DB::raw('count(id)'))
                                        ->where('status','2')
                                        ->orderBy('course_id')
                                        ->groupby('course_id')
                                        ->get()->toArray();
        $employed_admissions_raw_counts = DB::table('admissions')->select(DB::raw('count(id)'))
                                        ->where('status','3')
                                        ->groupby('course_id')
                                        ->get()->toArray();
        
        $courses = Course::all();
        $completed_admissions_counts = [];
        $employed_admissions_counts =  [];

        /* foreach($completed_admissions_raw_counts as $completed_admissions_raw_count){
                array_push($completed_admissions_counts,)
        } */


        $labels_indexes = [];
        foreach ($courses as $course) {
            array_push($labels_indexes,[ $course->id => $course->name]);
        }
        return [/* 'labels'=>$labels, */'completed_admissions_counts'=>$completed_admissions_counts,'employed_admissions_counts'=>$employed_admissions_counts];
    }

    public function getReachSourceGraphChart(){
        $raw_count = DB::table('user_profiles')->select(DB::raw('count(id) as count'))
                                        ->where('is_profile_completed','1')
                                        ->groupby('how_know_us')
                                        ->get();
        $labels = ['Newspaper','From a Friend','From a relative','Social Media'];
        $colors = [];
        $count = [];
        foreach($raw_count as $get_count){
          array_push($count,$get_count->count);
        }

        for($i=0;$i<4;$i++){
          array_push($colors,'#' . dechex(rand(256,16777215)));
        }
        return ['labels'=>$labels,'count'=>$count,'colors'=>$colors];
    }

    public function getRegistrationGraphChart(){
        $raw_count =  DB::table('registrations')->select(DB::raw('DATE_FORMAT(created_at,"%m")as month ,count(id) as count'))
                            ->orderBy('created_at')
                            ->groupBy('month')
                            ->get();

        //store months as associative so that later we can retireve them via there keys that we get from sql
        $labels_indexes = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
        $labels= [];
        $count = [];
        foreach($raw_count as $get_count){
            array_push($labels,$labels_indexes[$get_count->month]);
            array_push($count,$get_count->count);
        }
        return ['labels'=>$labels,'count'=>$count];
    }

    public function getCourseCapacities($course_id = 1){
        $course_slots = CourseSlot::where('course_id',$course_id)->get();
        return json_encode($course_slots);
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
/* 
        $data['new_registration'] = Registration::whereBetween('created_at',[$one_week_ago,$yesterday])
            ->count();
        $data['new_reg_percent'] = floor(($data['new_registration']/$data['total_registration']) * 100 */
        /* $data['graph_user'] = User::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                            ->groupby('year','month')
                            ->get(); */