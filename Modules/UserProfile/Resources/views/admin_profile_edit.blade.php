@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Profile Edit</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/userprofile')}}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile Edit</li>
	@endcomponent
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger dark" role="alert">
                                    <p>{{ $error }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endforeach
                            @endif
                            <form action="{{route('user_profile_edit',$userprofile->id)}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                            <div class="p-5 bg-white border-b border-gray-200">
                                                    @csrf

                                                    <p class="card-description">
                                                        Personal Info
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">First Name <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control" name="firstname"
                                                                    value="{{$userprofile->firstname}}">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Last Name <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control" name="lastname"
                                                                    value="{{$userprofile->lastname}}">

                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Mobile Number <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control" name="mobile"
                                                                    value="{{$userprofile->mobile}}">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Gender <sup class="text-danger">*</sup></label>

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
                                                                <label class="form-label">Date of Birth <sup class="text-danger">*</sup> <sub>(mm-dd-yyyy)</sub></label>
                                                                <input class=" form-control" type="text" data-language="en" name="dob" readonly
                                                                    value="{{$userprofile->dob ? date('m-d-Y',strtotime($userprofile->dob)) : ''}}" 
                                                                    id="date_picker"/>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Age <sup class="text-danger">*</sup></label>
                                                                <input required type="text" readonly class="form-control" name="age" id="age"
                                                                    value="{{$userprofile->age}}">

                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">Aadhaar Number <sup class="text-danger">*</sup></label>
                                                                <input required type="text" class="form-control" name="aadhaar"
                                                                    value="{{$userprofile->aadhaar}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">Blood Group <sup class="text-danger">*</sup></label>
                                                                <input type="text" class="form-control" name="blood_group"
                                                                    value="{{$userprofile->blood_group}}">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">Marital Status <sup class="text-danger">*</sup></label>

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
                                                            <label class="form-label">Update Photo</label>
                                                            <input type="file" name="photo" class="form-control">
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

                                                    <p class="card-description">
                                                        Address 
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="form-label">Home Type <sup class="text-danger">*</sup></label>

                                                                <select class="form-control" name="home_type">
                                                                    <option value="rented" @if ($userprofile->home_type == "rented")
                                                                        selected
                                                                        @endif>Rented</option>
                                                                    <option value="owned" @if ($userprofile->home_type == "owned")
                                                                        selected
                                                                        @endif>Owned</option>
                                                                    <option value="other"  @if ($userprofile->home_type == "other")
                                                                        selected
                                                                        @endif>Other</option>
                                                                </select>

                                                            </div>
                                                        </div>
                        
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="form-label">House Name/Number <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control"
                                                                    name="house_details" value="{{$userprofile->house_details}}">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="form-label">Street/Locality <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control" name="street"
                                                                    value="{{$userprofile->street}}">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">Landmark <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control" name="landmark"
                                                                    value="{{$userprofile->landmark}}">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">Pincode <sup class="text-danger">*</sup></label>

                                                                <input required type="text" class="form-control" name="pincode"
                                                                    value="{{$userprofile->pincode}}">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">State<sup class="text-danger">*</sup></label>
                                                                <select class="form-control " name="state" id="state">
                                                                    <option value="">Choose State</option>
                                                                    @foreach ($states as $state)
                                                                    <option value="{{$state->id}}" @if($state->id == $userprofile->state )selected @endif>{{$state->name}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-label">City <sup class="text-danger">*</sup></label>
                                                                <select class="form-control " name="city" id="cities">
                                                                    @if ($cities == null)
                                                                        <option value="">Not found</option>
                                                                    @else
                                                                        @foreach ($cities as $city)
                                                                        <option value="{{$city->city_id}}" @if($city->city_id == $userprofile->city )selected @endif>
                                                                            {{$city->city_name}}
                                                                        </option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
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

                                                <p class="card-description">
                                                    Education
                                                </p>    
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Last Qualification <sup class="text-danger">*</sup></label>

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
                                                            <label class="form-label">Qualification Specialization <sup class="text-danger">*</sup></label>

                                                            <input required type="text" class="form-control"
                                                                name="qualification_specilization"
                                                                value="{{$userprofile->qualification_specilization}}"
                                                                placeholder="ex: Science/Mechanical/IT">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label class="form-label">School/College Name <sup class="text-danger">*</sup></label>

                                                            <input required type="text" class="form-control" name="school_name"
                                                                value="{{$userprofile->school_name}}">

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Qualification Status <sup class="text-danger">*</sup></label>

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
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Occupation <sup class="text-danger">*</sup></label>

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

                                                <p class="card-description">
                                                    Other Information
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Father's/Gaurdian's Name <sup class="text-danger">*</sup></label>

                                                            <input required type="text" class="form-control" name="father_name"
                                                                value="{{$userprofile->father_name}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Father's/Gaurdian's Mobile <sup class="text-danger">*</sup></label>

                                                            <input required type="text" class="form-control"
                                                                name="fathers_mobile" value="{{$userprofile->fathers_mobile}}">
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Father's/Gaurdian's Annual Income <sup class="text-danger">*</sup></label>

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
                                                            <label class="form-label">Father's/Gaurdian's Occupation <sup class="text-danger">*</sup></label>

                                                            <input required type="text" class="form-control"
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
                                                            <label class="form-label">Any Comments {{-- <sup class="text-danger">*</sup> --}}</label>

                                                            <textarea class="form-control" rows="7" name="comments">{{$userprofile->comments}}</textarea>
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
                                                <button type="submit" class="btn btn-primary me-2">
                                                    Submit</button>
                                                    <a class="btn btn-secondary"
                                                    href="{{url('admin/dashboard')}}">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('jcontent')
<script>
    var date = new Date(); 
    $('#date_picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        /* dateFormat: 'dd-mm-yyyy', */
        autoClose:true,
        onSelect: function(datesel) {
            let that_year = new Date(datesel);
            let date = new Date();
            let val = date.getFullYear() - that_year.getFullYear();
            if(val){
                $("#age").val(val);
            }
            else{
                $("#age").val(0);
            }
        }
    });
    $(document).ready(function (){
        $('#edit_profile').validate({
            errorClass: "text-danger pt-1",
            errorPlacement: function(error, element) {
                if (element.attr("name") == "dob") {
                    error.insertAfter($("#date_picker"));
                }
                else {
                    error.insertAfter(element);
                }          
            },
            rules: {

                    firstname: {
                        required: true,
                    },

                    lastname: {
                        required: true,
                    },

                    mobile: {
                        required: true,
                        digits: true,
                        minlength: 0,
                        maxlength: 10,
                    },

                    gender: {
                        required: true,
                    },

                    dob: {
                        required: true,
                        /* date:true, */
                    },

                    age: {
                        required: true,
                        number: true,
                    },
                    aadhaar: {
                        required: true,
                        digits: true,
                        minlength: 0,
                        maxlength: 12,
                    },
                    /* blood_group: {
                        required: true,
                    }, */
                    marital_status: {
                        required: true,
                    },

                    address: {
                        required: true,
                    },

                    home_type: {
                        required: true,
                    },

                    house_details: {
                        required: true,
                    },

                    street: {
                        required: true,
                    },

                    landmark: {
                        required: true,
                    },

                    pincode: {
                        required: true,
                    },

                    city: {
                        required: true,
                    },

                    state: {
                        required: true,
                    },
                    qualification_id: {
                        required: true,
                    },
                    qualification_specilization: {
                        required: true,
                    },
                    school_name: {
                        required: true,
                    },

                    qualification_status: {
                        required: true,
                    },
                    occupation_id: {
                        required: true,
                    },
                    father_name: {
                        required: true,
                    },

                    fathers_mobile: {
                        required: true,
                        digits: true,
                        minlength: 0,
                        maxlength: 10,
                    },

                    father_occupation: {
                        required: true,
                    },

                    fathers_income: {
                        required: true,
                    },

                    how_know_us: {
                        required: true,
                    },
                },

                messages: {
                    firstname: {
                        required: "Please enter your first name",
                    },

                    lastname: {
                        required: "Please enter your second name",
                    },

                    mobile: {
                        required: "Please enter your mobile number",
                    },

                    gender: {
                        required: "Please select your gender",
                    },

                    dob: {
                        required: "Please select date of birth",
                        /* date:'Please enter correct formatted date' */
                    },

                    age: {
                        required: "Please enter your age",
                        number: 'Age must be a number',

                    },
                    aadhaar: {
                        required: "Please enter your adhaar number",
                    },
                    /* blood_group: {
                        required: "Please enter yor blood group",
                    }, */
                    marital_status: {
                        required: "Please select your marital status",
                    },

                    address: {
                        required: "Please enter your address",
                    },

                    home_type: {
                        required: "Please select home type",
                    },

                    house_details: {
                        required: "Please enter your house details",
                    },

                    street: {
                        required: "Please enter street name",
                    },

                    landmark: {
                        required: "Please enter landmark",
                    },

                    pincode: {
                        required: "Please enter landmark",
                    },

                    city: {
                        required: "Please enter city",
                    },

                    state: {
                        required: "Please enter state",
                    },
                    qualification_id: {
                        required: "Please enter qualification",
                    },
                    qualification_specilization: {
                        required: "Please enter specialization",
                    },
                    school_name: {
                        required: "Please enter school name",
                    },

                    qualification_status: {
                        required: "Please enter qualification status",
                    },
                    occupation_id: {
                        required: "Please enter your occupation",
                    },
                    father_name: {
                        required: "Please enter father's name",
                    },

                    fathers_mobile: {
                        required: "Please enter father's mobile number",
                    },

                    father_occupation: {
                        required: "Please enter father's occupation",
                    },

                    fathers_income: {
                        required: "Please enter father's income",
                    },

                    how_know_us: {
                        required: "Please tell us something",
                    },

                }



        });
    });
    $("#state").on('change',function(){
        let state_id = $("#state").val()
        if(state_id == ""){
            return null;
        }
        console.log(state_id)
        $.ajax({
            type: "get",
            url: `{{url('userprofile/get-city/${state_id}')}}`,
            beforeSend:function(){
                $('#overlay-loader').removeClass('d-none');
                $('#overlay-loader').show();
            },
            success: function (response) {
                console.log(response);
                $("#cities").empty();
                if(response.cities.length > 0){
                    $.each(response.cities, function (index, element) { 
                        $("#cities").append(`
                            <option value="${element.city_id}">${element.city_name}</option>
                        `);
                    });
                }
                else
                {
                    $("#cities").append(`
                            <option value="">Not Found</option>
                    `);
                }
                    $('#overlay-loader').hide(); 
            },
        });
    });
</script>
@endsection