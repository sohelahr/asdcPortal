<?php

namespace Modules\UserProfile\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Occupation\Entities\Occupation;
use Modules\Qualification\Entities\Qualification;
use Modules\UserProfile\Entities\UserProfile;
use Yajra\Datatables\Datatables;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //     $userprofiles = UserProfile::where('is_profile_completed',"1")->get();
        return view('userprofile::admin_profile_list'/*, compact('userprofiles') */);
    }

    function UserProfileData(){
        $userprofiles = UserProfile::where('is_profile_completed',"1")->get();
        return Datatables::of($userprofiles)
                ->addIndexColumn()
                ->addColumn('name',function($profile){
                    if(\App\Http\Helpers\CheckPermission::hasPermission('view.profiles')){
                        return ['perm'=>true,'name'=> $profile->firstname." ".$profile->lastname];
                    }
                    else{
                       return ["perm"=>false,'name' => $profile->firstname." ".$profile->lastname];
                    }
                })
                ->addColumn('qualification',function($profile){
                    return $profile->Qualification->name;
                })
                ->addColumn('type',function($profile){
                    if($profile->User->Registrations->count() > 0)
                        return "True";
                    else
                        return "FALSE";
                })
                ->addColumn('edit',function($registration){
                    return \App\Http\Helpers\CheckPermission::hasPermission('update.profiles');
                })
                ->make();
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('userprofile::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {

        $profile = Auth::user()->UserProfile;
            if($profile->is_profile_completed)
                return view('userprofile::user_profile',compact('profile'));
        return redirect('/dashboard')->with('profile_not_complete','not complete');
        
    }
    public function Adminshow($id)
    {
        $profile = UserProfile::find($id);
        return view('userprofile::admin_user_profile',compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit()
    {
        $userprofile =  Auth::User()->UserProfile;
        $occupations = Occupation::all();
        $qualifications = Qualification::all();
        if($userprofile->is_profile_completed && Auth::user()->user_type == "3"){
            return redirect('/dashboard')->with('profile_complete','user profile already completed');
        }
        return view('userprofile::edit',compact('userprofile','occupations','qualifications'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'max:10', 'unique:user_profiles'],
            'aadhaar' => ['required', 'unique:user_profiles'],            
        ]);

        $userprofile =  Auth::User()->UserProfile;
        $userprofile->firstname = $request->firstname;
        $userprofile->lastname = $request->lastname;
        $userprofile->dob = $request->dob;
        $userprofile->age = $request->age;
        $userprofile->mobile = $request->mobile; 
        $userprofile->occupation_id = $request->occupation_id; 
        $userprofile->qualification_id = $request->qualification_id;
        $userprofile->qualification_specilization = $request->qualification_specilization;
        $userprofile->qualification_status = $request->qualification_status;
        $userprofile->gender = $request->gender;
        $userprofile->comments = $request->comments; 
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
        
        $userprofile->after_course_employment_status = "0";
        
        
        //saving files
        if($request->file('photo')){
            $filename = 'profile-'.time().".".$request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('/profile_photos/',$filename);
            $userprofile->photo = $filename;
        }/* 
        if($request->is_profile_completed) */
        $userprofile->is_profile_completed = "1";
        $userprofile->save();
        return redirect('/dashboard')->with('profile_updated','xyz');
    }

    public function AdminEdit(Request $request,$id){
        $userprofile = UserProfile::find($id);
        $occupations = Occupation::all();
        $qualifications = Qualification::all();
        if($request->method() == "GET"){

            return view('userprofile::admin_profile_edit',compact('userprofile','occupations','qualifications'));
        }

        else{

            $userprofile->firstname = $request->firstname;
            $userprofile->lastname = $request->lastname;
            $userprofile->dob = $request->dob;
            $userprofile->age = $request->age;
            $userprofile->mobile = $request->mobile; 
            $userprofile->occupation_id = $request->occupation_id; 
            $userprofile->qualification_id = $request->qualification_id;
            $userprofile->qualification_specilization = $request->qualification_specilization;
            $userprofile->qualification_status = $request->qualification_status;
            $userprofile->gender = $request->gender;
            $userprofile->comments = $request->comments; 
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
            
            $userprofile->after_course_employment_status = "0";
            
            
            //saving files
            if($request->file('photo')){

                Storage::delete('/profile_photos/'.$userprofile->photo);

                $filename = 'profile-'.time().".".$request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('/profile_photos/',$filename);
                $userprofile->photo = $filename;
            }/* 
            if($request->is_profile_completed) */
            $userprofile->is_profile_completed = "1";
            $userprofile->save();

            return redirect()->route('user_profile_list')->with('updated','0');
        }
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
