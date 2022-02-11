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
                 
                <form class="f1" action="{{route('profile_update','two')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">        
                    @csrf
				    <div class="f1-steps">
                        <div class="f1-progress">
                            <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 35%"></div>
                        </div>
                        <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                            <p>Personal</p>
                        </div>
                        <div class="f1-step active">
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
                        <p class="card-description text-black-50">
                            Address
                        </p>
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
                                </select>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">House Name/Number <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm"
                                    name="house_details" value="{{$userprofile->house_details}}">
                            </div>

                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">Street/Locality <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm" name="street"
                                    value="{{$userprofile->street}}">
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Landmark <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm" name="landmark"
                                    value="{{$userprofile->landmark}}">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Pincode <sup class="text-danger">*</sup></label>

                                <input required type="text" class="form-control form-control-sm" name="pincode"
                                    value="{{$userprofile->pincode}}">
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">State<sup class="text-danger">*</sup></label>
                                <select class="form-control " name="state" id="state">
                                    <option value="">Choose State</option>
                                    @foreach ($states as $state)
                                        <option value="{{$state->id}}" 
                                            @if($state->id == $userprofile->state ) selected @endif >
                                                {{$state->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">City <sup class="text-danger">*</sup></label>
                                <select class="form-control" name="city" id="cities">
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

                    <div class="f1-buttons">
    					<a href="{{route('profile_update',['one'])}}"><button class="btn btn-secondary btn-previous" type="button">Previous</button></a>
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
               
            },

            messages: {
                
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