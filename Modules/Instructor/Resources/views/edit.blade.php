@extends('layouts.admin.app')
@section('content')
    
    <div class="page-header">
        <h3 class="page-title">
            Instructor Edit
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Instructor Edit</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('instructor_update',$instructor->id)}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-5 bg-white border-b border-gray-200">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">First Name <sup class="text-danger">*</sup></label>

                                                <input required type="text" class="form-control form-control-sm" name="firstname"
                                                value="{{$instructor->firstname}}"
                                                >

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Last Name <sup class="text-danger">*</sup></label>

                                                <input required type="text" class="form-control form-control-sm" name="lastname"
                                                value="{{$instructor->lastname}}"
                                                >

                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Mobile Number <sup class="text-danger">*</sup></label>

                                                <input required type="text" class="form-control form-control-sm" name="mobile"
                                                value="{{$instructor->phone}}"
                                                >

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Email <sup class="text-danger">*</sup></label>

                                                        <input required type="email" class="form-control form-control-sm" name="email"
                                                        value="{{$instructor->email}}"
                                                        >

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Designation <sup class="text-danger">*</sup></label>

                                                        <input required type="text" value="{{$instructor->designation}}" class="form-control form-control-sm" name="designation"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Photo <sub class="text-danger">(Dont upload if dont want to change)</sub></label>
                                                        <input type="file" name="photo" class="form-control-file">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Course<sup class="text-danger">*</sup></label>
                                                        <select class="form-control " name="course" id="course_id">
                                                            <option value="">Choose Course</option>
                                                            @foreach ($courses as $course)
                                                            <option value="{{$course->id}}" {{$course->id == $instructor->course_id ? 'selected' : '' }}>{{$course->name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Address<sup class="text-danger">*</sup></label>

                                                <textarea required type="text" rows="10"
                                                class="form-control form-control-sm" name="address">{{$instructor->address}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button><a class="btn btn-light"
                                    href="{{url('/instructor')}}">Cancel</a>
                            
                            </div>
                        </div>
            </form>
        </div>
    </div>
@endsection
    @section('jcontent')
    <script>
        var date = new Date();

        $('#datepicker-popup').datepicker({
            autoclose: true,
            todayHighlight: true,
            maxDate: "+0y +0m +0w +0d",
        }).on('changeDate', function(e) {
                let that_year = new Date(e.date);
                let val =  date.getFullYear() - that_year.getFullYear();
                $("#age").val(val);
        });
         $(document).ready(function (){
        $('#edit_profile').validate({
            errorClass: "text-danger pt-1",
            errorPlacement: function(error, element) {
                if (element.attr("name") == "dob") {
                    error.insertAfter($("#datepicker-popup"));
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

                    email: {
                        required: true,
                    },

                    designation: {
                        required: true,
                        /* date:true, */
                    },

                    /* photo: {
                        required: true,
                        number: true,
                    }, */

                    address: {
                        required: true,
                    },
                    course: {
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

                    email: {
                        required: "Please add Email",
                    },

                    designation: {
                        required: "Please add designation",
                        /* date:'Please enter correct formatted date' */
                    },

                    /* photo: {
                        required: "Please chooose photo",
                    }, */

                    address: {
                        required: "Please enter your address",
                    },
                    course: {
                        required: "Please select a course",
                    },

                }



        });
    });
   
    </script>
    @endsection