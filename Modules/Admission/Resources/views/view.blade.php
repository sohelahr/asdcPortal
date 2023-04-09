@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>View Admission</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/admission')}}">Admissions</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Admission</li>
	@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="admissions-by-batches-loader" class="d-none">
                    <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                        <div> 
                            <div class="loader-box">
                                <div class="loader-7"></div>
                            </div>              
                        </div>   
                    </div>
                </div>
                <div class="d-flex p-1 m-0 border header-buttons">
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('update.admissions'))
                        @if($admission->status == '1')
                        <div>  
                            <a href="{{url('admission/edit/'.$admission->id)}}">
                                <button class="btn bg-white px-3" type="button">
                                <i class="fa fa-edit btn-icon-prepend"></i>
                                    Edit
                                </button>
                            </a>
                        </div>
                        @endif
                    @endif
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('delete.admissions'))
                    <div>
                        @if ($admission->status == '4')
                            <button class="btn bg-white px-3 " type="button" 
                                onclick="changeStatusConfirm('Do you Really Want to ReAdmit? ','readmit');"
                            >
                            <i class="fa fa-refresh btn-icon-prepend"></i>
                                Readmit
                            </button>
                        @else                    
                            <button class="btn bg-white px-3 " type="button" @if($admission->status != '1') 
                                onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                                @else
                                    onclick="changeStatusConfirm('Do you Really Want to Cancel the Admission','cancel');"
                                @endif>
                                <i class="fa fa-times-circle btn-icon-prepend"></i>
                                Cancel
                            </button>
                        @endif

                    </div>
                    @endif
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('create.student_employment'))
                        <div>
                            <button class="btn bg-white px-3" type="button" 
                                @if($admission->status > 2)
                                    onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                                @else
                                    data-bs-toggle="modal" data-bs-target="#employed-modal"
                                @endif>
                                <i class="fa fa-industry btn-icon-prepend"></i>
                                Mark Employed
                            </button>
                        </div>
                    @endif
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('delete.admissions'))
                    <div>
                        <button class="btn bg-white px-3" type="button" @if($admission->status != '1') 
                            onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                            @else
                                onclick="changeStatusConfirm('Do you Really Want to Terminate the Admission','terminate');"
                            @endif>
                            <i class="fa fa-ban btn-icon-prepend"></i>
                            Terminate
                        </button>
                    </div>
                    @endif
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('delete.admissions'))
                    <div>
                        <button class="btn bg-white px-3" type="button" @if($admission->status != '1') 
                            onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                            @else
                                data-bs-toggle="modal" data-bs-target="#attendance-modal"
                            @endif>
                            <i class="fa fa-list btn-icon-prepend"></i>
                            Mark Attendance
                        </button>
                    </div>
                    @endif
                    <div>
                        <a href="{{route('print_admission_form',$admission->id)}}" target="_blank">
                            <button class="btn bg-white px-3">
                                <i class="fa fa-print btn-icon-prepend"></i>
                                Print
                            </button>
                        </a>    
                    </div>
                    {{-- @if(\App\Http\Helpers\CheckPermission::hasPermission('delete.admissions')) --}}
                    <div>
                        <a type="button" target="_blank" href="{{url('admission/id-card/'.$admission->id)}}">
                            <button class="btn bg-white px-3" type="button" >
                                    <i class="fa fa-id-card" style="font-size: 0.9rem;"></i> 
                                    Get ID-Card                         
                            </button>
                        </a>        
                    </div>
                    <div>
                        <a type="button"  href="{{route('user_profile_admin_from_other',$admission->student_id)}}">
                            <button class="btn bg-white px-3" type="button" >
                                    <i class="fa fa-user" style="font-size: 0.9rem;"></i> 
                                    View Profile                        
                            </button>
                        </a>        
                    </div>
                    @if($admission->status == '1') 
                        <div>
                            <button class="btn bg-white px-3" type="button" @if ($grade == "") onclick="OpenGradesModal()" @else onclick="goToCertificate({{$admission->id}})" @endif>
                                @if ($grade == "") 
                                    <i class="fa fa-graduation-cap btn-icon-prepend"></i>
                                    Grade Student 
                                @else 
                                    <i class="fa fa-certificate btn-icon-prepend"></i>
                                    Generate Certificate 
                                @endif
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Student Name</label>
                                    <input required type="text" class="form-control " name="firstname"
                                        value="{{$admission->Student->name}}" disabled> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Roll No</label>
                                    <input class="form-control " name="roll_no" type="text" disabled value="{{$admission->roll_no}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Admission Form Number</label>
                                    <input class="form-control " type="text" disabled name="admission_form_number" value="{{$admission->admission_form_number}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Course</label>
                                    <input type="text" class=" form-control" disabled value="{{$admission->Course->name}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Course Timing</label>
                                    <input type="text" class=" form-control" disabled value="{{$admission->CourseSlot->name}}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Course Batch</label>
                                    <input type="text" class=" form-control" disabled value="{{$admission->CourseBatch->batch_number}}">
                                </div>
                            </div>
                    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Admission Remarks</label>
                                    <textarea class="form-control" rows="4" name="admission_remarks" disabled>{{$admission->admission_remarks}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Admission Status</label>
                                        <input type="text" class=" form-control" disabled 
                                        @switch($admission->status)
                                            @case('1')
                                                value="Admitted"
                                                @break
                                            @case('2')
                                                value="Training Completed"
                                                @break
                                            
                                            @case('3')
                                                value="Employed"
                                                @break
                                            
                                            @case('4')
                                                value="Cancelled"
                                                @break
                                            
                                            @case('5')
                                                value="Terminated"
                                                @break    
                                        @endswitch
                                        >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Admitted By</label>
                                        <input type="text" class=" form-control" disabled value="{{$admission->AdmittedBy->name}}" >
                                    </div>
                                </div>
                                @if ($grade != "")
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Grade</label>
                                        <input type="text" class=" form-control" disabled value="{{$grade}}" >
                                    </div>
                                </div>
                                @endif
                                
                                @if ($admission->status == '4' ||$admission->status == '5')
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">{{$admission->status == '4' ? 'Cancellation' : 'Termination'}} Reason</label>
                                        <textarea class="form-control" rows="4" disabled>{{$admission->cancellation_reason}}</textarea>
                                    </div>
                                </div>
                                @endif
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Documents Submitted</label>
                                    <div class="row ms-1">
                                        @foreach ($documents as $document)
                                            <div class="col-md-3 col-lg-3 col-12 p-0">
                                                <div class="form-group m-checkbox-inline mb-0">
                                                    <div class="checkbox checkbox-solid-primary">
                                                        <input id="inline-{{$document->id}}"
                                                        @if(in_array($document->id,$documents_submitted)) checked  @endif value="{{$document->id}}" disabled
                                                            name="document_{{$document->id}}"  value="{{$document->id}}"
                                                        type="checkbox">
                                                        <label for="inline-{{$document->id}}">{{$document->name}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Exempted Courses</label>
                                    <div class="row ms-1">
                                         @foreach ($courses as $course)
                                            @if(in_array($course->id,$exemptions) || $course->id == "8" || $course->id == "9")
                                                <div class="col-md-4 col-lg-4 col-12 p-0">
                                                    <div class="form-group m-checkbox-inline mb-0">
                                                        <div class="checkbox checkbox-solid-primary">
                                                            <input id="exempted-course-{{$course->id}}"
                                                            @if(in_array($course->id,$exemptions)   ) checked  @endif disabled
                                                                name="exempted_course_{{$course->id}}"  value="{{$course->id}}"
                                                            type="checkbox">
                                                            <label for="exempted-course-{{$course->id}}">{{$course->name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div> 
                            </div>
                            <div class="col-3">
                                <a class="btn btn-secondary" href="{{url('/admission')}}">Back</a>    
                            </div>
                        </div>
                        <form method="GET" action='{{url('admission/readmit/'.$admission->id)}}' id="readmit_form" class="d-none">
                            <input type="submit" value="submit" >
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
    

    <div id="store_grade" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancetile" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('calculate_grade')}}" method="POST" id="grade_form">
                    @csrf
                    <div class="modal-header">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title" id="cancetile">Grade</h5>
                    </div>
                    <div class="modal-body">
                        <label>The grade has been calculated according to :</label>
                        <div id="grade-description" class="px-2 pb-2">
                            
                        </div>
                        <h5 style="font-size: 14px;font-weight:700">Note : </h5> <p class="text-danger">The grade has been calculated , it cant be changed to prevent inconsistency.
                            Please double check the marks entered before submitting the grade</p>
                        <input type="hidden" name="admission_id" value="{{$admission->id}}">
                        <input  type="hidden" name="grade" id="select_grade" value="">
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" onclick="closeModal()">Close</a> 
                        <input type="submit" class="btn btn-primary" value="Grade Admission">
                    </div>
                </form>        
            </div>
        </div>
    </div>


    <div id="cancel_admission" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancetile" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('cancel_admission')}}" method="POST" id="cancel_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancetile">Cancel Admission</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="my-input">State cancellation reason</label>
                            <input type="hidden" name="admission_id" value="{{$admission->id}}">
                            <textarea class="form-control" name="cancellation_reason" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Cancel Admission">
                    </div>
                </form>        
            </div>
        </div>
    </div>

    <div id="employed-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeed" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{route('student_employment_create')}} method="POST" id="employment_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeed"> Employment Information</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <input type="hidden" name="course_id" value="{{$admission->course_id}}">
                        <input type="hidden" name="user_id" value="{{$admission->student_id}}">
                        <input type="hidden" name="admission_id" value="{{$admission->id}}">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="company_name">Company Name <sup class="text-danger">*</sup></label>
                                <input id="company_name" class="form-control " type="text" name="company_name">
                            </div>
                            <div class="form-group col-6">
                                <label for="designation">Designation <sup class="text-danger">*</sup></label>
                                <input id="designation" class="form-control " type="text" name="designation">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="industry">Industry <sup class="text-danger">*</sup></label>
                                <input id="industry" class="form-control " type="text" name="industry">
                            </div>
                            <div class="form-group col-6">
                                <label for="salary">Salary <sup class="text-danger">*</sup></label>
                                <input id="salary" class="form-control " type="text" name="salary">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="location">Location <sup class="text-danger">*</sup></label>
                                <input id="location" class="form-control " type="text" name="location">
                            </div>
                            <div class="form-group col-6">
                                <label for="type">Employment Type <sup class="text-danger">*</sup></label>
                                <select class="form-control" name="employment_type">
                                    <option value="">Select an option</option>
                                    <option value="1">Permanent</option>
                                    <option value="2">Contract</option>
                                    <option value="3">Internship</option>         
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Mark Employed">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="terminate_admission" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancetile" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('terminate_admission')}}" method="POST" id="cancel_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="terminate">Terminate Admission</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="my-input">State termination reason</label>
                            <input type="hidden" name="admission_id" value="{{$admission->id}}">
                            <textarea class="form-control" name="cancellation_reason" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Terminate Admission">
                    </div>
                </form>        
            </div>
        </div>
    </div>
    <input type="hidden" value="{{$attendance_months}}" id="attendance_months" />
    <div id="attendance-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="attendance" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{route('attendance_create')}} method="POST" id="attendance_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeed">Mark Attendance</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="courseslot_id" value="{{$admission->courseslot_id}}">
                        <input type="hidden" name="coursebatch_id" value="{{$admission->coursebatch_id}}">
                        <input type="hidden" name="course_id" value="{{$admission->course_id}}">
                        <input type="hidden" name="user_id" value="{{$admission->student_id}}">
                        <input type="hidden" name="admission_id" value="{{$admission->id}}">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="present_days">Present Days <sup class="text-danger">*</sup></label>
                                <input id="present_days" class="form-control " type="number" name="present_days">
                            </div>
                            <div class="form-group col-4">
                                <label for="absent_days">Absent Days <sup class="text-danger">*</sup></label>
                                <input id="absent_days" class="form-control " type="number" name="absent_days">
                            </div>
                            <div class="form-group col-4">
                                <input type="hidden" value="{{$admission->CourseBatch->start_date}}" id="batchstartdate">
                                <input type="hidden" value="{{$admission->CourseBatch->expiry_date}}" id="batchenddate">
                                <label for="month_id">Month <sup class="text-danger">*</sup></label>
                                <select class="form-control" name="month_id" id="month_id">{{-- {{$admission->CourseSlot->name}} --}}
                                    <option value="">Select an option</option>        
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea class="form-control" name="remarks" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Mark Attendance">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" ></script>
    <script>
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
        function closeModal(){
            $('#store_grade').modal('hide');
        }
        function goToCertificate(id){
            window.open(`{{url('admission/certificate/${id}')}}`, '_blank');
        }
        function changeStatusWarning(message){
            swal({
                title: "Warning",
                text: message,
                icon: "warning",
            });
        } 
        function changeStatusConfirm(message,category){
            swal({
                title: "Warning",
                text: message,
                icon:'warning',
                buttons: ['Back','Yes I\'m Sure'],
                dangerMode: true,
                }).then((withdraw) => {
                    if (withdraw) {
                        if(category == 'cancel'){
                            $('#cancel_admission').modal('show');
                        }
                        else if(category == 'readmit'){
                           $('#readmit_form').submit();
                        }
                        else{
                            $('#terminate_admission').modal('show');
                        }
                    }
                });
        }
        
        function dateRange(d1, d2) {
            var dateEnd
            var dateStart
            if(moment(d2,'DD-MM-YYYY').isValid()){                
                dateStart = moment(d1,'DD-MM-YYYY');
                dateEnd = moment(d2,'DD-MM-YYYY');
            }
            else{
                dateStart = moment(d1,'MM/DD/YYYY') ;
                dateEnd = moment(d2,'MM/DD/YYYY');
            }
            var dates = []; //Substract one month to exclude endDate itself

            while (dateEnd > dateStart || dateStart.format('M') === dateEnd.format('M')) {
                dates.push({value:dateStart.format('M'),label: dateStart.format('MMMM')});
                dateStart.add(1,'month');
            }
            return dates;
        }

        @if(\Illuminate\Support\Facades\Session::has('employement_created'))   
            Notify('Employement', 'Admission was marked Employed','success') 
        @elseif(\Illuminate\Support\Facades\Session::has('attendance_created'))
            Notify('Attendance', 'Attendance was marked','success')
        @elseif(\Illuminate\Support\Facades\Session::has('attendance_already'))
            Notify('Danger', 'Record already exists','danger') 
        @elseif(\Illuminate\Support\Facades\Session::has('created'))
            Notify('Created', 'Admission was created','success') 
        @elseif(\Illuminate\Support\Facades\Session::has('cancelled'))
            Notify('Cancelled', 'Admission was marked cancelled','warning')
        @elseif(\Illuminate\Support\Facades\Session::has('readmitted'))
            Notify('Readmitted', 'Admission was readmitted','success') 
        @elseif(\Illuminate\Support\Facades\Session::has('terminated'))
            Notify('Terminated', 'Admission was terminated','warning') 
        @elseif(\Illuminate\Support\Facades\Session::has('graded'))
            Notify('Graded', 'Admission was Graded,Now you can generate Certificate','success') 
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger', 'Something went wrong','danger') 
        @endif
        $(document).ready(function () { 
            $('#attendance_form').validate({
                errorClass: "text-danger pt-1",
                rules: {
                    present_days: {
                        required: true,
                        digits: true
                    },
                    absent_days:{
                        required:true,
                        digits: true
                    },
                    month_id: {
                        required: true,                    
                    }
                },
                messages:{   
                    present_days: {
                        required: 'present days is required',
                        digits: 'enter only positive values'
                    },
                    absent_days:{
                        required:'absent days is required',
                        digits: 'enter only positive values'
                    },
                    month_id: {
                        required: 'month is required',                    
                    },
                },
                submitHandler: function(form,event) {
                    event.preventDefault();
                    let month_id = $('#month_id').val();
                    let total_days = parseInt($('#present_days').val()) + parseInt($('#absent_days').val());

                    if(month_id % 2 == 0 && month_id != 2 && month_id != 12 ){
                        if(total_days != 30){
                            Notify('Error','Total number of days should not be should be equal to 30','danger');
                            return
                        }    
                    }
                    else if((month_id % 2 !== 0 || month_id == 12) ){
                        if(total_days != 31){
                            Notify('Error','Total number of days should be should be equal to 31','danger');
                            return
                        }
                    }
                    else if(month_id == 2){

                        if(moment().isLeapYear()  && (total_days != 29) ){
                            Notify('Error','Total number of days should be equal to 29','danger');
                            return
                        }
                        else if(total_days != 28){
                            Notify('Error','Total number of days should be equal to 28','danger');
                            return
                        }

                    }
                   form.submit();
                    
                }
            });
            
            $('#employment_form').validate({
                errorClass: "text-danger pt-1",
                rules: {
                    company_name: {
                        required: true,
                    },
                    designation:{
                        required:true,
                    },
                    industry: {
                        required: true,                    
                    },
                    salary: {
                        required: true,
                    },
                    location:{
                        required:true,
                    },
                    employment_type: {
                        required: true,                    
                    },
                },
                messages:{   
                    company_name: {
                        required: 'company name is required',
                    },
                    designation:{
                        required:'designation is required',
                    },
                    industry: {
                        required: 'industry is required',                    
                    },
                    salary: {
                        required: 'salary is required',
                    },
                    location:{
                        required:'location is required',
                    },
                    employment_type: {
                        required: 'employement type is required',                    
                    },
                }
            });
            $('#grade_form').validate({
                errorClass: "text-danger pt-1",
                rules: {
                    cancellation_reason: {
                        required: true,
                    },
                },
                messages:{   
                    cancellation_reason: {
                        required: 'cancellation reason is required',
                    },
                }
            });
            $('#cancel_form').validate({
                errorClass: "text-danger pt-1",
                rules: {
                    grade: {
                        required: true,
                    },
                },
                messages:{   
                    grade: {
                        required: 'Please choose a grade',
                    },
                }
            });

            //months filter for dates
            let start_date = $('#batchstartdate').val();
            let end_date = $('#batchenddate').val();
            let monthsmarked =  JSON.parse($('#attendance_months').val());
            let months = dateRange(start_date,end_date)
            if(months.length){
                let leftmonths = months.filter((month) => {
                                    let flag = false;
                                    monthsmarked.forEach(element => {
                                        if(element == month.value){
                                           flag = true;
                                        }
                                    });   
                                    return !flag                                 
                                });
                leftmonths.forEach(element => {
                    $('#month_id').append(`
                        <option value="${element.value}">${element.label}</option>
                    `);
                });
            }

        });

        function OpenGradesModal(){
            let start_date = $('#batchstartdate').val();
            let end_date = $('#batchenddate').val();
            let months = dateRange(start_date,end_date)
            
            $.ajax({
                type: "post",
                url: `{{url('assessment/calculate-grade')}}`,
                data:{
                    _token: "{{csrf_token()}}",
                    admission_id: "{{$admission->id}}",
                    attendance_months_count: months.length 
                },
                beforeSend: function () {
                    $('#admissions-by-batches-loader').removeClass('d-none');
                    $('#admissions-by-batches-loader').show();
                },
                success: function (response) {
                    res = JSON.parse(response);
                    if(res.status){
                        let marks_desc = `
                                        <table class="table table-bordered text-center my-2">
                                        <tr>
                                            <th>Assessment Name</th>
                                            <th>Theory</th>
                                            <th>Practical</th>
                                            <th>Total</th>
                                        </tr>
                                        `;

                        res.data.description.forEach(el=>{
                            marks_desc += `
                                        <tr>
                                            <td>${el.name}</td>
                                            <td>${el.theory}</td>
                                            <td>${el.practical}</td>
                                            <td>${el.total}</td>
                                        </tr>`
                        });

                        marks_desc += '</table>';

                        let total_marks_data = res.data.marks;
                        let total_marks_desc = `
                                    <table class="table table-bordered text-center my-2">
                                        <tr>
                                            <th>Recieved Marks</th>
                                            <th>Total Marks</th>
                                            <th>Average %</th>
                                        </tr>
                                        <tr>
                                            <td>${total_marks_data.total_marks_recieved}</td>
                                            <td>${total_marks_data.total_marks_assessed}</td>
                                            <td>${total_marks_data.average_percentage}%</td>
                                        </tr>
                                    </table>`;

                        let att_data = res.data.attendance;
                        let attendance_desc = `
                                    <table class="table table-bordered text-center my-2">
                                        <tr>
                                            <th>Present days</th>
                                            <th>Total days</th>
                                            <th>Average %</th>
                                        </tr>
                                        <tr>
                                            <td>${att_data.total_present_days}</td>
                                            <td>${att_data.total_days}%</td>
                                            <td>${att_data.average_total_attendance}%</td>
                                        </tr>
                                    </table>`;

                        let grade_data = res.data.grade;
                        let grade_desc = `
                                    <table class="table table-bordered text-center my-2">
                                        <tr>
                                            <th>Grade Recieved</th>
                                            <th>Percentage</th>
                                        </tr>
                                        <tr>
                                            <td><span class="text-${
                                                grade_data.grade == 'A' ? 'success' : 
                                                    (grade_data.grade == 'B' ? 'primary' : 
                                                    ( grade_data.grade == 'C' ? 'warning' : 'danger')  )  
                                            } text-capitalize"><b>${grade_data.grade}</b><span></td>
                                            <td>${grade_data.percent}%</td>
                                        </tr>
                                    </table>`;

                        $('#grade-description').html(marks_desc + " " +total_marks_desc + " " + attendance_desc + " " + grade_desc)
                        $('#select_grade').val(grade_data.grade)

                        
                        $('#store_grade').modal('show');
                    }
                    else{
                        Notify('Error',res.data.error_message,'danger')
                    }
                },
                complete: function () {
                    $('#admissions-by-batches-loader').hide();
                },
            });

        }
    </script>
@endsection
