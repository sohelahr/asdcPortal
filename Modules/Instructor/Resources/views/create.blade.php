@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Instructors</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/instructor')}}">Instructors</a></li>
            <li class="breadcrumb-item active" aria-current="page">Instructor Create</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
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
                        <form action="{{route('create_instructor')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">First Name <sup class="text-danger">*</sup></label>

                                            <input required type="text" class="form-control" name="firstname"
                                            >

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Last Name <sup class="text-danger">*</sup></label>

                                            <input required type="text" class="form-control" name="lastname"
                                            >

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Mobile Number <sup class="text-danger">*</sup></label>

                                            <input required type="text" class="form-control" name="mobile"
                                            >

                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email <sup class="text-danger">*</sup></label>

                                                    <input required type="email" class="form-control" name="email"
                                                    >

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label">Designation <sup class="text-danger">*</sup></label>

                                                    <input required type="text" class="form-control" name="designation"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label">Photo <sup class="text-danger"> *</sup></label>
                                                    <input type="file" name="photo" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label">Course<sup class="text-danger">*</sup></label>
                                                    <select class="form-control " name="course" id="course_id">
                                                        <option value="">Choose Course</option>
                                                        @foreach ($courses as $course)
                                                        <option value="{{$course->id}}">{{$course->name}}
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
                                            class="form-control" name="address"></textarea>
                                        </div>
                                    </div>
                                </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-secondary"
                                href="{{url('/instructor')}}">Cancel</a>
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

                    photo: {
                        required: true,
                    },

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

                    photo: {
                        required: "Please chooose photo",
                    },

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