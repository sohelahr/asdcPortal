@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Create Admissions</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/registration')}}">Registrations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Admissions</li>
	@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div id="overlay-loader" class="d-none">
                    <div style="height: 100%;width:100%;position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
                        <div> 
                            <div class="loader-box">
                                <div class="loader-7"></div>
                            </div>              
                        </div>
                    </div>
                </div>
                <div class="d-flex p-1 m-0 border header-buttons justify-content-end">
                    <div>
                        
                        <button class="btn bg-white" style="font-weight: 500;color: #59667a;font-size:15px" type="button"  >
                            Remaining Capacity : <span  @if(isset($transaction)) id="current_capacity"
                            class={{$transaction->current_capacity > 5 ? "text-success" : "text-danger" }}@endif>
                            @if(isset($transaction)){{$transaction->current_capacity}}@endif</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('user_admission_create')}}" method="POST" enctype="multipart/form-data" id="admission_form"> 
                        @csrf       
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Student Name</label>

                                    <input required type="text" class="form-control " name="firstname"
                                        value="{{$student->name}}" disabled>
                                        <input  type="hidden" name="registration_id" value="{{$registration_id}}"> 
                                        <input  type="hidden" name="student_id" value="{{$student->id}}"> 
                                        
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Roll No </label>
                                    <input class="form-control" name="roll_no" type="text" value="{{$roll_no}}" readonly id="roll_no" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Admission Form Number </label>
                                    <input class="form-control" type="text" name="admission_form_number" readonly id="admission_form_no" value={{$admission_form_number}} >
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="form-group">
                                    <label class="form-label">Course {{-- <sup class="text-danger">*</sup> --}}</label>
                                    <input type="hidden" name="registered_course_id" value="{{$selected_course->id}}">
                                    <input class="form-control" type="hidden" name="course_id" readonly id="admission_course" value='{{$selected_course->id}}' >
                                    <input class="form-control" type="text" readonly  value='{{$selected_course->name}}' >

                                    {{-- <select class="form-control readonly" readonly aria-readonly="true" name="course_id" id="admission_course">
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}" @if ($course->id == $selected_course->id)
                                                selected
                                            @endif>{{$course->name}}</option>
                                        @endforeach
                                    </select> --}}

                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Course Batch {{-- <sup class="text-danger">*</sup> --}}</label>
                                    {{-- <input class="form-control" type="hidden" name="coursebatch_id" readonly id="course_batch" value='{{$current_course_batch->id}}' >
                                    <input class="form-control" type="text"  readonly  value='{{$current_course_batch->batch_number}}' > --}}

                                    <select class="form-control" name="coursebatch_id" id="course_batch">
                                        @if(count($initial_course_batches) > 0)
                                            @foreach ($initial_course_batches as $coursebatch)
                                                
                                                    <option value="{{$coursebatch->id}}"@if(isset($current_course_batch)) @if($current_course_batch->id == $coursebatch->id) selected @endif @endif>{{$coursebatch->batch_number}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Batches Found</option>
                                        @endif
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Course Timing {{-- <sup class="text-danger">*</sup> --}}</label>
                                    {{-- <input class="form-control" type="hidden" name="course_slot_id" readonly id="course_slot" value='{{$selected_course_slot->id}}' >
                                    <input class="form-control" type="text" readonly value='{{$selected_course_slot->name}}' > --}}

                                    <select class="form-control" name="course_slot_id" id="course_slot">
                                        @if($selected_course_slot)
                                            @foreach ($initial_course_slots as $courseslot)
                                                <option value="{{$courseslot->id}}" @if ($courseslot->id == $selected_course_slot->id)
                                                    selected
                                                @endif>{{$courseslot->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Timings Found</option>
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Admission Remarks <sup class="text-danger">*</sup></label>
                                    <textarea class="form-control" rows="4" name="admission_remarks"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Documents Submitted <sup class="text-danger">*</sup></label>
                                    <div class="row ms-1">
                                        @foreach ($documents as $document)
                                            <div class="col-md-3 col-lg-3 col-12 p-0">
                                                <div class="form-group m-checkbox-inline mb-0">
                                                    <div class="checkbox checkbox-primary">
                                                        <input id="inline-{{$document->id}}"
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
                                            @if(($course->id == "8" || $course->id == "9") && $course->id != $selected_course->id)
                                                <div class="col-md-4 col-lg-4 col-12 p-0">
                                                    <div class="form-group m-checkbox-inline mb-0">
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="exempted-course-{{$course->id}}"
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
                            
                        </div>                                                         
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a class="btn btn-light" href="{{url('/registration')}}">Cancel</a>
                    </form>
                </div>
            </div>
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
    @if(\Illuminate\Support\Facades\Session::has('capacity_full'))   
        Notify('Capacity Full','Capacity for that batch and slot is full','warning') 
    @elseif(\Illuminate\Support\Facades\Session::has('already'))   
        Notify('Duplicate','Admission already exist for this student and course','warning') 
    @endif
    $('#wait-text').hide();  
    
    $('#course_batch').on('change',function(){
        let slot = $('#course_slot').val();
        let batch = $('#course_batch').val();
        if(slot || batch)
            getTransaction(slot,batch);
        else
        return null;
    });
    
    $('#course_slot').on('change',function(){
        let slot = $('#course_slot').val();
        let batch = $('#course_batch').val();
        if(slot || batch)
            getTransaction(slot,batch);
        else
        return null;
    });

    $("#admission_course").on('change',function(){
        let course_id = $("#admission_course").val()
        let slot = $('#course_slot').val();
        let batch = $('#course_batch').val();
        getTransaction(slot,batch);
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
                            if(element.status){
                                $("#course_batch").append(`
                                    <option value="${element.id}"${element.is_current?'selected':''}>${element.batch_number}</option>
                                `);
                            }
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
             $('#admission_form').validate({
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
    
    function getTransaction(slot,batch){
        $.ajax({
            type: "get",
            url: `{{url('admission/getransaction/${slot}/${batch}')}}`,
            beforeSend: function() {
              $('#overlay-loader').removeClass('d-none');
                    $('#overlay-loader').show();
            },
            success: function (response) {
            
                if(response.transaction == null){
                    $('#current_capacity').empty().removeClass('text-success').removeClass('text-danger').addClass('text-danger').text('Not found');
                }
                else{
                    response.transaction.current_capacity > 5 ? $('#current_capacity').addClass('text-success').removeClass('text-danger') : $('#current_capacity').removeClass('text-success').addClass('text-danger')
                    $('#current_capacity').empty().text(response.transaction.current_capacity);
                }
            },
            complete: function () {
                $('#overlay-loader').hide();
            },
        });
    }

</script>
@endsection
