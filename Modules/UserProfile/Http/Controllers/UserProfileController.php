<?php

namespace Modules\UserProfile\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Occupation\Entities\Occupation;
use Modules\Qualification\Entities\Qualification;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('userprofile::index');
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
    public function show($id)
    {
        return view('userprofile::show');
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
        $userprofile->employment_status = "0";
        
        
        //saving files
        if($request->file('photo')){
            $filename = $request->file('photo')->getClientOriginalName().time().".".$request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('/profile_photos/',$filename);
            $userprofile->photo = $filename;
        }
        if($request->is_profile_completed)
            $userprofile->is_profile_completed = "1";
        $userprofile->save();
        return redirect('/dashboard');
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
