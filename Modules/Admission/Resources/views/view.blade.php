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
                </div>
                <div class="float-right">
                    <a type="button" class="btn btn-primary btn-icon-text" href="{{route('print_admission_form',$admission->id)}}" target="_blank">
                          Print
                          <i class="fa fa-print btn-icon-append"></i>                                                                              
                    </a>                                                         
                </div>
        </div>
    </div>
@endsection
@section('jcontent')

@endsection
