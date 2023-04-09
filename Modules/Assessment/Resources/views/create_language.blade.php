@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Assess Language for Other Courses</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('assessment')}}">Assessments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assess Language for Other Courses</li>
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
                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('assessment_header_create')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Course <sup class="text-danger">*</sup></label>
                                        <select id="course" class="form-control" name="course_id">
                                            <option value="">Choose Course</option>
                                            @foreach ($courses as $course)
                                                @if($course->id != '8' && $course->id != '9'))
                                                 <option value="{{$course->id}}">{{$course->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Batch<sup class="text-danger">*</sup></label>
                                        <select id="coursebatch" class="form-control" name="coursebatch_id">
                                            <option value="">Choose Batch</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Timing<sup class="text-danger">*</sup></label>
                                        <select id="courseslot" class="form-control" name="courseslot_id">
                                            <option value="">Choose Timing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Language <sup class="text-danger">*</sup></label>
                                        <input type="hidden" class="form-control " value="true" name="is_language_assesment">
                                        <select id="course" class="form-control" name="language_course_id">
                                            <option value="">Choose Language</option>
                                            @foreach ($courses as $course)
                                                @if($course->id == '8' || $course->id == '9'))
                                                    <option value="{{$course->id}}">{{$course->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Assessment Name <sup class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control " name="assessment_name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Held On<sup class="text-danger">*</sup></label>
                                        <input class="date_picker form-control" type="text" data-language="en" name="held_on" readonly
                                            />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Instructor <sup class="text-danger">*</sup></label>
                                            <select id="instructor" class="form-control" name="instructor_id">
                                                <option value="">Choose Instructor</option>
                                            </select>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">Max Theory Marks <sup class="text-danger">*</sup></label>
                                        <input required type="text" class="form-control " name="max_theory">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Practical Marks </label>
                                        <input type="text" class="form-control " name="max_practical">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-secondary"
                                href="{{url('/assessment')}}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
    @section('jcontent')
    <script>
        var date = new Date();

        $('.date_picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd-mm-yyyy',
            useCurrent: false,
            autoClose:true,
        });

         $('#course').on('change',function(){
            let id = $('#course').val();
            $.ajax({
                type: "get",
                url: `{{url('feedback/get-form-inputs/${id}')}}`,
                beforeSend: function (){
                    $('#admissions-by-batches-loader').removeClass('d-none');
                },
                success: function (response) {
                    
                    $("#instructor").empty();
                    $("#coursebatch").empty();
                    $("#courseslot").empty();

                    if(response.instructors.length > 0){
                        $("#instructor").append(`
                            <option value="">Select Instructor</option>
                        `);
                        $.each(response.instructors, function (index, element) { 
                            $("#instructor").append(`
                                <option value="${element.id}">${element.firstname + " "+ element.lastname}</option>
                            `);
                        });
                    }
                    else
                    {
                        $("#instructor").append(`
                                <option value="">Not Found</option>
                            `);
                    }
                    
                    if(response.course_batches.length > 0){
                        $("#coursebatch").append(`
                            <option value="">Select Batch</option>
                        `);
                        $.each(response.course_batches, function (index, element) { 
                            
                            $("#coursebatch").append(`
                                <option value="${element.id}">${element.batch_identifier}</option>
                            `);
                        });
                    }
                    else
                    {
                        $("#coursebatch").append(`
                                <option value="">Not Found</option>
                            `);
                    }

                    if(response.course_slots.length > 0){
                        $("#courseslot").append(`
                            <option value="">Select Timing</option>
                        `);
                        $.each(response.course_slots, function (index, element) { 
                            $("#courseslot").append(`
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
                    
                    /* 
                    generateDoughnutChartForBatchAdmissions(piedata); */
                },
                complete: function(){
                    $('#admissions-by-batches-loader').addClass('d-none');
                }
            });
        });


         $(document).ready(function (){
            $('#edit_profile').validate({
                errorClass: "text-danger pt-1",
                errorPlacement: function(error, element) {
                        if (element.attr("name") == "held_on"){
                            error.insertAfter(element.parent());
                        }
                        else {
                            error.insertAfter(element);
                        }          
                    }, 
                rules: {

                        course_id: {
                            required: true,
                        },

                        coursebatch_id: {
                            required: true,
                        },

                        courseslot_id: {
                            required: true,
                        },

                        assessment_name: {
                            required: true,
                        },

                        instructor_id: {
                            required: true,
                        },
                        max_theory: {
                            required: true,
                            digits: true,
                            minlength: 0
                        },
                        held_on: {
                            required: true,
                            /* date:true, */
                        },

                    },

                    messages: {
                        course_id: {
                            required: "Please choose course",
                        },

                        coursebatch_id: {
                            required: "Please choose batch",
                        },
                        
                        courseslot_id: {
                            required: "Please choose timings",
                        },

                        assessment_name: {
                            required: "Please enter assessment name",
                        },

                        instructor_id: {
                            required: "Please select instructor",
                        },

                        max_theory: {
                            required: "Please enter theory marks",
                        },

                        held_on: {
                            required: "Please enter the date",
                        },


                    }



            });
        });
   
    </script>
    @endsection