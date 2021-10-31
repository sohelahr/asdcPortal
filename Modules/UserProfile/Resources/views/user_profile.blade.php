<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="content-wrapper">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="border-bottom text-center pb-4">
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('storage/app/profile_photos/'.$profile->photo)}}" alt="profile" class="img-lg rounded-circle mb-3">
                        </div>
                        <p>{{$profile->Occupation->name}}</p>
                        <div class="d-flex justify-content-between">
                          <button class="badge badge-info badge-pill"><i class="fas fa-birthday-cake"></i> {{date('d M Y',strtotime($profile->dob))}}</button>
                          <button class="badge badge-danger badge-pill"><i class="fas fa-burn"></i> {{$profile->blood_group}}</button>
                        </div>
                      </div>
                      <div class="border-bottom py-4">
                        <p class="clearfix">
                          <span class="float-left">
                            Aadhaar
                          </span>
                          <span class="float-right text-muted">
                            {{$profile->aadhaar}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Marital Status
                          </span>
                          <span class="float-right text-muted">
                            {{$profile->marital_status}}
                          </span>
                        </p>
                      </div>
                      <div class="py-4">
                        <p class="clearfix">
                          <span class="float-left">
                            Status
                          </span>
                          <span class="float-right text-muted">
                            @if($profile->status == '2')
                              Suspended
                            @elseif($profile->status == '1')
                             Employed
                            @else  
                              Active
                            @endif
                          </span>
                        </p>
                        @if($profile->status == '2')
                          <p class="clearfix">
                            <span class="float-left">
                              Suspended Till
                            </span>
                            <span class="float-right text-muted">
                                {{date('d M Y',strtotime($profile->suspended_till))}}
                            </span>
                          </p>
                        @endif
                        <p class="clearfix">
                          <span class="float-left">
                            Phone
                          </span>
                          <span class="float-right text-muted">
                            {{$profile->mobile}}
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Email
                          </span>
                          <span class="float-right text-muted">
                            {{$profile->User->email}}
                          </span>
                        </p>
                        {{-- <p class="clearfix">
                          <span class="float-left">
                            Facebook
                          </span>
                          <span class="float-right text-muted">
                            <a href="#">David Grey</a>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Twitter
                          </span>
                          <span class="float-right text-muted">
                            <a href="#">@davidgrey</a>
                          </span>
                        </p>
                      </div> 
                      <button class="btn btn-primary btn-block">Preview</button> --}}
                    </div>
                  </div>
                    <div class="col-lg-8 pl-lg-5">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h3>{{$profile->firstname}} {{$profile->lastname}}</h3>
                          <div class="d-flex align-items-center">
                            <h5 class="mb-0 mr-2 text-muted text-capitalize">{{$profile->gender}} ({{$profile->age}})</h5>
                        </div>
                        <div class="profile-feed">
                            <div class="d-flex align-items-start profile-feed-item">
                            <img src="{{url('/public/images/state_icon.png')}}" alt="profile"  height="50" width="50" class="rounded-circle">
                            <div class="ml-4">
                                <h5>
                                Address
                                </h5>
                                <h6 class=" text-muted mt-2 mb-0" style="width: 100vh">
                                    {{$profile->house_details}}, {{$profile->street}}, {{$profile->landmark}}, <br>{{$profile->city}},
                                    {{$profile->state}}, {{$profile->pincode}}
                                </h6>
                            </div>
                            </div>
                            
                            <div class="d-flex align-items-start profile-feed-item">
                                <img src="{{url('/public/images/export_icon.png')}}" alt="profile"  height="50" width="50" class="rounded-circle">
                                <div class="ml-4">
                                  <h5>Education</h5>
                                  <div>
                                    <label class="badge badge-outline-dark">{{$profile->Qualification->name}}</label>
                                    <label class="badge badge-outline-dark">{{$profile->qualification_specilization}}</label>
                                    <label class="badge badge-outline-dark">{{$profile->school_name}}</label>
                                    <label class="badge badge-outline-dark">{{$profile->qualification_status}}</label>
                                  </div>                                                               
                                </div>
                            </div>
                            <div class="d-flex align-items-start profile-feed-item">
                              
                            <img src="{{url('/public/images/father-icon.png')}}" alt="profile" height="50" width="50" class="rounded-circle">
                            <div class="ml-3 col-7">
                                <h5>
                                Family
                                </h5>
                                <p class="clearfix">
                                  <span class="float-left">
                                    Father/Gaurdian 
                                  </span>
                                  <span class="float-right text-muted">
                                    {{$profile->father_name}}
                                  </span>
                                </p>
                                <p class="clearfix">
                                  <span class="float-left">
                                    Occupation
                                  </span>
                                  <span class="float-right text-muted">
                                    {{$profile->father_occupation}}
                                  </span>
                                </p>
                                <p class="clearfix">
                                  <span class="float-left">
                                    Mobile
                                  </span>
                                  <span class="float-right text-muted">
                                    {{$profile->fathers_mobile}}
                                  </span>
                                </p>
                                
                                <p class="clearfix">
                                  <span class="float-left">
                                    Income
                                  </span>
                                  <span class="float-right text-muted">
                                    {{$profile->fathers_income}}
                                  </span>
                                </p>  
                            </div>
                            </div>
                            {{-- <div class="d-flex align-items-start profile-feed-item">
                            <img src="../../images/faces/face19.jpg" alt="profile" class="img-sm rounded-circle">
                            <div class="ml-4">
                                <p>
                                Dylan Silva
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                                </h6>
                                <p>
                                When I first got into the online advertising business, I was looking for the magical combination 
                                that would put my website into the top search engine rankings
                                </p>
                                <img src="../../images/samples/1280x768/5.jpg" alt="sample" class="rounded mw-100">                                                        
                                <p class="small text-muted mt-2 mb-0">
                                <span>
                                    <i class="fa fa-star mr-1"></i>4
                                </span>
                                <span class="ml-2">
                                    <i class="fa fa-comment mr-1"></i>11
                                </span>
                                <span class="ml-2">
                                    <i class="fa fa-mail-reply"></i>
                                </span>
                                </p>
                            </div>
                            </div> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
</x-app-layout>