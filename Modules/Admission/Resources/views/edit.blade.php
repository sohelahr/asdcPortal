@extends('layouts.admin.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
            Edit Admissions
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Admissions</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="overlay-loader" class="d-none">
            <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                <div >  
                    
                        <div class="dot-opacity-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('user_admission_edit',$admission->id)}}" method="POST" enctype="multipart/form-data" id="edit_form"> 
                @csrf       
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Student Name</label>
                            <input required type="text" class="form-control form-control-sm" name="firstname"
                                value="{{$student->name}}" disabled>
                                <input type="hidden" name="student_id" value="{{$student->id}}">
                                <input type="hidden" name="registered_course_id" value="{{$selected_course_id}}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12">
                                <p>WARNING : If you change the course now then custom entries for earlier 
                                course will be lost, although you can redit them, please proceed with caution</p>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Roll No</label>
                                    <input class="form-control form-control-sm" name="roll_no" type="text" value="{{$admission->roll_no}}" id="roll_no">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Admission Form Number</label>
                                    <input class="form-control form-control-sm" type="text" name="admission_form_number" id="admission_form_no" value={{$admission->admission_form_number}}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label class="form-label">Course <sup class="text-danger">*</sup></label>

                            <select class="form-control" name="course_id" id="admission_course">
                                @foreach ($courses as $course)
                                    <option value="{{$course->id}}" @if ($course->id == $admission->course_id)
                                        selected
                                    @endif>{{$course->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course Timing <sup class="text-danger">*</sup></label>

                            <select class="form-control" name="course_slot_id" id="course_slot">
                                @foreach ($initial_course_slots as $courseslot)
                                    <option value="{{$courseslot->id}}" @if ($courseslot->id == $admission->courseslot_id)
                                        selected
                                    @endif>{{$courseslot->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course Batch <sup class="text-danger">*</sup></label>

                            <select class="form-control" name="coursebatch_id" id="course_batch">
                                @if(count($initial_course_batches) > 0)
                                    @foreach ($initial_course_batches as $coursebatch)
                                        <option value="{{$coursebatch->id}}" @if ($coursebatch->id == $admission->coursebatch_id)
                                        selected
                                    @endif>{{$coursebatch->batch_number}}</option>
                                    @endforeach
                                @else
                                    <option value="">No Batches Found</option>
                                @endif
                            </select>

                        </div>
                    </div>
            
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Admission Remarks <sup class="text-danger">*</sup></label>
                            <textarea class="form-control" rows="7" name="admission_remarks">{{$admission->admission_remarks}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label class="form-label">Documents Submitted</label>
                        @foreach ($documents as $document)
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name="document_{{$document->id}}"
                                @if (in_array($document->id,$submitted_documents))
                                    checked
                                @endif
                                value="{{$document->id}}">
                              {{$document->name}}
                            <i class="input-helper"></i></label>
                          </div>  
                        @endforeach
                        </div> 
                      </div>
                </div>                                                         
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a class="btn btn-light" href="{{url('admin/dashboard')}}">Cancel</a>
            </form>
        </div>
    </div>
@endsection
@section('jcontent')
<script>
    $('#wait-text').hide();  
    
    $("#admission_course").on('change',function(){
        let course_id = $("#admission_course").val()
        $.ajax({
            type: "get",
            url: `{{url('admission/getforminputs/${course_id}')}}`,
            beforeSend: function() {
                    $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
            },
            success: function (response) {
                $("#course_slot").empty();
                $("#course_batch").empty();

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
                if(response.course_batches.length > 0){
                    $.each(response.course_batches, function (index, element) { 
                        $("#course_batch").append(`
                            <option value="${element.id}">${element.batch_number}</option>
                        `);
                    });
                }
                else
                {
                    $("#course_batch").append(`
                            <option value="">Not Found</option>
                        `);
                }
                if(response.roll_no){
                    $('#roll_no').val(response.roll_no);
                }
                console.log(response)
                if(response.admission_form_number){
                    $('#admission_form_no').val(response.admission_form_number);
                }
                
            },
            complete: function () {
                    $('#overlay-loader').hide();
            },

        });
    });

    $(document).ready(function () {
             $('#edit_form').validate({
                errorClass: "text-danger pt-1",            
                rules: {     
                    course_id: {
                        required: true,
                    },
                    coursebatch_id: {
                        required: true,
                    },
                    course_slot_id: {
                        required: true,
                    },
                    admission_remarks: {
                        required: true,
                    },  
                },
                messages: {
                    course_id: {
                        required: "Course is required",
                    },
                    coursebatch_id: {
                        required: "Please select a batch",
                    },
                    course_slot_id: {
                        required: "Please select a timing",
                    },
                    admission_remarks: {
                        required: "Please enter a remarks",
                    },  
                } 
            });
    }); 
</script>
@endsection
