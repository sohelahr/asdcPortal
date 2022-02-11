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
                 
                <form class="f1" action="{{route('profile_update','three')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                    @csrf
				    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 60.33%"></div>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                            <p>Personal</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                            <p>Address</p>
                        </div>
                        <div class="f1-step active">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Last Qualification <sup class="text-danger">*</sup></label>

                                <select class="form-control " name="qualification_id">
                                    <option value="">Choose Qualification</option>
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

                                <input required type="text" class="form-control form-control-sm"
                                    name="qualification_specilization"
                                    value="{{$userprofile->qualification_specilization}}"
                                    placeholder="ex: Science/Mechanical/IT">

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">School/College Name <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm" name="school_name"
                                    value="{{$userprofile->school_name}}">

                            </div>
                        </div>
                        
                        <div class="col-md-2">
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">Occupation <sup class="text-danger">*</sup></label>

                                <select class="form-control" name="occupation_id">
                                    <option value="">Choose Occupation</option>
                                    @foreach ($occupations as $occupation)
                                    <option value="{{$occupation->id}}" @if($occupation->id == $userprofile->occupation_id) selected @endif>{{$occupation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="f1-buttons">
    					<a href="{{route('profile_update',['two'])}}"><button class="btn btn-secondary btn-previous" type="button">Previous</button></a>
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
            },

            messages: {
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

            }
    });
    $("#state").on('change', function () {
        let state_id = $("#state").val()
        if (state_id == "") {
            return null;
        } 
        console.log(state_id)
        $.ajax({
            type: "get",
            url: `{{url('userprofile/get-city/${state_id}')}}`,
            beforeSend: function () {
                $('#overlay-loader').removeClass('d-none');
                $('#overlay-loader').show();
            },
            success: function (response) {
                console.log(response);
                $("#cities").empty();
                if (response.cities.length > 0) {
                    $.each(response.cities, function (index, element) {
                        $("#cities").append(`
                                <option value="${element.city_id}">${element.city_name}</option>
                            `);
                    });
                } else {
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