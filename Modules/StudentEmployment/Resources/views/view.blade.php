@extends('layouts.admin.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            View Student Employment
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Employment</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        @if(\App\Http\Helpers\CheckPermission::hasPermission('update.student_employment'))
            <div class="d-flex p-1 m-0 border header-buttons">
                <div>
                    <button class="btn bg-white" type="button" data-toggle="modal" data-target="#employed-modal">
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
                            <input required type="text" class="form-control form-control-sm" name="firstname"
                                value="{{$employment->Student->name}}" disabled> 
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
                            <input type="text" class="form-control-sm form-control" disabled value="{{$employment->Course->name}}">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$employment->company_name}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$employment->designation}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Industry</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$employment->industry}}">
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Salary</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$employment->salary}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control-sm form-control" disabled value="{{$employment->location}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Employment Type</label>
                            <input type="text" class="form-control-sm form-control" disabled 
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


    <div id="employed-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeed" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{route('student_employment_update',$employment->id)}} method="POST" id="employment_form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeed"> Update Employment Information</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="company_name">Company Name <sup class="text-danger">*</sup></label>
                                <input id="company_name" value="{{$employment->company_name}}" class="form-control form-control-sm" type="text" name="company_name">
                            </div>
                            <div class="form-group col-6">
                                <label for="designation">Designation <sup class="text-danger">*</sup></label>
                                <input id="designation" value="{{$employment->designation}}" class="form-control form-control-sm" type="text" name="designation">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="industry">Industry <sup class="text-danger">*</sup></label>
                                <input id="industry" value="{{$employment->industry}}" class="form-control form-control-sm" type="text" name="industry">
                            </div>
                            <div class="form-group col-6">
                                <label for="salary">Salary <sup class="text-danger">*</sup></label>
                                <input id="salary" value="{{$employment->salary}}" class="form-control form-control-sm" type="text" name="salary">
                            </div>
                            
                            <div class="form-group col-6">
                                <label for="location">Location <sup class="text-danger">*</sup></label>
                                <input id="location" value="{{$employment->location}}" class="form-control form-control-sm" type="text" name="location">
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
        
         @if(\Illuminate\Support\Facades\Session::has('employment_updated'))    
            $.toast({
                heading: 'Employement',
                text: 'Admission was marked Employed',
                position:'top-right',
                icon: 'success',
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

        });

        
    </script>
@endsection
