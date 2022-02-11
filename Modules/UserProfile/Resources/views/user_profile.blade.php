@extends('layouts.app')
@section('content')
    
<div class="container-fluid">	
    <div class="user-profile">
        <div class="row">
            <div class="col-sm-12">
	                <div class="card profile-header">
	                    <img class="img-fluid bg-img-cover" src="{{asset('public/images/gradient.png')}}" alt="" />{{-- 
	                    <div class="profile-img-wrrap"><img class="img-fluid bg-img-cover" src="{{asset('public/images/bg-image.jpg')}}" alt="" /></div> --}}
	                   <div class="userpro-box">
	                        <div class="img-wrraper">
	                            <div class="avatar">
                                    @if($profile->photo)
                                        <img src="{{asset('storage/app/profile_photos/'.$profile->photo)}}" alt="profile"
                                            class="img-lg">
                                    @else
                                        <img src="{{asset('/storage/app/profile_photos/blankimage.png')}}" alt=""
                                            class="img-lg">
                                    @endif
                                </div>
	                        </div>
	                        <div class="user-designation">
	                            <div class="title">
	                                    <h4 class="txt-primary">{{$profile->firstname}} {{$profile->lastname}}</h4>
	                                    <h6>+91 {{$profile->mobile}}</h6>
	                                    <h6 class="text-lowercase">{{$profile->User->email}}</h6>
                                         @if($profile->status == '2')
                                        <h6 class="text-danger">
                                            Suspended till
                                            <span>
                                                {{date('d M Y',strtotime($profile->suspended_till))}}
                                            </span>
                                        </h6>
                                        @endif
    	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
                <!-- user profile header end-->
	            <div class="col-xl-4 col-lg-4 col-md-4">
	                <div class="default-according style-1 faq-accordion job-accordion">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="p-0">
                                    <button class="btn btn-link ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon2" aria-expanded="true" aria-controls="collapseicon2">About Me</button>
                                </h5>
                            </div>
                            <div class="collapse show" id="collapseicon2" aria-labelledby="collapseicon2" data-parent="#accordion">
                                <div class="card-body post-about">
                                    <ul>
                                        <li>
                                            <div class="icon"><i data-feather="briefcase"></i></div>
                                            <div>
                                                <h5>Employment Status</h5>
                                                <p>{{$profile->Occupation->name}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="book"></i></div>
                                            <div>
                                                <h5>studied {{$profile->Qualification->name}} {{$profile->qualification_specilization}}</h5>
                                                <p>{{$profile->qualification_status}}, {{$profile->school_name}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="heart"></i></div>
                                            <div>
                                                <h5>relationship status</h5>
                                                <p>{{$profile->marital_status}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="heart"></i></div>
                                            <div>
                                                <h5>Age</h5>
                                                <p>{{$profile->age}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="map-pin"></i></div>
                                            <div>
                                                <h5>Lives in 
                                                    @if($state_name !== "")
                                                    {{$city_name}},
                                                    @else
                                                    {{$profile->city}},
                                                    @endif
                                                </h5>
                                                <p>{{$profile->house_details}}, {{$profile->street}},<br>
                                                    {{$profile->landmark}}, {{$profile->pincode}}<br>
                                                    @if($state_name !== "")
                                                    {{$state_name}}
                                                    @else
                                                    {{$profile->state}}
                                                    @endif
                                                    
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                    {{-- <div class="social-network theme-form">
                                        <span class="f-w-600">Social Networks</span>
                                        <button class="btn social-btn btn-fb mb-2 text-center"><i class="fa fa-facebook m-r-5"></i>Facebook</button>
                                        <button class="btn social-btn btn-twitter mb-2 text-center"><i class="fa fa-twitter m-r-5"></i>Twitter</button>
                                        <button class="btn social-btn btn-google text-center"><i class="fa fa-dribbble m-r-5"></i>Dribbble</button>
                                    </div> --}}
                                </div>
                            </div>
	                    </div>
	                </div>
	            </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
	                <div class="default-according style-1 faq-accordion job-accordion">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="p-0">
                                    <button class="btn btn-link ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon3" aria-expanded="true" aria-controls="collapseicon3">Additional Information</button>
                                </h5>
                            </div>
                            <div class="collapse show" id="collapseicon3" aria-labelledby="collapseicon3" data-parent="#accordion">
                                <div class="card-body post-about">
                                    <ul>
                                        <li>
                                            <div class="icon"><i data-feather="briefcase"></i></div>
                                            <div>
                                                <h5>Aadhaar</h5>
                                                <p>{{$profile->aadhaar}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="book"></i></div>
                                            <div>
                                                <h5>Gender</h5>
                                                <p>{{$profile->gender}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="heart"></i></div>
                                            <div>
                                                <h5>Born on</h5>
                                                <p>{{date('d M Y',strtotime($profile->dob))}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="droplet"></i></div>
                                            <div>
                                                <h5>blood group</h5>
                                                <p>{{$profile->blood_group ? $profile->blood_group : 'Not Provided'}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
	                    </div>
	                </div>
	            </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
	                <div class="default-according style-1 faq-accordion job-accordion">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="p-0">
                                    <button class="btn btn-link ps-0" data-bs-toggle="collapse" data-bs-target="#collapseicon4" aria-expanded="true" aria-controls="collapseicon4">About My Family</button>
                                </h5>
                            </div>
                            <div class="collapse show" id="collapseicon4" aria-labelledby="collapseicon4" data-parent="#accordion">
                                <div class="card-body post-about">
                                    <ul>
                                        <li>
                                            <div class="icon"><i data-feather="briefcase"></i></div>
                                            <div>
                                                <h5>Father/Gaurdian</h5>
                                                <p>{{$profile->father_name}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="book"></i></div>
                                            <div>
                                                <h5>Father Occupation</h5>
                                                <p>{{$profile->father_occupation}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="heart"></i></div>
                                            <div>
                                                <h5>Father's Mobile</h5>
                                                <p>{{$profile->fathers_mobile}}</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon"><i data-feather="map-pin"></i></div>
                                            <div>
                                                <h5>Family Income</h5>
                                                <p>{{$profile->fathers_income}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
	                    </div>
	                </div>
	            </div>
        </div>
    </div>
</div>
@endsection  