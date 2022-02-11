@extends('layouts.app')
@section('content')
    
    <div id="overlay-loader">
        <div style="height: 100%;width:100%;position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
            <div> 
                <div class="loader-box">
                    <div class="loader-7"></div>
                </div>              
            </div>
        </div>
    </div>

    <div id="complete_profile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-danger" id="my-modal-title">Notice : </h3>
                </div>
                <div class="modal-body">
                    <h5>To enroll in a course, please complete your profile.</h5>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('logout') }}" class="px-2">
                        @csrf
                        <input type="submit" value="Logout" class="btn btn-secondary">
                    </form>
                    <a class="btn btn-primary" href="{{route('profile_update',['one'])}}">Complete Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div id="profile_suspended" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-danger" id="my-modal-title">Notice : </h3>
                </div>
                <div class="modal-body">
                    <h5>Your Profile has been suspended</h5>
                    <p>You wont be able to enroll in any of the courses till
                        {{date('d M Y',strtotime($profile->suspended_till))}}
                    </p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('logout') }}" class="px-2">
                        @csrf
                        <input type="submit" value="Logout" class="btn btn-info">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row justify-content-between">
                <div class="col-6">
                    <h3>My Courses</h3>
                </div>
                <div class="col-6 align-items-right">
                    <div class="float-end">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#enroll-modal">
                           Enroll 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="crm-activity" id="registrations">
                                
                            </ul>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">               
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    
                    <div class="pt-5 mt-6">
                        <div class="row justif-content-center">
                            <div class="col-10">
                               
                            </div>
                            <div class="col-12 mt-6">
                                <h4 class="card-title">Feedbacks</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="feedback_header_table">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Batch</th>
                                                <th>Instructor</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Your Response</th>
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
    </div> --}}
    <div class="modal fade" id="enroll-modal" tabindex="-1" data-backdrop="static" 
        data-keyboard="false" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="admissions-by-batches-loader" class="d-none">
                    <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                        <div> 
                            <div class="loader-box">
                                <div class="loader-7"></div>
                            </div>              
                        </div>    
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Course Enrollment</h5>
                </div>
                <form method="POST" id="enrollment_form" action="{{route('user_registration_create')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Course <sup class="text-danger">*</sup></label>
                                    <select class="form-control" name="course_id" id="registration_course">
                                        <option value="">Choose A Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}">{{$course->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Course Duration</label>
                                    <input required type="text" class="form-control form-control-sm" id="course_duration"
                                        value="" disabled>
                                </div>
                            </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Course Timing <sup class="text-danger">*</sup></label>
                                        <select class="form-control" name="courseslot_id" id="course_slot">
                                            <option value="">Choose Course Timing</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" onclick="closeModal()">Close</a>    
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection    
@section('jcontent')
    <script>
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        @if(! $profile->is_profile_completed)
            var myModal = new bootstrap.Modal($("#complete_profile")[0],{
                backdrop: 'static',
                keyboard: false,
            });
            myModal.show()
        @endif
    
        var enroll_modal = new bootstrap.Modal($("#enroll-modal")[0]);
        
        @if($profile->status == "2")
            var myModal = new bootstrap.Modal($("#profile_suspended")[0],{
                backdrop: 'static',
                keyboard: false,
            });
            myModal.show()
        @endif
        
        function Notify(title,msg,status){
             $.notify({
                    title:title,
                    message:msg
                },
                {
                    type:status,
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
            });
        }
        @if(\Illuminate\Support\Facades\Session::has('profile_complete')) 
                Notify('Profile Complete','Please Contact admin to make changes to your profile','danger')   
            @elseif(\Illuminate\Support\Facades\Session::has('profile_not_complete'))
                Notify('Danger','First Update Your Profile','danger')   
            @elseif(\Illuminate\Support\Facades\Session::has('profile_updated'))
                Notify('success','Profile was successfully updated','success')   
            @elseif(\Illuminate\Support\Facades\Session::has('registered'))
                Notify('Registered','You have successfully registered For a course','success')   
                
            @elseif(\Illuminate\Support\Facades\Session::has('already_registered'))
                Notify('Warning','You have already registered for two courses please visit the center before applying for more','warning')   

             @elseif(\Illuminate\Support\Facades\Session::has('unauthorized'))
                Notify('Unauthorized','Aha! being sneeky af','danger')   
            @elseif(\Illuminate\Support\Facades\Session::has('feedback_created'))
                Notify('Success','Feedback was successfully recorded','success')   

            @elseif(\Illuminate\Support\Facades\Session::has('error'))
                Notify('Danger','Something went wrong ','danger')   
            @endif
        function deleteRegistration(reg_id){
            swal({
                    title: "Withdraw Application",
                    text: "Are you sure?",
                    icon: "warning",
                    buttons: ['Cancel','Yes'],
                    dangerMode: true,
                }).then((withdraw) => {
                        if (withdraw) {
                            $.ajax({
                                type: "post",
                                url: `{{url('registration/withdraw/${reg_id}')}}`,
                                data: "data",
                                dataType: "dataType",
                                beforeSend:function(){
                                    $('#overlay-loader').removeClass('d-none');
                                    $('#overlay-loader').show();
                                },
                                statusCode: {
                                    200: function (response) {
                                            getRegistration();
                                            swal("You have successfully withdrawn your application", {
                                                icon: "success",
                                            });
                                            $('#overlay-loader').hide();
                                        },
                                    401: function () {
                                        swal("Something went wrong", {
                                                icon: "warning",
                                            });
                                        $('#overlay-loader').hide();    
                                      }
                                }
                            });
                        }
                    });
        }

        function getRegistration() {
            $.ajax({
                type: "get",
                url: `{{route('user_registrations')}}`,
                beforeSend: function () {
                    $('#overlay-loader').removeClass('d-none');
                },
                success: function (response) {
                    $("#registrations").empty();
                    response = JSON.parse(response);
                    if(response.status == true){
                        console.log(response);
                        $.each(response.data, function (index, element) { 
                            $('#registrations').append(`
                                    <li class="media">
                                        <span class="me-3 overflow-hidden">
                                            <div class='initials text-capitalize'>
                                                <span>${element.course_slug}</span>
                                            </div>
                                        </span>
                                        <div class="align-self-center media-body">
                                            <div class="d-flex flex-row align-items-center justify-content-between">
                                                <div>
                                                    <h6 class="mt-0">
                                                       ${element.course_name} 
                                                    </h6>
                                                </div>
                                                ${element.status == "1" ? ( 
                                                    `<div class="" onclick='deleteRegistration(${element.id})' role="button">
                                                        <span style="font-size:20px" class="text-danger">
                                                            <i class="icofont icofont-ui-delete" ></i>
                                                        </span>
                                                    </div>`)
                                                : ''}             
                                            </div>
                                            <ul class="dates">
                                                <li>
                                                    <span class="text-dark">Status:</span> 
                                                    <span class="text-${element.status == "1" ? 'warning' : (element.status == "2" ? 'success' : 'danger' )}">
                                                        ${element.status == "1" ? 'Applied' : (element.status == "2" ? 'Admitted' : 'Cancelled' )}
                                                    </span>
                                                </li>
                                            </ul>
                                            <ul class="dates">
                                                <li><span class="text-dark">Timing:</span> ${element.course_slot}</li>                                            
                                            </ul>
                                            <ul class="dates">
                                                <li><span class="text-dark">Reg No.:</span>
                                                        ${element.registration_no} </li>
                                            </ul>
                                        </div>                
                                    </li>
                            `);
                        });
                    }
                    else
                    {
                        /* $("#course_slot").append(`
                                <option value="">Not Found</option>
                        `); */
                        $('#registrations').append(`
                            <h3>Start by enrolling in a course...</h3>
                        `);
                    }
                            $('#overlay-loader').hide();
                },
            });
            
        }
        
        
        $(document).ready(function () {
            getRegistration();

            //for enrolling 
             $('#enrollment_form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    course_id: {
                        required: true,
                    },
                    courseslot_id: {
                        required: true,
                    },  
                },
                messages: {
                    course_id: {
                        required: "Course is required",
                    },
                    courseslot_id: {
                        required: "Please select a timing",
                    },  
                },
                submitHandler: function (form, event) { 
                    event.preventDefault();
                    $.ajax({
                        url: form.action,
	                    type: form.method,
                        data: $(form).serialize(),
                        beforeSend: function () {
                            $('#overlay-loader').removeClass('d-none');
                            $('#overlay-loader').show();
                            closeModal();
                        },
                        success: function (response) {
                            if(response.status == "success"){
                                Notify('Success', response.msg ,'success')
                            }
                            else{
                                swal({
                                    title: 'Warning',
                                    text: response.msg,
                                    icon: 'warning',
                                });
                            }
                            getRegistration();
                            $('#overlay-loader').hide();
                        },
                    });
                },
            });
        }); 

        //for closing enroll modal
        function closeModal(){
            enroll_modal.hide()
        }
        
        //for getting timings
        $("#registration_course").on('change',function(){
            let course_id = $("#registration_course").val()
            $.ajax({
                type: "get",
                url: `{{url('registration/getforminputs/${course_id}')}}`,
                beforeSend: function (){
                    $('#admissions-by-batches-loader').removeClass('d-none');
                },
                success: function (response) {
                    $("#course_slot").empty();
                    $("#course_duration").val(response.course_duration);;
                    if(response.course_slots.length > 0){
                        $.each(response.course_slots, function (index, element) { 
                            $("#course_slot").append(`
                                <option value="${element.id}">${element.name}</option>
                            `);
                        });
                    }
                    else
                    {
                        $("#course_slot").append(`
                                <option value="">Not Found</option>
                        `);
                    }
                },
                complete: function(){
                    $('#admissions-by-batches-loader').addClass('d-none');
                }
            });
        });

        //Feedbacks assigned via sort wise
        
        /* $('#feedback_header_table').DataTable({
            processing: true,
            serverSide: true,
            searching:false,
            ordering:false,
            "pageLength": 30,
            "bDestroy": true,
            
            ajax: {
                "url":`{{url("feedback/get-all-feedback-headers-per-admission/")}}`,
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columnDefs": [
                {"class": "text-center", "targets": '_all'}
            ],
            columns: [
                {
                    data:'course',
                    name:'course'
                },
                {
                    data:'coursebatch',
                    name:'coursebatch'
                },
                {
                    data:'instructor',
                    name:'instructor'
                },
                {
                    data:'start_date',
                    name:'start_date'
                },
                {
                    data:'end_date',
                    name:'end_date'
                },
                {
                    data:'header_status',
                    render:function(data,type,row){
                        if(data == '1'){
                            return "<span>Active</span>"
                        }
                        else if(data == '2'){
                            return "<span>Expired</span>"
                        }
                        else{
                            return "<span>Initialized</span>"
                        }
                    },
                    name:'header_status'
                },
                {
                    data:'filled_status',
                    render:function(data,type,row){
                        if(data == 0){
                            if(row.header_status == '2'){
                                return "<span class='text-danger'>Not Submitted</span>"
                            }
                            return '<a href="feedback/lines/create/'+btoa(row.id)+'"><span class="text-warning">Pending</span></a>';
                        }
                        else{
                            return "<span class='text-success'>Submitted</span>"
                        }
                    },
                    name:'filled_status'
                },
            ]
        }); */
    

    </script>
@endsection