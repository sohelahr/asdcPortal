@extends('layouts.admin.app')
@section('content')
    
    <div class="page-header">
        <h3 class="page-title">
            Profile Edit
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile Edit</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{route('user_profile_edit',$userprofile->id)}}" method="POST" enctype="multipart/form-data">        
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-5 bg-white border-b border-gray-200">
                                    @csrf

                                    <p class="card-description text-black-50">
                                        Personal Info
                                    </p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">First Name</label>

                                                <input required type="text" class="form-control form-control-sm" name="firstname"
                                                    value="{{$userprofile->firstname}}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Last Name</label>

                                                <input required type="text" class="form-control form-control-sm" name="lastname"
                                                    value="{{$userprofile->lastname}}">

                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Mobile Number</label>

                                                <input required type="text" class="form-control form-control-sm" name="mobile"
                                                    value="{{$userprofile->mobile}}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Gender</label>

                                                <select class="form-control" name="gender">
                                                    <option value="male" @if ($userprofile->gender == "male")
                                                        selected
                                                        @endif>Male</option>
                                                    <option value="female" @if ($userprofile->gender == "female")
                                                        selected
                                                        @endif>Female</option>
                                                </select>

                                            </div>
                                        </div>
                                    
                                    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Date of Birth</label>

                                                <div id="datepicker-popup" class="input-group date datepicker p-0 m-0">
                                                    <input required type="text" class="form-control form-control-sm" name="dob"
                                                        value="{{$userprofile->dob}}">
                                                    <span class="input-group-addon input-group-append border-left">
                                                        <i class="far fa-calendar input-group-text py-1 px-2"></i>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Age</label>

                                                <input required type="text" class="form-control form-control-sm" name="age"
                                                    value="{{$userprofile->age}}">

                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Aadhaar Number</label>
                                                <input required type="text" class="form-control form-control-sm" name="aadhaar"
                                                    value="{{$userprofile->aadhaar}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Blood Group</label>
                                                <input required type="text" class="form-control form-control-sm" name="blood_group"
                                                    value="{{$userprofile->blood_group}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Marital Status</label>

                                                <select class="form-control" name="marital_status">
                                                    <option value="single" @if ($userprofile->marital_status == "single")
                                                        selected
                                                        @endif>Single</option>
                                                    <option value="married" @if ($userprofile->marital_status == "married")
                                                        selected
                                                        @endif>Married</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Photo <sub> (leave blank if dont want to change)</sub></label>
                                            <input type="file" name="photo" class="form-control-file">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="pt-3">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-5 bg-white border-b border-gray-200">

                                    <p class="card-description text-black-50">
                                        Address
                                    </p>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Home Type</label>

                                                <select class="form-control" name="home_type">
                                                    <option value="rented" @if ($userprofile->home_type == "rented")
                                                        selected
                                                        @endif>Rented</option>
                                                    <option value="owned" @if ($userprofile->home_type == "owned")
                                                        selected
                                                        @endif>Owned</option>
                                                </select>

                                            </div>
                                        </div>
        
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">House Name/Number</label>

                                                <input required type="text" class="form-control form-control-sm"
                                                    name="house_details" value="{{$userprofile->house_details}}">
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="form-label">Street/Locality</label>

                                                <input required type="text" class="form-control form-control-sm" name="street"
                                                    value="{{$userprofile->street}}">
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Landmark</label>

                                                <input required type="text" class="form-control form-control-sm" name="landmark"
                                                    value="{{$userprofile->landmark}}">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">Pincode</label>

                                                <input required type="text" class="form-control form-control-sm" name="pincode"
                                                    value="{{$userprofile->pincode}}">
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">City</label>

                                                <input required type="text" class="form-control form-control-sm" name="city"
                                                    value="{{$userprofile->city}}">
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">State</label>
                                                {{-- 
                                            <select class="form-control form-control-sm">
                                            <option>America</option>
                                            <option>Italy</option>
                                            <option>Russia</option>
                                            <option>Britain</option>
                                            </select> --}}
                                                <input required type="text" class="form-control form-control-sm" name="state"
                                                    value="{{$userprofile->state}}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <div class="pt-3">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-5 bg-white border-b border-gray-200">

                                <p class="card-description text-black-50">
                                    Education
                                </p>    
                                <div class="row">
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Last Qualification</label>

                                            <select class="form-control " name="qualification_id">
                                                @foreach ($qualifications as $qualification)
                                                <option value="{{$qualification->id}}" @if($qualification->id ==$userprofile->qualification_id) selected @endif>{{$qualification->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Qualification Specialization</label>

                                            <input required type="text" class="form-control form-control-sm"
                                                name="qualification_specilization"
                                                value="{{$userprofile->qualification_specilization}}"
                                                placeholder="ex: Science/Mechanical/IT">

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="form-label">School/College Name</label>

                                            <input required type="text" class="form-control form-control-sm" name="school_name"
                                                value="{{$userprofile->school_name}}">

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label">Qualification Status</label>

                                            <select class="form-control " name="qualification_status">
                                                <option value="Passed" @if($userprofile->qualification_status == "Passed")
                                                    selected @endif>Passed</option>
                                                <option value="Pursuing" @if($userprofile->qualification_status == "Pursuing")
                                                    selected @endif>Pursuing</option>
                                                <option value="Completed" @if($userprofile->qualification_status == "Completed")
                                                    selected @endif>Completed</option>
                                                <option value="Left Incomplete" @if($userprofile->qualification_status == "Left Incomplete") selected @endif>Left Incomplete</option>
                                                
                                                <option value="Failed" @if($userprofile->qualification_status == "Failed") selected @endif>Failed</option>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="form-label">Occupation</label>

                                            <select class="form-control" name="occupation_id">
                                                @foreach ($occupations as $occupation)
                                                <option value="{{$occupation->id}}" @if($occupation->id == $userprofile->occupation_id) selected @endif>{{$occupation->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-3 pb-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-5 bg-white border-b border-gray-200">

                                <p class="card-description text-black-50">
                                    Other Information
                                </p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Father's/Gaurdian's Name</label>

                                            <input required type="text" class="form-control form-control-sm" name="father_name"
                                                value="{{$userprofile->father_name}}">
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Father's/Gaurdian's Mobile</label>

                                            <input required type="text" class="form-control form-control-sm"
                                                name="fathers_mobile" value="{{$userprofile->fathers_mobile}}">
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Father's/Gaurdian's Annual Income</label>

                                            <select class="form-control " name="fathers_income">
                                                <option value="0 to 1 lac" @if($userprofile->fathers_income == "0 to 1 lac")
                                                    selected @endif>0 to 1 lac</option>
                                                <option value="1 to 2 lacs" @if($userprofile->fathers_income == "1 to 2 lacs")
                                                    selected @endif>1 to 2 lacs</option>
                                                <option value="2 to 3 lacs" @if($userprofile->fathers_income == "2 to 3 lacs")
                                                    selected @endif>2 to 3 lacs</option>
                                                <option value="3 to 4 lacs" @if($userprofile->fathers_income == "3 to 4 lacs") selected @endif>3 to 4 lacs</option>
                                                
                                                <option value=">= 4 lacs" @if($userprofile->fathers_income == ">= 4 lacs") selected @endif>>= 4 lacs</option>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Father's/Gaurdian's Occupation</label>

                                            <input required type="text" class="form-control form-control-sm"
                                                name="father_occupation" value="{{$userprofile->father_occupation}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">How You Got To Know About Us</label>

                                            
                                            <select class="form-control " name="how_know_us">
                                                <option value="Social Media" @if($userprofile->how_know_us == "Social Media")
                                                    selected @endif>Social Media</option>
                                                <option value="Newspaper" @if($userprofile->how_know_us == "Newspaper")
                                                    selected @endif>Newspaper</option>
                                                <option value="From a Friend" @if($userprofile->how_know_us == "From a Friend")
                                                    selected @endif>From a Friend</option>
                                                <option value="From a relative" @if($userprofile->how_know_us == "From a relative") selected @endif>From a relative</option>
                                                
                                                <option value="Other" @if($userprofile->how_know_us == "Other") selected @endif>Other</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Any Comments</label>

                                            <textarea class="form-control" rows="7" name="comments">
                                                {{$userprofile->comments}}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check form-check-primary">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input mt-2" name="is_profile_completed" value="1">
                                                I agree that all the information filled above is correct and won't be changed for atleast one year.Leave blank if not yet sure
                                            <i class="input-helper"></i>
                                        </label>
                                        </div>
                                    </div>
                                </div> --}}
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button><a class="btn btn-light"
                                    href="{{url('admin/dashboard')}}">Cancel</a>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
    @section('jcontent')
    <script>
        $('#datepicker-popup').datepicker({
            format: 'yy/mm/dd',
            autoclose: true,
            todayHighlight: true
        });

    </script>
    @endsection