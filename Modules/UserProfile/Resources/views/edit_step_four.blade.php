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
                 
                <form class="f1" action="{{route('profile_update','four')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                    @csrf
				    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 84.33%"></div>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                            <p>Personal</p>
                        </div>
                        <div class="f1-step ">
                            <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                            <p>Address</p>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-graduation-cap"></i></div>
                            <p>Education</p>
                        </div>
                        <div class="f1-step active">
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
                                <label class="form-label">Father's/Gaurdian's Name <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm" name="father_name"
                                    value="{{$userprofile->father_name}}">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Father's/Gaurdian's Mobile <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm"
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

                                <input required type="text" class="form-control form-control-sm"
                                    name="father_occupation" value="{{$userprofile->father_occupation}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">How You Got To Know About Us <sup class="text-danger">*</sup></label>

                                
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

                    <div class="f1-buttons">
    					<a href="{{route('profile_update',['three'])}}"><button class="btn btn-secondary btn-previous" type="button">Previous</button></a>
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
                father_name: {
                    required: true,
                },

                fathers_mobile: {
                    required: true,
                    digits: true,
                    minlength: 0,
                    maxlength: 10
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
 </script>   
@endsection