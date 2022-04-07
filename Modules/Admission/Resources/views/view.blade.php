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
                <div class="d-flex p-1 m-0 border header-buttons">
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('update.admissions'))
                        @if($admission->status == '1')
                        <div>  
                            <a href="{{url('admission/edit/'.$admission->id)}}">
                                <button class="btn bg-white" type="button">
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
                            <button class="btn bg-white " type="button" 
                                onclick="changeStatusConfirm('Do you Really Want to ReAdmit? ','readmit');"
                            >
                            <i class="fa fa-refresh btn-icon-prepend"></i>
                                Readmit
                            </button>
                        @else                    
                            <button class="btn bg-white " type="button" @if($admission->status != '1') 
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
                            <button class="btn bg-white" type="button" 
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
                        <button class="btn bg-white" type="button" @if($admission->status != '1') 
                            onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                            @else
                                onclick="changeStatusConfirm('Do you Really Want to Terminate the Admission','terminate');"
                            @endif>
                            <i class="fa fa-ban btn-icon-prepend"></i>
                            Terminate
                        </button>
                    </div>
                    @endif
                    <div>
                        <a href="{{route('print_admission_form',$admission->id)}}" target="_blank">
                            <button class="btn bg-white">
                                <i class="fa fa-print btn-icon-prepend"></i>
                                Print
                            </button>
                        </a>    
                    </div>
                    {{-- @if(\App\Http\Helpers\CheckPermission::hasPermission('delete.admissions')) --}}
                    <div>
                        <a type="button" target="_blank" href="{{url('admission/id-card/'.$admission->id)}}">
                            <button class="btn bg-white" type="button" >
                                    <i class="fa fa-id-card" style="font-size: 0.9rem;"></i> 
                                    Get ID-Card                         
                            </button>
                        </a>        
                    </div>
                    <div>
                        <a type="button"  href="{{route('user_profile_admin_from_other',$admission->student_id)}}">
                            <button class="btn bg-white" type="button" >
                                    <i class="fa fa-user" style="font-size: 0.9rem;"></i> 
                                    View Profile                        
                            </button>
                        </a>        
                    </div>
                    @if($admission->status == '1') 
                        <div>
                            <button class="btn bg-white" type="button" @if ($grade == "") onclick="OpenGradesModal()" @else onclick="goToCertificate({{$admission->id}})" @endif>
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
                    {{-- @endif --}}
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
                        <h5 class="modal-title" id="cancetile">Grade</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="my-input">Enter Grade</label>
                            <input type="hidden" name="admission_id" value="{{$admission->id}}">
                            <select name="grade" id="select_grade" class="form-control">
                                <option value="">Select an option</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
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
@endsection
@section('jcontent')
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
        function OpenGradesModal(){
            $('#store_grade').modal('show');
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
        
        @if(\Illuminate\Support\Facades\Session::has('employement_created'))   
            Notify('Employement', 'Admission was marked Employed','success') 
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
            $('$grade_form').validate({
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
        });

        
    </script>
@endsection
