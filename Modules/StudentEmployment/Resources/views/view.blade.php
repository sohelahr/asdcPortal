@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>View Student Employment</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/studentemployment')}}">Employements</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Employment</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    @if(\App\Http\Helpers\CheckPermission::hasPermission('update.student_employment'))
                        <div class="d-flex p-1 m-0 border header-buttons">
                            <div>
                                <button class="btn bg-white" type="button" data-bs-toggle="modal" data-bs-target="#employed-modal">
                                    <i class="fa fa-edit btn-icon-prepend"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Student Name</label>
                                    <input required type="text" class="form-control" name="firstname"
                                        value="{{$employment->Student->name}}" disabled> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Admission Form Number</label>
                                    <input class="form-control" type="text" disabled name="admission_form_number" value="{{$admission->admission_form_number}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Course</label>
                                    <input type="text" class=" form-control" disabled value="{{$employment->Course->name}}">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class=" form-control" disabled value="{{$employment->company_name}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Designation</label>
                                    <input type="text" class=" form-control" disabled value="{{$employment->designation}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Industry</label>
                                    <input type="text" class=" form-control" disabled value="{{$employment->industry}}">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Salary</label>
                                    <input type="text" class=" form-control" disabled value="{{$employment->salary}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Location</label>
                                    <input type="text" class=" form-control" disabled value="{{$employment->location}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Employment Type</label>
                                    <input type="text" class=" form-control" disabled 
                                    @switch($employment->employment_type)
                                        @case('1')
                                            value="Permanent"
                                            @break
                                        @case('2')
                                            value="Contract"
                                            @break
                                        
                                        @case('3')
                                            value="Internship"
                                            @break    
                                    @endswitch
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="employed-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeed" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{route('student_employment_update',$employment->id)}} method="POST" id="employment_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeed"> Update Employment Information</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="company_name">Company Name <sup class="text-danger">*</sup></label>
                                <input id="company_name" value="{{$employment->company_name}}" class="form-control" type="text" name="company_name">
                            </div>
                            <div class="form-group col-6">
                                <label for="designation">Designation <sup class="text-danger">*</sup></label>
                                <input id="designation" value="{{$employment->designation}}" class="form-control" type="text" name="designation">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="industry">Industry <sup class="text-danger">*</sup></label>
                                <input id="industry" value="{{$employment->industry}}" class="form-control" type="text" name="industry">
                            </div>
                            <div class="form-group col-6">
                                <label for="salary">Salary <sup class="text-danger">*</sup></label>
                                <input id="salary" value="{{$employment->salary}}" class="form-control" type="text" name="salary">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="location">Location <sup class="text-danger">*</sup></label>
                                <input id="location" value="{{$employment->location}}" class="form-control" type="text" name="location">
                            </div>
                            <div class="form-group col-6">
                                <label for="type">Employment Type <sup class="text-danger">*</sup></label>
                                <select class="form-control" name="employment_type">
                                    <option value="">Select an option</option>
                                    <option value="1" 
                                        @if ($employment->employment_type == '1')
                                            selected
                                        @endif>
                                        Permanent
                                    </option>
                                    <option value="2" @if ($employment->employment_type == '2')
                                        selected
                                    @endif>Contract</option>
                                    <option value="3" @if ($employment->employment_type == '3')
                                        selected
                                    @endif>Internship</option>         
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Update">
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
         @if(\Illuminate\Support\Facades\Session::has('employment_updated'))   
            Notify('Employement','Admission was marked Employed','success');        
        @elseif(\Illuminate\Support\Facades\Session::has('error'))
            Notify('Danger','Something Went Wrong','Danger');
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

        });

        
    </script>
@endsection
