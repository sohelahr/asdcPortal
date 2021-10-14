@extends('layouts.admin.app')
@section('content')
    <div class="page-header">
        <h3 class="page-title">
           Create Admissions
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Admissions</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        
        <div class="card-body">
            <form action="{{route('user_admission_create')}}" method="POST" enctype="multipart/form-data" id = "admission"> 
                @csrf       
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Student Name</label>

                            <input required type="text" class="form-control form-control-sm" name="firstname"
                                value="{{$student->name}}" disabled>
                                <input  type="hidden" name="registration_id" value="{{$registration_id}}"> 
                                <input  type="hidden" name="student_id" value="{{$student->id}}"> 
                                
                        </div>
                    </div>
                    <div class="col-md-4">
                            <p id="wait-text" class="text-danger">Please Wait...</p>

                        <div class="form-group">

                            <label class="form-label">Course</label>
                            <input type="hidden" name="registered_course_id" value="{{$selected_course->id}}">
                            <select class="form-control" name="course_id" id="admission_course">
                                @foreach ($courses as $course)
                                    <option value="{{$course->id}}" @if ($course->id == $selected_course->id)
                                        selected
                                    @endif>{{$course->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course Batch</label>

                            <select class="form-control" name="coursebatch_id" id="course_batch">
                                @if(count($initial_course_batches) > 0)
                                    @foreach ($initial_course_batches as $coursebatch)
                                        
                                            <option value="{{$coursebatch->id}}">{{$coursebatch->batch_number}}</option>
                                    @endforeach
                                @else
                                    <option>No Batches Found</option>
                                @endif
                            </select>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Course Timing</label>

                            <select class="form-control" name="course_slot_id" id="course_slot">
                                @foreach ($initial_course_slots as $courseslot)
                                    <option value="{{$courseslot->id}}" @if ($courseslot->id == $selected_course_slot->id)
                                        selected
                                    @endif>{{$courseslot->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                        <label class="form-label">Documents Submitted</label>
                        @foreach ($documents as $document)
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name="document_{{$document->id}}"  value="{{$document->id}}">
                              {{$document->name}}
                            <i class="input-helper"></i></label>
                          </div>  
                        @endforeach
                        </div>
                    </div>
                    
                    
            
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Admission Remarks</label>
                            <textarea class="form-control" rows="14" name="admission_remarks"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                         
                      </div>
                </div>                                                         
                <button type="submit" class="btn btn-primary mr-2" onclick = "validate()">Submit</button>
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
              $('#wait-text').show();  
            },
            success: function (response) {
                console.log(response)
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
                $('#wait-text').hide();  
            }
        });
    });

   
}
    
</script>
@endsection
