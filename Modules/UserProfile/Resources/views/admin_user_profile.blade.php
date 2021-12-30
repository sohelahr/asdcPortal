@extends('layouts.admin.app')
@section('content')
<div class="page-header">
    <h3 class="page-title">
        Profiles
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>
</div>
    <div class="card">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home-1" role="tab"
                    aria-controls="home-1" aria-selected="true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile-1" role="tab"
                    aria-controls="profile-1" aria-selected="false">Registrations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact-1" role="tab"
                    aria-controls="contact-1" aria-selected="false">Attendance</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="home-1" role="tabpanel" aria-labelledby="home-tab">
                <div class="">
                    <div class="row">
                        <div class="col-12">    
                                <div class="card-body">
                                    @if($profile->created_by == 3)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong> User was Imported.</strong> Please confirm all the details of this user and edit them if needed 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if($profile->dob === "1970/01/01")
                                        <div class="alert alert-danger" role="alert">
                                            This User's <strong> Date of birth was incorrect </strong> has been replaced by default system value : 1970 . 
                                            Please change this first 
                                        </div>
                                    @endif
                                    @if(\App\Http\Helpers\CheckPermission::hasPermission('update.profiles'))
                                    <div class="float-right" style="margin-top: -10px">
                                        <a href="{{url('userprofile/admin/'.$profile->id.'/edit/')}}" class="text-dark">
                                            <i class='fas fa-pencil-alt'></i>
                                        </a>
                                    </div>
                                    @endif
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <div class="border-bottom text-center pb-4">
                                                @if($profile->photo)
                                                    <img src="{{asset('storage/app/profile_photos/'.$profile->photo)}}" alt="profile"
                                                            class="img-lg rounded-circle mb-3">
                                                @else
                                                    <img src = "{{asset('/storage/app/profile_photos/blankimage.png')}}" alt = "" class="img-lg rounded-circle mb-3">
                                                @endif
                                                    
                                                    <p>{{$profile->Occupation->name}}</p>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="badge badge-info badge-pill"><i class="fas fa-birthday-cake"></i>
                                                            {{date('d M Y',strtotime($profile->dob))}}</button>
                                                        <button class="badge badge-danger badge-pill"><i class="fas fa-burn"></i>
                                                            {{$profile->blood_group}}</button>
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
                                                            <h5 class="mb-0 mr-2 text-muted text-capitalize">{{$profile->gender}}
                                                                ({{$profile->age}})</h5>
                                                        </div>
                                                        <div class="profile-feed">
                                                            <div class="d-flex align-items-start profile-feed-item">
                                                                <img src="{{url('/public/images/state_icon.png')}}" alt="profile"
                                                                    height="50" width="50" class="rounded-circle">
                                                                <div class="ml-4">
                                                                    <h5>
                                                                        Address
                                                                    </h5>
                                                                    <p class=" text-muted mt-2 mb-0">
                                                                        {{$profile->house_details}}, {{$profile->street}},
                                                                        {{$profile->landmark}}, <br>
                                                                        @if($state_name !== "")
                                                                            {{$city_name}},
                                                                            {{$state_name}},
                                                                        @else
                                                                            {{$profile->city}},
                                                                            {{$profile->state}},
                                                                        @endif 
                                                                        {{$profile->pincode}}
                                                                    </p>
                                                                    <p>House Type:- {{$profile->home_type}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-start profile-feed-item">
                                                                <img src="{{url('/public/images/father-icon.png')}}" alt="profile"
                                                                    height="50" width="50" class="rounded-circle">
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
            <div class="tab-pane fade" id="profile-1" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card-body">
                        <div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="userregistration">
                                    <thead>
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
            <div class="tab-pane fade" id="contact-1" role="tabpanel" aria-labelledby="contact-tab">
                <div class="card-body">
                    <div>
                        @if(isset($admissions))
                            <div class="form-group">
                                <label for="attendance-records">Select Admission</label>
                                <select id="attendance-records" class="form-control" name="admission">
                                    
                                    @foreach ($admissions as $admission)
                                        <option value="{{$admission->id}}">{{$admission->roll_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="attendance_table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Punch Records</th>
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
                            return "<label class='badge badge-warning badge-pill status_btns'>Applied</label>"
                        else if (row.status == "2")
                            return "<label class='badge badge-success badge-pill status_btns'>Admitted</label>"
                        else if (row.status == "3")
                            return "<label class='badge badge-danger badge-pill status_btns'>Cancelled</label>"
                    },
                    name: 'status'
                },
                {
                    data: 'action',
                    render: function (type, data, row) {
                        if (row.status == "1")
                            return `<a class='badge badge-success badge-pill status_btns' href='{{url('admission/create/${row.id}')}}'>Admit</a>`;
                            //return "<label class='badge badge-warning badge-pill status_btns'>Applied</label>"
                        else if (row.status == "2")
                            return `<a class='badge badge-success badge-pill status_btns' href='{{url('admission/viewfromreg/${row.id}')}}'>View</a>`;
                        else
                            return " ";
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
            "pageLength": 30,
            ajax: {
                "url":`{{url("attendance/get-admissionwise-attendance/".'${admission_id}')}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [
                {"className": "text-center", "targets": [1,2]}
            ],
            columns: [{
                    data: 'date',
                    name: "date",
                    sortable:true,
                },
                {
                    data: 'status',
                    render: function (type, data, row) {
                        if (row.status == "0")
                            return "<label class='text-danger'>Absent</label>"
                        else if (row.status == "1")
                            return "<label class='text-warning'>No punch out</label>"
                        else if (row.status == "2")
                            return "<label class='text-success'>Present</label>"
                        else if (row.status == "3")
                            return "<label class='text-info'>Week Off</label>"
                        else if (row.status == "4")
                            return "<label class='text-primary'>Holiday</label>"
                    },
                    name: 'status'
                },
                {
                    data: 'punch_records',
                    name: 'punch_records'
                },
            ]
        });
    }
</script>
@endsection
