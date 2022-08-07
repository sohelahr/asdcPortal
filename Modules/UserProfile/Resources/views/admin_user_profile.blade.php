@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Profiles</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/userprofile')}}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
	@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-xl-6 xl-100">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                                Home
                                <div class="media"></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                                Registrations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                                Attendance
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="mb-0 m-t-30">
                                <div class="card-body">
                                    @if($profile->created_by == 3)
                                    <div class="alert alert-warning dark alert-dismissible fade show" role="alert">
                                        <strong> User was Imported.</strong> Please confirm all the details of this user and edit them if needed
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @if($profile->dob === "1970/01/01")
                                        <div class="alert alert-danger" role="alert">
                                            This User's <strong> Date of birth was incorrect </strong> has been replaced by default system value : 1970 . 
                                            Please change this first 
                                        </div>
                                    @endif
                                        <div class="user-profile">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card profile-header py-3" style="height: auto">
                                                        <img class="img-fluid bg-img-cover" src="{{asset('public/images/gradient.png')}}" alt="" />{{-- 
                                                        <div class="profile-img-wrrap"><img class="img-fluid bg-img-cover" src="{{asset('public/images/bg-image.jpg')}}" alt="" /></div> --}}
                                                        @if(\App\Http\Helpers\CheckPermission::hasPermission('update.profiles'))
                                                            <div >
                                                                <a href="{{url('userprofile/admin/'.$profile->id.'/edit/')}}" class="btn btn-outline-light text-white float-end">
                                                                    {{-- <i class='fa fa-pencil'></i> --}}
                                                                    Edit
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="userpro-box p-3 my-0">
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
                                                                        <h6 class="text-capitalize">
                                                                            Status :
                                                                            @if($profile->status == '2')
                                                                                Suspended 
                                                                                <span>
                                                                                    {{date('d M Y',strtotime($profile->suspended_till))}}
                                                                                </span>
                                                                            @elseif($profile->status == '1')
                                                                                Employed
                                                                            @else
                                                                                Active
                                                                            @endif
                                                                        </h6>
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
                                                                                    @endif<br>
                                                                                </p>
                                                                            </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="icon"><i data-feather="map-pin"></i></div>
                                                                            <div>
                                                                                <h5>Home type</h5>
                                                                                <p>{{$profile->home_type}}</p>
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
                                                                        <li>
                                                                            <div class="icon"><i data-feather="search"></i></div>
                                                                            <div>
                                                                                <h5>How did they Find Us</h5>
                                                                                <p>{{$profile->how_know_us}}</p>
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
                                                                        <li>
                                                                            <div class="icon"><i data-feather="message-circle"></i></div>
                                                                            <div>
                                                                                <h5>Comments</h5>
                                                                                <p>
                                                                                    {{$profile->comments ? $profile->comments : '-'}}
                                                                                </p>
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="mb-0 m-t-30">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display datatables" id="userregistration">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th>Registration Number</th>
                                                    <th>Course Name</th>
                                                    <th>Course Timing</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="mb-0 m-t-30">
                                <div class="card-body">
                                    @if(count($admissions))
                                        <div class="form-group">
                                            <label for="attendance-records">Select Admission</label>
                                            <select id="attendance-records" class="form-control" name="admission">
                                                
                                                @foreach ($admissions as $admission)
                                                    <option value="{{$admission->id}}">{{$admission->roll_no}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="display datatables" id="attendance_table">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Absent</th>
                                                        <th>Present</th>
                                                        <th>Total days</th>
                                                        <th>Attendance</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <h3>No Admissions Found</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="remarksmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancetile" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancetile">Remark</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h4 id="remark"></h4>                        
                        </div>     
                    </div>
                </div>
            </div>
@endsection
@section('jcontent')
<script>
    @if(count($admissions) > 0)
        getAttendanceRecords("{{$admissions[0]->id}}")
    @endif
    $(document).ready(function () {
        $('#userregistration').DataTable({
            processing: true,
            serverSide: true,
            
            ajax: "{{route('profile_registrations',$profile->id)}}",
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            },
            {
                className: 'text-center',
                'targets':[4,5]
            }],
            columns: [
                {
                    data: 'registration_no',
                    name: 'registration_no',
                },
                {
                    data: 'course_name',
                    name: "course_name"
                },
                {
                    data: 'course_slot',
                    name: "course_slot"
                },
                {
                    data: 'date',
                    name: "date"
                },
                {
                    data: 'status',
                    render: function (type, data, row) {
                        if (row.status == "1")
                            return "<label class='txt-primary'>Applied</label>"
                        else if (row.status == "2")
                            return "<label class='txt-success'>Admitted</label>"
                        else if (row.status == "3")
                            return "<label class='txt-warning'>Cancelled</label>"
                    },
                    name: 'status'
                },
                {
                    data: 'action',
                    render: function (type, data, row) {
                        if (row.status == "1")
                            return `<label class='txt-success'><a href='{{url('admission/create/${row.id}')}}'>Admit</a><label>`;
                            //return "<label class='badge badge-warning badge-pill status_btns'>Applied</label>"
                        else if (row.status == "2")
                            return `<a class='txt-success' href='{{url('admission/viewfromreg/${row.id}')}}'>View</a>`;
                        else
                            return ;
                    },
                    name: 'action'
                },
            ]
        });

        $('#attendance-records').on('change', function () {
            getAttendanceRecords(this.val());
        });
    });
    function getAttendanceRecords(admission_id){
        $('#attendance_table').DataTable({
            processing: true,
            serverSide: true,
            searching:false,
            "pageLength": 50,
            ajax: {
                "url":`{{url("attendance/get-admissionwise-attendance/".'${admission_id}')}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            /* "columnDefs": [
                {"className": "text-center", "targets": [1,2]}
            ], */
            columns: [
                {
                    data: 'month',
                    name: "month",
                },
                {
                    data: 'absent',
                    name: 'absent'
                },
                {
                    data: 'present',
                    name: 'present'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'attendance',
                    name: 'attendance'
                },
                {
                    data: 'remarks',
                    render:function(data,type,row){
                        return `<span style='cursor:pointer' data-src='' onclick='showRemarks(${JSON.stringify(data)})''>${data.substring(0,5)}...</span>`
                    },
                    name: 'remarks'
                },
            ]
        });
    }
    function showRemarks(remark){
        $('#remark').text(remark);
        $('#remarksmodal').modal('show');
    }
</script>
@endsection
