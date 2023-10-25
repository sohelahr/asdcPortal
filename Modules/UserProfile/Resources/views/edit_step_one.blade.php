@extends('layouts.app')
@section('content')
    <div class="container-fluid">
		<div class="row">
		  <div class="col-sm-12">
			<div class="card">
			  <div class="card-header pb-0">
				<h5>Complete Profile</h5>
			  </div>
			  <div class="card-body">
                 
                <form class="f1" action="{{route('profile_update','one')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                    @csrf
				    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" style="width: 12%" data-number-of-steps="4"></div>
                        </div>
                        <div class="f1-step active">
                            <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                            <p>Personal</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                            <p>Address</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-graduation-cap"></i></div>
                            <p>Education</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-twitter"></i></div>
                            <p>Family</p>
                        </div>
    				</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">First Name</label>

                                <input required type="text" class="form-control"
                                    value="{{$userprofile->firstname}}" disabled>

                                <input required type="hidden" name="firstname" value="{{$userprofile->firstname}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Last Name </label>

                                <input required type="text" class="form-control"
                                    value="{{$userprofile->lastname}}" disabled>

                                <input required type="hidden" class="form-control" name="lastname"
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
                                <label class="form-label">Date of Birth <sup class="text-danger">*</sup><sub>(mm-dd-yyyy)</sub></label>
                                <input class=" form-control" type="text" data-language="en" name="dob" readonly
                                    id="date_picker" value="{{$userprofile->dob ? date('m-d-Y',strtotime($userprofile->dob)) : ''}}" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Age <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control" name="age"
                                    value="{{$userprofile->age}}" id="age" readonly>

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
                                <label class="form-label">Blood Group {{-- <sup class="text-danger">*</sup> --}}</label>
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
                                @if($userprofile->photo == null)
                                    <label class="form-label">Photo</label>
                                    <input type="file" name="photo" class="form-control" >
                                    <sub>Please upload a <= 500kb passport size photo</sub>
                                @else
                                    <label class="form-label">Change Photo</label>
                                    <input type="file" name="update_photo" class="form-control" >
                                    <sub>Please upload a <= 500kb passport size photo</sub>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="f1-buttons">
    					<a href="{{url('/dashboard')}}"><button class="btn btn-secondary btn-previous" type="button">Close</button></a>
                        <button class="btn btn-primary btn-next" type="submit">Save & Next</button>
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

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than 500kb');

        $('#edit_profile').validate({
            errorClass: "text-danger pt-1 fst-normal",
            errorPlacement: function (error, element) {
                if (element.attr("name") == "dob") {
                    error.insertAfter($("#date_picker"));
                } else {
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
                    maxlength: 10
                },

                gender: {
                    required: true,
                },

                dob: {
                    required: true,
                },
                aadhaar: {
                    required: true,
                    digits: true,
                    minlength: 0,
                    maxlength: 12
                },
                marital_status: {
                    required: true,
                },
                photo: {
                    required: true,
                    filesize:500000,
                    extension: "jpg,jpeg,png",
                },
                update_photo:{
                    required:false,
                    extension: "jpg,jpeg,png",
                    filesize:500000
                }
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
                },
                aadhaar: {
                    required: "Please enter your adhaar number",
                },
                
                marital_status: {
                    required: "Please select your marital status",
                },
                photo: {
                    required: "Please choose a file",
                },
            }
        });
 </script>   
@endsection