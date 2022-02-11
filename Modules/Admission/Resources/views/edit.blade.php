@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Edit Admission</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/registration')}}">Registrations</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admission/view/'.$admission->id)}}">View Admission</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Admission</li>
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
                        
                        <button class="btn bg-white" style="font-weight: 500;color: #59667a;font-size:15px" type="button" >
                            Remaining Capacity : <span id="current_capacity" 
                                class={{$transaction->current_capacity > 5 ? "text-success" : "text-danger" }}>
                                {{$transaction->current_capacity}}</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('user_admission_edit',$admission->id)}}" method="POST" enctype="multipart/form-data" id="edit_form"> 
                        @csrf       
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Student Name</label>
                                    <input required type="text" class="form-control" name="firstname"
                                        value="{{$student->name}}" disabled>
                                        <input type="hidden" name="student_id" value="{{$student->id}}">
                                        <input type="hidden" name="registered_course_id" value="{{$selected_course_id}}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Roll No</label>
                                            <input class="form-control" name="roll_no" type="text" value="{{$admission->roll_no}}" id="roll_no" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Admission Form Number</label>
                                            <input class="form-control" type="text" name="admission_form_number" id="admission_form_no" value={{$admission->admission_form_number}} readonly>
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
                            
                            
                    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Admission Remarks <sup class="text-danger">*</sup></label>
                                    <textarea class="form-control" rows="4" name="admission_remarks">{{$admission->admission_remarks}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Documents Submitted</label>
                                    <div class="row ms-1">
                                        @foreach ($documents as $document)
                                            <div class="col-md-3 col-lg-3 col-12 p-0">
                                                <div class="form-group m-checkbox-inline mb-0">
                                                    <div class="checkbox checkbox-primary">
                                                        <input id="inline-{{$document->id}}"
                                                        @if(in_array($document->id,$submitted_documents)) checked  @endif value="{{$document->id}}"
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
                            @if ($grade != "")
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Grade</label>
                                        <input type="text" class= form-control" name="grade" value="{{$grade}}" >
                                    </div>
                                </div>
                            @endif
                        </div>                                                         
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a class="btn btn-secondary" href="{{url('/admission/view/'.$admission->id)}}">Cancel</a>
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
        $.toast({
            heading: 'Capacity Full',
            text: 'Capacity for the following batches and slot is full',
            position:'top-right',
            icon: 'warning',
            loader: true,        // Change it to false to disable loader
            loaderBg: '#9EC600'  // To change the background
        })
    @elseif(\Illuminate\Support\Facades\Session::has('capacity_readmission_full'))    
        $.toast({
            heading: 'Capacity Full',
            text: 'Capacity for the following batch/slot is full, please readmit in other batch/slot.',
            position:'top-right',
            icon: 'warning',
            loader: true,        // Change it to false to disable loader
            loaderBg: '#9EC600'  // To change the background
        })
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
