@extends('layouts.admin.app')
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Feedback Create</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('feedback')}}">Feedbacks</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback Create</li>
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
                        <form action="{{route('feedback_header_create')}}" method="POST" enctype="multipart/form-data" id = "edit_profile">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Course <sup class="text-danger">*</sup></label>
                                        <select id="course" class="form-control" name="course_id">
                                            <option value="">Choose Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
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
                                        <label class="form-label">Instructor <sup class="text-danger">*</sup></label>
                                            <select id="instructor" class="form-control" name="instructor_id">
                                                <option value="">Choose Instructor</option>
                                            </select>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Start Date <sup class="text-danger">*</sup></label>
                                                 <input class="date_picker form-control" type="text" data-language="en" name="start_date" readonly
                                                 />
                            
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">End Date<sup class="text-danger">*</sup></label>
                                                <input class="date_picker form-control" type="text" data-language="en" name="end_date" readonly
                                                 />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <a class="btn btn-secondary"
                                href="{{url('/feedback')}}">Cancel</a>
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
                        if (element.attr("name") == "start_date" ) {
                            error.insertAfter($("#datepicker-popup"));
                        }
                        else if (element.attr("name") == "end_date"){
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

                        instructor_id: {
                            required: true,
                            digits: true,
                            minlength: 0,
                            maxlength: 10,
                        },

                        start_date: {
                            required: true,
                        },

                        end_date: {
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

                        instructor_id: {
                            required: "Please select instructor",
                        },

                        start_date: {
                            required: "Please add start date",
                        },

                        end_date: {
                            required: "Please add enddate",
                            /* date:'Please enter correct formatted date' */
                        },


                    }



            });
        });
   
    </script>
    @endsection