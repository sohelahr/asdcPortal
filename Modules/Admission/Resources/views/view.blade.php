@extends('layouts.admin.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            View Admission
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Admission</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="d-flex p-1 m-0 border header-buttons">
            <div>
                <a href="{{url('admission/edit/'.$admission->id)}}">
                    <button class="btn bg-white" type="button">
                    <i class="fa fa-edit btn-icon-prepend"></i>
                        Edit
                    </button>
                </a>
            </div>
            <div>
                <button class="btn bg-white " type="button" @if($admission->status != '1') 
                    onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                    @else
                        onclick="changeStatusConfirm('Do you Really Want to Cancel the Admission','cancel');"
                    @endif>
                    <i class="fa fa-times-circle btn-icon-prepend"></i>
                    Cancel
                </button>
            </div>
            <div>
                <button class="btn bg-white" type="button" @if($admission->status != '1') 
                    onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                    @else
                        data-toggle="modal" data-target="#employed-modal"
                    @endif>
                    <i class="fas fa-industry btn-icon-prepend"></i>
                    Mark Employed
                </button>
            </div>
            <div>
                <button class="btn bg-white" type="button" @if($admission->status != '1') 
                    onclick="changeStatusWarning('Admission is already Cancelled/Terminated or Employed');"
                    @else
                        onclick="changeStatusConfirm('Do you Really Want to Terminate the Admission','terminate');"
                    @endif>
                    <i class="fas fa-ban btn-icon-prepend"></i>
                    Terminate
                </button>
            </div>
            <div>
                <a href="{{route('print_admission_form',$admission->id)}}" target="_blank">
                    <button class="btn bg-white">
                        <i class="fa fa-print btn-icon-prepend"></i>
                        Print
                    </button>
                </a>    
            </div>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Student Name</label>
                            <input required type="text" class="form-control form-control-sm" name="firstname"
                                value="{{$admission->Student->name}}" disabled> 
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Roll No</label>
                            <input class="form-control form-control-sm" name="roll_no" type="text" disabled value="{{$admission->roll_no}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Admission Form Number</label>
                            <input class="form-control form-control-sm" type="text" disabled name="admission_form_number" value="{{$admission->admission_form_number}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$admission->Course->name}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course Timing</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$admission->CourseSlot->name}}">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course Batch</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$admission->CourseBatch->batch_number}}">
                        </div>
                    </div>
            
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Admission Remarks</label>
                            <textarea class="form-control" rows="7" name="admission_remarks" disabled>{{$admission->admission_remarks}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Documents Submitted</label>
                            @foreach ($documents as $document)
                                <div class="form-check form-check-primary">
                                    <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" @if(in_array($document->id,$documents_submitted)) checked  @endif value="{{$document->id}}" disabled>
                                    {{$document->name}}
                                    <i class="input-helper"></i></label>
                                </div>  
                            @endforeach
                        </div> 
                      </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Admission Status</label>
                                <input type="text" class="form-control-sm form-control" disabled 
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Admitted By</label>
                                <input type="text" class="form-control-sm form-control" disabled value="{{$admission->AdmittedBy->name}}" >
                            </div>
                        </div>
                        @if ($admission->status == '4' ||$admission->status == '5')
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Reason</label>
                                <textarea class="form-control" rows="7" disabled>{{$admission->cancellation_reason}}</textarea>
                            </div>
                        </div>
                        @endif
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
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <input type="hidden" name="course_id" value="{{$admission->course_id}}">
                        <input type="hidden" name="user_id" value="{{$admission->student_id}}">
                        <input type="hidden" name="admission_id" value="{{$admission->id}}">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="company_name">Company Name <sup class="text-danger">*</sup></label>
                                <input id="company_name" class="form-control form-control-sm" type="text" name="company_name">
                            </div>
                            <div class="form-group col-6">
                                <label for="designation">Designation <sup class="text-danger">*</sup></label>
                                <input id="designation" class="form-control form-control-sm" type="text" name="designation">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="industry">Industry <sup class="text-danger">*</sup></label>
                                <input id="industry" class="form-control form-control-sm" type="text" name="industry">
                            </div>
                            <div class="form-group col-6">
                                <label for="salary">Salary <sup class="text-danger">*</sup></label>
                                <input id="salary" class="form-control form-control-sm" type="text" name="salary">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="location">Location <sup class="text-danger">*</sup></label>
                                <input id="location" class="form-control form-control-sm" type="text" name="location">
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
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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
                        else{
                            $('#terminate_admission').modal('show');
                        }
                    }
                });
        }
        
         @if(\Illuminate\Support\Facades\Session::has('employementcreated'))    
            $.toast({
                heading: 'Employement',
                text: 'Admission was marked Employed',
                position:'top-right',
                icon: 'success',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('cancelled'))
            $.toast({
                heading: 'Cancelled',
                text: 'Admission was Cancelled',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
        @elseif(\Illuminate\Support\Facades\Session::has('terminated'))
            $.toast({
                heading: 'Terminated',
                text: 'Admission was Terminated',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })            
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            $.toast({
                heading: 'Danger',
                text: 'Something Went Wrong ',
                position:'top-right',
                icon: 'danger',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
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
            $('#cancel_form').validate({
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
        });

        
    </script>
@endsection
