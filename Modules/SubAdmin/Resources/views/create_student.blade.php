@extends('layouts.admin.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        Create Students
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Students</li>
        </ol>
    </nav>
</div>
<div class="card">
    {{-- <div class="d-flex p-1 m-0 border header-buttons">
            <div>
                <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
                    <i class="fa fa-edit btn-icon-prepend"></i>
                    Edit
                </button>
            </div>
        </div> --}}
    <div id="overlay-loader" class="d-none">
        <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
            <div> 
                <div class="dot-opacity-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>                
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger mt-1">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card-body">
        <form action="{{route('subadmin_student_create')}}" method="POST" enctype="multipart/form-data"
            id="subadmin_student_create">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-5 bg-white border-b border-gray-200">
                        @csrf
                        <p class="card-description text-black-50">
                            Account Info
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">First Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control form-control-sm" id="firstname"
                                        name="first_name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Last Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control form-control-sm" id="lastname"
                                        name="last_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email<sup class="text-danger">*</sup></label>
                                    <input type="email" class="form-control form-control-sm" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control form-control-sm" readonly id="password"
                                        name="password">{{-- 
                                    <div id="pwd_visibility" class="hide">
                                        <i class="far fa-eye"></i>
                                    </div> --}}
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Confirm Password <sup class="text-danger">*</sup></label>
                                    <input id="password_confirmation" class="form-control form-control-sm"
                                        type="password" name="password_confirmation" required />
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-5 bg-white border-b border-gray-200">

                            <p class="card-description text-black-50">
                                Personal Info
                            </p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Mobile Number <sup class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control form-control-sm" name="mobile">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Gender <sup class="text-danger">*</sup></label>

                                        <select class="form-control" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>

                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Date of Birth
                                            {{-- <sup class="text-danger">*</sup> --}}</label>

                                        <div id="datepicker-popup" class="input-group date datepicker p-0 m-0">
                                            <input type="text" readonly class="form-control form-control-sm" name="dob">
                                            <span class="input-group-addon input-group-append border-left">
                                                <i class="far fa-calendar input-group-text py-1 px-2"></i>
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Age <sup class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm" name="age">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Aadhaar Number <sup
                                                class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control form-control-sm" name="aadhaar">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Marital Status <sup
                                                class="text-danger">*</sup></label>

                                        <select class="form-control" name="marital_status">
                                            <option value="single">Single</option>
                                            <option value="married">Married</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Photo </label>
                                        <input type="file" name="photo" class="form-control-file">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Blood Group <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-sm" name="blood_group">
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
                                Address
                            </p>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Home Type <sup class="text-danger">*</sup></label>

                                        <select class="form-control" name="home_type">
                                            <option value="rented">Rented</option>
                                            <option value="owned">Owned</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form-label">House Name/Number <sup
                                                class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control form-control-sm"
                                            name="house_details">
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form-label">Street/Locality <sup
                                                class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control form-control-sm" name="street">
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Landmark <sup class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm"
                                            name="landmark">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Pincode <sup class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm" name="pincode">
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">City <sup class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm" name="city">
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">State <sup class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control form-control-sm" name="state">
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
                                        <label class="form-label">Last Qualification <sup
                                                class="text-danger">*</sup></label>

                                        <select class="form-control " name="qualification_id">
                                            @foreach ($qualifications as $qualification)
                                            <option value="{{$qualification->id}}">{{$qualification->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Qualification Specialization <sup
                                                class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm"
                                            name="qualification_specilization" placeholder="ex: Science/Mechanical/IT">

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form-label">School/College Name <sup
                                                class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm"
                                            name="school_name">

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Qualification Status <sup
                                                class="text-danger">*</sup></label>

                                        <select class="form-control " name="qualification_status">
                                            <option value="Passed">Passed</option>
                                            <option value="Pursuing">Pursuing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Left Incomplete">Left Incomplete</option>

                                            <option value="Failed">Failed</option>

                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form-label">Occupation <sup class="text-danger">*</sup></label>

                                        <select class="form-control" name="occupation_id">
                                            @foreach ($occupations as $occupation)
                                            <option value="{{$occupation->id}}">{{$occupation->name}}</option>
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
                                        <label class="form-label">Father's/Gaurdian's Name <sup
                                                class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm"
                                            name="father_name">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Father's/Gaurdian's Mobile <sup
                                                class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm"
                                            name="fathers_mobile">
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Father's/Gaurdian's Annual Income <sup
                                                class="text-danger">*</sup></label>

                                        <select class="form-control " name="fathers_income">
                                            <option value="0 to 1 lac">0 to 1 lac</option>
                                            <option value="1 to 2 lacs">1 to 2 lacs</option>
                                            <option value="2 to 3 lacs">2 to 3 lacs</option>
                                            <option value="3 to 4 lacs">3 to 4 lacs</option>

                                            <option value=">= 4 lacs">>= 4 lacs</option>

                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Father's/Gaurdian's Occupation <sup
                                                class="text-danger">*</sup></label>

                                        <input required type="text" class="form-control form-control-sm"
                                            name="father_occupation">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">How You Got To Know About Us</label>


                                        <select class="form-control " name="how_know_us">
                                            <option value="Social Media">Social Media</option>
                                            <option value="Newspaper">Newspaper</option>
                                            <option value="From a Friend">From a Friend</option>
                                            <option value="From a relative">From a relative</option>

                                            <option value="Other">Other</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Any Comments
                                            {{-- <sup class="text-danger">*</sup> --}}</label>

                                        <textarea class="form-control" rows="7" name="comments"></textarea>
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
                                Enroll in a course (You can later admit him/her via the admission tab.)
                            </p>
                            <div class="row justify-content-start">
                                <div class="form-row col-5">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Course <sup class="text-danger">*</sup></label>
                                            <select class="form-control" name="course_id" id="registration_course">
                                                <option value="">Choose A Course</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{$course->id}}">{{$course->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Course Duration</label>
                                            <input required type="text" class="form-control form-control-sm" id="course_duration"
                                                value="" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Course Timing <sup class="text-danger">*</sup></label>
                                            <select class="form-control" name="courseslot_id" id="course_slot">
                                                <option value="">Choose Course Timing</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button><a class="btn btn-light"
                                href="{{url('admin/dashboard')}}">Cancel</a>
                            </div>
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
        autoclose: true,
        todayHighlight: true,
        maxDate: "+0y +0m +0w +0d",
    });
    var date = new Date();
    $(document).ready(function () {
        $('#subadmin_student_create').validate({
            errorClass: "text-danger pt-1",
            errorPlacement: function (error, element) {
                if (element.attr("name") == "dob") {
                    error.insertAfter($("#datepicker-popup"));
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                first_name: {
                    required: true,
                },

                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },

                password: {
                    required: true,
                },

                password_confirmation: {
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
                course_id: {
                    required: true,
                },
                courseslot_id: {
                    required: true,
                },  
            },

            messages: {
                first_name: {
                    required: "Please enter your name",
                },
                last_name: {
                    required: "Please enter your name",
                },

                email: {
                    required: "Please enter your email id",
                },

                password: {
                    required: "Please enter a password",
                },

                password_confirmation: {
                    required: "Please re-enter your password",
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
                 course_id: {
                    required: "Course is required",
                },
                courseslot_id: {
                    required: "Please select a timing",
                }, 
            }

        });
    });
    $("#firstname").on('input',function(){
        let name = $("#firstname").val();
        $("#password").val(name+"@asdc"+date.getFullYear())
    })
    $("#registration_course").on('change',function(){
        let course_id = $("#registration_course").val()
        if(course_id == ""){
            return null;
        }
        $.ajax({
            type: "get",
            url: `{{url('registration/getforminputs/${course_id}')}}`,
            beforeSend:function(){
                $('#overlay-loader').removeClass('d-none');
                $('#overlay-loader').show();
            },
            success: function (response) {
                $("#course_slot").empty();
                $("#course_duration").val(response.course_duration);;
                if(response.course_slots.length > 0){
                    $.each(response.course_slots, function (index, element) { 
                        $("#course_slot").append(`
                            <option value="${element.id}">${element.name}</option>
                        `);
                    });
                }
                else
                {
                    $("#course_slot").append(`
                            <option value="">Not Found</option>
                    `);
                }
                    $('#overlay-loader').hide(); 
            },
        });
    });
</script>

@endsection
