<?php

namespace Modules\SubAdmin\Http\Controllers;

use App\Http\Controllers\MailController;
use App\Http\Helpers\GetLocation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Course\Entities\Course;
use Modules\Occupation\Entities\Occupation;
use Modules\Qualification\Entities\Qualification;
use Modules\Registration\Entities\Registration;
use Modules\SerialNumberConfigurations\Http\Controllers\SerialNumberConfigurationsController;
use Modules\UserProfile\Entities\UserProfile;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $subadmins= User::where('user_type','2')->get();
        return view('subadmin::index',compact('subadmins'));
    }

    public function createStudent()
    {
        $occupations = Occupation::all();
        $qualifications = Qualification::all();
        $courses = Course::all();
        $states = GetLocation::getStates(101);
        return view('subadmin::create_student',compact('courses','occupations','qualifications','states'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            /* 'mobile' => ['required', 'max:10', 'unique:user_profiles'], */
            'aadhaar' => ['required', 'unique:user_profiles'],            
        ]);
        $name = $request->first_name ." ".$request->last_name;

        /* First create A User */

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->first_name.'@asdc'.date('Y')),
            'user_type' => '3',
            'is_verified' => 1,
        ]);
        
        event(new Registered($user));
        //Then make user profile

        if($user){
            $content = [
                'name' =>  $user->name,
                'mail' =>  $user->email,
                'pwd' =>   $request->first_name.'@asdc'.date('Y')
            ];

            MailController::sendAdminCreatedUserEmail($request->email,$content);

            $userprofile = new UserProfile();
            $userprofile->firstname = $request->first_name;
            $userprofile->lastname = $request->last_name;
            $userprofile->user_id = $user->id;
            $userprofile->dob = date('y/m/d',strtotime($request->dob));
            $userprofile->age = $request->age;
            $userprofile->mobile = $request->mobile; 
            $userprofile->occupation_id = $request->occupation_id; 
            $userprofile->qualification_id = $request->qualification_id;
            $userprofile->qualification_specilization = $request->qualification_specilization;
            $userprofile->qualification_status = $request->qualification_status;
            $userprofile->gender = $request->gender;
            if(isset($request->comments)){
                $userprofile->comments = $request->comments.'\n Registration Created By '.Auth::user()->name; 
            }
            else{
                $userprofile->comments = ' Registration Created By '.Auth::user()->name; 
            }
            $userprofile->house_details = $request->house_details;  
            $userprofile->street = $request->street;
            $userprofile->landmark = $request->landmark;
            $userprofile->city = $request->city;
            $userprofile->state = $request->state; 
            $userprofile->pincode = $request->pincode;
            $userprofile->how_know_us = $request->how_know_us;
            $userprofile->father_name = $request->father_name; 
            $userprofile->father_occupation = $request->father_occupation;
            $userprofile->fathers_income = $request->fathers_income; 
            $userprofile->fathers_mobile = $request->fathers_mobile; 
            $userprofile->school_name = $request->school_name;
            
            $userprofile->blood_group = $request->blood_group; 
            $userprofile->marital_status = $request->marital_status;
            $userprofile->aadhaar = $request->aadhaar; 
            $userprofile->home_type = $request->home_type;
            
            //saving files
            if($request->file('photo')){

                Storage::delete('/profile_photos/'.$userprofile->photo);

                $filename = 'profile-'.time().".".$request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('/profile_photos/',$filename);
                $userprofile->photo = $filename;
            }/* 
            if($request->is_profile_completed) */
            $userprofile->is_profile_completed = "1";
            $userprofile->created_by = "1";
            
            //if profile saves then move forward
            if($userprofile->save()){

                //first registration
                $registration = new Registration();
                $registration->student_id = $user->id;
                $registration->course_id = $request->course_id;
                $registration->course_slot_id = $request->courseslot_id;
                $registration->status = "1";
            
                $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                
                if($registration->save()){
                    SerialNumberConfigurationsController::incrementRegistrationNumber();
                    //move to second registration if and only if the first registration is saved()
                    if(isset($request->sec_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->sec_course_id;
                        $registration->course_slot_id = $request->sec_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->third_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->third_course_id;
                        $registration->course_slot_id = $request->third_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->fourth_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->fourth_course_id;
                        $registration->course_slot_id = $request->fourth_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->fifth_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->fifth_course_id;
                        $registration->course_slot_id = $request->fifth_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->sixth_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->sixth_course_id;
                        $registration->course_slot_id = $request->sixth_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->seventh_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->seventh_course_id;
                        $registration->course_slot_id = $request->seventh_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->eight_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->eight_course_id;
                        $registration->course_slot_id = $request->eight_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->ninth_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->ninth_course_id;
                        $registration->course_slot_id = $request->ninth_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    if(isset($request->tenth_course_id)){
                        $registration = new Registration();
                        $registration->student_id = $user->id;
                        $registration->course_id = $request->tenth_course_id;
                        $registration->course_slot_id = $request->tenth_courseslot_id;
                        $registration->status = "1";
                    
                        $registration->registration_no = 'RG-'.SerialNumberConfigurationsController::getCurrentRegistrationNumber();
                        
                        if($registration->save()){
                            SerialNumberConfigurationsController::incrementRegistrationNumber();
                        }
                        else{
                            return redirect()->route('user_profile_list')->with('error','0');
                        }
                    }
                    return redirect()->route('user_profile_list')->with('created','0');
                }
                else{
                    return redirect()->route('user_profile_list')->with('error','0');
                }
            }
            else{
                return redirect()->route('user_profile_list')->with('error','0');
            }
        }
        else{
            return redirect()->route('user_profile_list')->with('error','0');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('subadmin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 2,
            'is_verifed' => 1,
            'designation' => $request->designation,
        ]);


        event(new Registered($user));
        if($user){
            return redirect()->route('subadmin_list')->with('created','123');
        }
        else{
            return redirect()->route('subadmin_list')->with('error','123');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('subadmin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);
        return json_encode($user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_verifed = 1;
        $user->designation = $request->designation;
        $user->save();
        return redirect('/subadmin')->with('updated','123');
    }
    function permission($id){
        return view('subadmin::permissions');
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/subadmin')->with('deleted','123');
    }
}
