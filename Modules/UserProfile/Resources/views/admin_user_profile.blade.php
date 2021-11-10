@extends('layouts.admin.app')
@section('content')
    
    <div class="">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4 col-md-4">
                      <div class="border-bottom text-center pb-4">
                        <img src="{{asset('storage/app/profile_photos/'.$profile->photo)}}" alt="profile" class="img-lg rounded-circle mb-3">
                        <p>{{$profile->Occupation->name}}</p>
                        <div class="d-flex justify-content-between">
                          <button class="badge badge-info badge-pill"><i class="fas fa-birthday-cake"></i> {{date('d M Y',strtotime($profile->dob))}}</button>
                          <button class="badge badge-danger badge-pill"><i class="fas fa-burn"></i> {{$profile->blood_group}}</button>
                        </div>
                      </div>
                      <div class="border-bottom py-4">
                        <p>Education</p>
                        <div>    
                          <label class="badge badge-outline-dark">{{$profile->Qualification->name}}</label>
                          <label class="badge badge-outline-dark">{{$profile->qualification_specilization}}</label>
                          <label class="badge badge-outline-dark">{{$profile->school_name}}</label>
                          <label class="badge badge-outline-dark">{{$profile->qualification_status}}</label>
                        </div>                                                               
                      </div>
                      <div class="border-bottom pt-4 pb-2">
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
                      <div class=" border-bottom py-4 mb-1">
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
                    </div>
                    <div class="border-bottom py-2">
                      <p class="clearfix">
                          <span class="float-left">
                            How did they Find Us
                          </span>
                          <span class="float-right text-muted">
                            {{$profile->how_know_us}}
                          </span>
                      </p>
                      <p class="clearfix">
                          <span class="float-left">
                            Comments:
                          </span>
                      <p>
                        <p class="text-muted">{{$profile->comments}}</p>
                    </div>
                  </div>
                    <div class="col-lg-8 col-md-8 pl-lg-5">
                      <div class=" justify-content-between">
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
                                <p class=" text-muted mt-2 mb-0">
                                    {{$profile->house_details}}, {{$profile->street}}, {{$profile->landmark}}, <br>{{$profile->city}},
                                    {{$profile->state}}, {{$profile->pincode}}
                                </p>
                                <p>House Type:- {{$profile->home_type}}</p>
                            </div>
                            </div>
                            <div class="d-flex align-items-start profile-feed-item">
                              <img src="{{url('/public/images/father-icon.png')}}" alt="profile" height="50" width="50" class="rounded-circle">
                              <div class="ml-3 col-7">
                                  <h5>
                                  Family
                                  </h5><p class="clearfix">
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
                            </div>
                            <div class="profile-feed-item">
                              <div>
                                <h5>User Registrations</h5>
                                <div class="row ">
                                  <div >
                                  <table class="table table-responsive" id="userregistration">
                                      <thead>
                                          <tr>
                                              <th>Course Name</th>
                                              <th>Course Timing</th>
                                              <th>Date</th>
                                              <th>Status</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                  </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection
@section('jcontent')
<script>
    
    $(document).ready( function () {
    $('#userregistration').DataTable({
        processing: true,
        serverSide: true,
       
        ajax: "{{route('profile_registrations',$profile->id)}}",
        columns:[
            {data: 'course_name',name:"course_name"},
            {data: 'course_slot',name:"course_slot"},
            {data: 'date',name:"date"},
            {data:'status',render:function(type,data,row){
                if(row.status == "1")
                    return "<label class='badge badge-warning badge-pill status_btns'>Applied</label>"
                else if(row.status == "2")
                    return "<label class='badge badge-success badge-pill status_btns'>Admitted</label>"
                else if(row.status == "3")
                    return "<label class='badge badge-danger badge-pill status_btns'>Cancelled</label>"
                },
            name:'status'
            },
        ]
    });
} );
</script>
@endsection