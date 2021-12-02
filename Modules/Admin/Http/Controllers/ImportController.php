<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\CourseSlot\Entities\CourseSlot;
use Modules\Registration\Entities\Registration;
use Modules\SerialNumberConfigurations\Http\Controllers\SerialNumberConfigurationsController;
use Modules\UserProfile\Entities\UserProfile;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin::import_index');
    }

    public function importUsers()
    {
        //get distinct users from the temp import sql
        $temp_data = DB::table('temp_import')->get();
        //return count($temp_data);
        //loop them for processing
        foreach ($temp_data as $data) {
            //first lower case the email
            $data->Email = strtolower($data->Email);
            $data->Email = trim($data->Email);

            if($data->Courses_Offered == "Others"){
                DB::table('error_logger')->insert([
                        'email' =>  $data->Email,
                        'name' => $data->Name,
                        'fail_step' => 'User Course Registration and Profile Creation',
                        'error_message' => "Others is Not a Course",
                ]);  
                continue;
            }
            
            $name = explode(' ', $data->Name, 2);
            $check_already_existing = User::where('email',$data->Email)->get();

            //skip if email already imported
            if(count($check_already_existing) > 0 && $check_already_existing[0]->is_imported == 1){
                continue;
                //return $check_already_existing;
            }


            //Tried tackling as many dob combination that i could find some still might be left out
            $dob = str_replace(' ','-',$data->Date_of_Birth);//replace space with hyphen
            $dob = str_replace('.','-',$dob);//replace . with hyphen
            $dob = str_replace('_','-',$dob);//replace underscore with hyphen
            $dob = str_replace('/','-',$dob);//you got it
            $dob = str_replace('\\','-',$dob);
            $dob = str_replace('---','-',$dob);
            $dob = str_replace('--','-',$dob);
            $dob = str_replace('!','1',$dob);
            
            //if there is no spaces between the day month year ex. 17102000 format it 
            if(substr_count($dob,'-') == 0 && strlen($dob) >= 8){
                $dob = substr($dob,0,2)."-".substr($dob,2,2)."-".substr($dob,4);
            }
            //get dob in proper format by converting it into time then date as there are dates with only years or months and years
            $dob = strtotime($dob);
            $age = (date('Y') - date('Y',$dob));
            $dob = date('Y-m-d',$dob);

            $mobile = '';//get proper formated number

            if(substr($data->Phone_Number,0,1) == '+'){
                $mobile = substr(preg_replace('/[^a-zA-Z0-9+]/',"",$data->Phone_Number),3);
            }
            else if(substr($data->Phone_Number,0,1) == "0"){
                $mobile = substr(preg_replace('/[^a-zA-Z0-9+]/',"",$data->Phone_Number),1);
            }
            else {
                $mobile = preg_replace('/[^a-zA-Z0-9+]/',"",$data->Phone_Number);
            }
            

            //get proper occupation id
            //$occupation_id = ['Working' => 6 ,'Student' => 2 ,'Self Employed' => 4 ,'Business' => 5 ,'Others' => 7];
            $occupation_id = 7;
            if($data->Occupation === "Working"){
                $occupation_id = 6;
            }
            else if($data->Occupation === "Student"){
                $occupation_id = 2;
            }
            else if($data->Occupation === "Self Employed"){
                $occupation_id = 4;
            }
            else if($data->Occupation === "Business"){
                $occupation_id = 5;
            } 

            //get proper qualification id
            //$qualifcaion_id = ['Graduation Completed'=> 18 Completed,Graduation Pursuing => 21 Pursuing,
            //Intermediate (12th) Passed =>  19 Passed ,Graduation Discontinued => 18 Left Incomplete,SSC Passed=> 20 Passed,
            //Intermediate (12th) Failed => 19 Failed, SSC Failed =>20 Failed]
            $qualification_id = 18;   
            $qualifcation_status = null;
            if($data->Qualification === "Graduation Completed"){
                $qualification_id = 18;   
                $qualifcation_status = 'Completed';
            }
            else if($data->Qualification === "Graduation Pursuing"){
                $qualification_id = 21;   
                $qualifcation_status = 'Pursuing';
            }
            else if($data->Qualification === "Intermediate (12th) Passed"){
                $qualification_id = 19;   
                $qualifcation_status = 'Passed';
            }
            else if($data->Qualification === "Graduation Discontinued"){
                $qualification_id = 18;   
                $qualifcation_status = 'Left Incomplete';
            }
            else if($data->Qualification === "SSC Passed"){
                $qualification_id = 20;   
                $qualifcation_status = 'Passed';
            }
            else if($data->Qualification === "Intermediate (12th) Failed"){
                $qualification_id = 19;   
                $qualifcation_status = 'Failed';
            } 
            else if($data->Qualification === "SSC Failed"){
                $qualification_id = 20;   
                $qualifcation_status = 'Failed';
            }


            
            //first check if already exist else create new
            if(count($check_already_existing) == 1){
                $check_already_existing = $check_already_existing[0];
                //check if user profile is present this is just a edge condition
                if(isset($check_already_existing->UserProfile)){
                    $existing_profile = $check_already_existing->UserProfile;
                    //now check if profile completed else complete it
                    if($existing_profile->is_profile_completed == "1"){
                        DB::table('error_logger')->insert([
                                'email' =>  $data->Email,
                                'name' => $data->Name,
                                'fail_step' => 'User Account Creation',
                                'error_message' => "Account already exist and completed",
                        ]);
                    }
                    else{

                        try{
                            $userprofile = $existing_profile;
                            $userprofile->firstname = $name[0];
                            if(isset($name[1])){
                                $userprofile->lastname = $name[1];
                            }
                            else{
                                $userprofile->lastname = "N.A";
                            }
                            $userprofile->dob = $dob;
                            $userprofile->age = $age;
                            $userprofile->mobile = $mobile;

                            $userprofile->occupation_id = $occupation_id;
                            $userprofile->qualification_id = $qualification_id;
                            $userprofile->qualification_specilization = "Not Available";
                            $userprofile->qualification_status = $qualifcation_status; 

                            $userprofile->gender = strtolower($data->Gender);
                            $userprofile->comments = $data->Comments;
                            $userprofile->house_details = $data->Address;
                            $userprofile->street = $data->Street;
                            $userprofile->landmark = $data->Landmark;
                            $userprofile->city = $data->City;
                            $userprofile->state = $data->State;
                            $userprofile->pincode = $data->Pincode;
                            $userprofile->how_know_us = $data->How_did_you_know_about_Us;
                            $userprofile->father_name = $data->Father_s_Name;
                            $userprofile->father_occupation = "Not Available";
                            $userprofile->fathers_income = "Not Available";
                            $userprofile->fathers_mobile = "Not Available";
                            $userprofile->school_name = "Not Available";
                            //$userprofile->photo = "";
                            $userprofile->is_profile_completed = "1";
                            $userprofile->user_id = $check_already_existing->id;


                            $userprofile->created_at = $data->Timestamp;
                            //$userprofile->blood_group = $data->Comments;
                            //$userprofile->marital_status = $data->Comments;
                            //$userprofile->aadhaar = $data->Comments;
                            $userprofile->home_type = 'other';


                            $userprofile->created_by = 3;
                            $userprofile->save();
                        }
                        catch(\Illuminate\Database\QueryException $exception){
                            DB::table('error_logger')->insert([
                                'email' =>  $data->Email,
                                'name' => $data->Name,
                                'fail_step' => 'User Already Exist Profile Updation',
                                'error_message' => json_encode($exception->errorInfo),
                            ]);
                        }
                    }
                }

            }
            else{//first check is email is valid then only move forward
                if(filter_var($data->Email, FILTER_VALIDATE_EMAIL)) {
                    try{
                        $user = User::create([
                            'name' => $data->Name,
                            'email' => $data->Email,
                            'password' => Hash::make($name[0]."@asdc123"),
                            'user_type' => '3',
                            'is_verfied' => 1,
                            'is_imported' => 1,
                        ]);
                    }
                    //Catch the error message if user not created and log it
                    catch(\Illuminate\Database\QueryException $exception){
                        DB::table('error_logger')->insert([
                            'email' =>  $data->Email,
                            'name' => $data->Name,
                            'fail_step' => 'User Account Creation',
                            'error_message' => json_encode($exception->errorInfo),
                        ]);
                    }

                    //If user is successfull created move on to making its profile
                    if(isset($user))
                    {

                        try{
                            $userprofile = new UserProfile();
                            $userprofile->firstname = $name[0];
                            if(isset($name[1])){
                                $userprofile->lastname = $name[1];
                            }
                            else{
                                $userprofile->lastname = "N.A";
                            }
                            $userprofile->dob = $dob;
                            $userprofile->age = $age;
                            $userprofile->mobile = $mobile;

                            $userprofile->occupation_id = $occupation_id;
                            $userprofile->qualification_id = $qualification_id;
                            $userprofile->qualification_specilization = "Not Available";
                            $userprofile->qualification_status = $qualifcation_status; 

                            $userprofile->gender = strtolower($data->Gender);
                            $userprofile->comments = strlen($data->Comments) > 110 ? " ": $data->Comments;
                            $userprofile->house_details = $data->Address;
                            $userprofile->street = $data->Street;
                            $userprofile->landmark = $data->Landmark;
                            $userprofile->city = $data->City;
                            $userprofile->state = $data->State;
                            $userprofile->pincode = $data->Pincode;
                            $userprofile->how_know_us = $data->How_did_you_know_about_Us;
                            $userprofile->father_name = $data->Father_s_Name;
                            $userprofile->father_occupation = "Not Available";
                            $userprofile->fathers_income = "Not Available";
                            $userprofile->fathers_mobile = "Not Available";
                            $userprofile->school_name = "Not Available";
                            //$userprofile->photo = "";
                            $userprofile->is_profile_completed = "1";
                            $userprofile->user_id = $user->id;

                            $userprofile->created_at = $data->Timestamp;
                            //$userprofile->blood_group = $data->Comments;
                            //$userprofile->marital_status = $data->Comments;
                            //$userprofile->aadhaar = $data->Comments;
                            $userprofile->home_type = 'other';


                            $userprofile->created_by = 3;
                            $userprofile->save();
                        }
                        catch(\Illuminate\Database\QueryException $exception){
                            DB::table('error_logger')->insert([
                                'email' =>  $data->Email,
                                'name' => $data->Name,
                                'fail_step' => 'User Profile Creation',
                                'error_message' => json_encode($exception->errorInfo),
                            ]);
                        }
                    }
                }
                else{
                  DB::table('error_logger')->insert([
                        'email' =>  $data->Email,
                        'name' => $data->Name,
                        'fail_step' => 'User Account Creation',
                        'error_message' => "Email Not Valid",
                   ]);  
                }
                
            }
        }
    }
    public function importUserRegistration()
    {
        $imported_users = User::where('is_imported',1)->get();

        $courses = ["Website Development" => 5 ,"MS-Office" => 7 ,
                        "Accounting Course (Tally)" => 6,"English Language (Proficiency)" => 8,"Graphic Designing (3D)" => 2,
                        "Pre-Primary Teachers Training" =>12,"Graphic Designing (2D)" => 2 , "Digital Marketing" => 1,
                        "Retails Sales & Marketing" => 11,"Telugu Language" => 9 ,"Video Editing" => 3,
                    ];

        //Excel timings => there database counterparts
        $config_course_slot = ["Afternoon (2pm to 5pm)" => "Afternoon (2pm-5pm)",
                                "Evening (6pm to 9pm)" => "Evening (5pm-8pm)" ,
                                "Morning (10am to 1pm)" => "Morning (10am-1pm)",
                                "Evening (5pm to 8pm)" => "Evening (5pm-8pm)"]; 
                    
        
        //first check if imported users exist
        if(count($imported_users) == 0){
            return " First Import Users ";
        }
        else{
            //get all the temp data from the temp table
            foreach($imported_users as $imported_user){
                $temp_data = DB::table('temp_import')->where('Email',$imported_user->email)->get();
                            return $imported_user->name;
                
                if(count($temp_data) > 0){
                    foreach($temp_data as $data){

                        if($data->Courses_Offered == "Others"){
                            
                            continue;
                        }

                            //get Proper course slot id
                            /* So how ? 
                                well it will get match according to course id 
                                and the name of the timings to get afternoon morning ya eve 
                            */
                            $course_slot = CourseSlot::where('course_id',$courses[$data->Courses_Offered])
                                                    ->where('name',$config_course_slot[$data->Preferred_Timings])
                                                    ->get();                        
                            $course_slot = $course_slot[0];
                            try{        
                                $registration = new Registration();
                                $registration->student_id = $imported_user->id;
                                $registration->course_id = $courses[$data->Courses_Offered];
                                $registration->course_slot_id = $course_slot->id;
                                $registration->status = "1";
                                $registration->is_imported = 1;
                                $registration->created_at = $data->Timestamp;
                                
                                $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                                $registration->save();
                                SerialNumberConfigurationsController::incrementRegistrationNumber();

                            }
                            catch(\Illuminate\Database\QueryException $exception){
                                DB::table('error_logger')->insert([
                                    'email' =>  $data->Email,
                                    'name' => $data->Name,
                                    'fail_step' => 'User Course Registration',
                                    'error_message' => json_encode($exception->errorInfo),
                                ]);
                            }
                                                
                    }
                }
                else{//just an edge case
                    DB::table('error_logger')->insert([
                            'email' =>  $imported_user->email,
                            'name' => $imported_user->name,
                            'fail_step' => 'User Course Registration',
                            'error_message' => "Email Not found",
                    ]); 
                }

            }
        }
    }
    public function importProfilesCourses(){

       $registrations = Registration::all();
       $i = 0;
       foreach($registrations as $registration){
            if(!isset($registration->Student->UserProfile)){
            $i++;   
                
                echo $registration->Student->name." ".$registration->Student->id."<br>";

            }
       }
       print("count ".$i);
       /* SELECT registration_no,u.name,up.mobile FROM `registrations` r
JOIN users u on r.student_id = u.id
JOIN user_profiles up on up.user_id = u.id */

    //     $user_data = DB::select('SELECT u.email FROM users u JOIN user_profiles up ON u.id = up.user_id 
    //                             WHERE u.is_imported = 0 AND up.created_by = 3');

    //     $courses = ["Website Development" => 5 ,"MS-Office" => 7 ,
    //                     "Accounting Course (Tally)" => 6,"English Language (Proficiency)" => 8,"Graphic Designing (3D)" => 2,
    //                     "Pre-Primary Teachers Training" =>12,"Graphic Designing (2D)" => 2 , "Digital Marketing" => 1,
    //                     "Retails Sales & Marketing" => 11,"Telugu Language" => 9 ,"Video Editing" => 3,
    //                 ];

    //     //Excel timings => there database counterparts
    //     $config_course_slot = ["Afternoon (2pm to 5pm)" => "Afternoon (2pm-5pm)",
    //                             "Evening (6pm to 9pm)" => "Evening (5pm-8pm)" ,
    //                             "Morning (10am to 1pm)" => "Morning (10am-1pm)",
    //                             "Evening (5pm to 8pm)" => "Evening (5pm-8pm)"];

    //     if(count($user_data) == 0){
    //         return " First Import Users ";
            
    //     }
    //     else{
    //         foreach($user_data as $imported_user){
    //             $temp_data = DB::table('temp_import')->where('Email',$imported_user->email)->get();
                
    //             if(count($temp_data) > 0){
    //                 foreach($temp_data as $data){

    //                     if($data->Courses_Offered == "Others"){
                            
    //                         continue;
    //                     }

    //                         //get Proper course slot id
    //                         /* So how ? 
    //                             well it will get match according to course id 
    //                             and the name of the timings to get afternoon morning ya eve 
    //                         */
    //                         $course_slot = CourseSlot::where('course_id',$courses[$data->Courses_Offered])
    //                                                 ->where('name',$config_course_slot[$data->Preferred_Timings])
    //                                                 ->get();                        
    //                         $course_slot = $course_slot[0];
    //                         try{        
    //                             $registration = new Registration();
    //                             $registration->student_id = $imported_user->id;
    //                             $registration->course_id = $courses[$data->Courses_Offered];
    //                             $registration->course_slot_id = $course_slot->id;
    //                             $registration->status = "1";
    //                             $registration->is_imported = 1;
    //                             $registration->created_at = $data->Timestamp;
                                
    //                             $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
    //                             $registration->save();
    //                             SerialNumberConfigurationsController::incrementRegistrationNumber();

    //                         }
    //                         catch(\Illuminate\Database\QueryException $exception){
    //                             DB::table('error_logger')->insert([
    //                                 'email' =>  $data->Email,
    //                                 'name' => $data->Name,
    //                                 'fail_step' => 'User Course Registration',
    //                                 'error_message' => json_encode($exception->errorInfo),
    //                             ]);
    //                         }
                                                
    //                 }
    //             }
    //             else{//just an edge case
    //                 DB::table('error_logger')->insert([
    //                         'email' =>  $imported_user->email,
    //                         'name' => $imported_user->name,
    //                         'fail_step' => 'User Course Registration',
    //                         'error_message' => "Email Not found",
    //                 ]); 
    //             }
    //         }
    //     }
    }
}
