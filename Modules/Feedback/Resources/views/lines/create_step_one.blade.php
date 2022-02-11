@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{env('BACKEND_CDN_URL')}}/css/rating.css">
@endpush
@section('content')
    <div id="overlay-loader" class="d-none">
        <div style="height:100%;position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
            <div class="loader-box"> 
                <div class="loader-7">
                </div>                
            </div>
        </div>
    </div>

	<div class="container-fluid">
	    <div class="edit-profile">
	        <div class="row">
	            <div class="col-12">
	                <div class="card">
                        <div class="default-according style-1 faq-accordion job-accordion">
                            <div class="card-header bg-primary ps-3 ms-0">
                                <h5 class="mb-0 ps-0 ms-0">
                                    <button style="font-size: 16px;" class="btn btn-link text-white ps-0 ms-0" data-bs-toggle="collapse" data-bs-target="#collapseicon2" aria-expanded="true" aria-controls="collapseicon2">
                                        Feedback For : {{$course->name}}
                                    </button>
                                </h5>
                            </div>
                            <div class="collapse show" id="collapseicon2" aria-labelledby="collapseicon2" data-parent="#accordion">
                                <div class="card-body post-about pb-1">
                                    <div class="row align-items-start justify-content-between">
                                        <div class="col-6 col-md-3">
                                            <b>Batch :</b> <br>{{$batch->batch_identifier}}
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <b>Instructor :</b><br> {{$instructor->firstname." ".$instructor->lastname}}
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <b>Start Date :</b> <br>{{date('d M Y',strtotime($feedback_header->start_date))}}
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <b>End Date :</b><br> {{date('d M Y',strtotime($feedback_header->end_date))}}
                                        </div>                           
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- <div class="stepwizard">
                                <div class="stepwizard-row setup-panel">
                                    <div class="stepwizard-step"><a class="btn btn-primary" href="javascript:void(0);">1</a>
                                        
                                    </div>
                                    <div class="stepwizard-step"><a class="btn btn-light" href="javascript:void(0);">2</a>
                                        
                                    </div>
                                    <div class="stepwizard-step"><a class="btn btn-light" href="javascript:void(0);">3</a>
                                        
                                    </div>
                                </div>
                            </div> --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{route('feedback_lines_create',[base64_encode($feedback_header->id),'one'])}}" method="POST" enctype="multipart/form-data" id = "edit_profile">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
                                        <input type="hidden" name="coursebatch_id" value="{{$batch->id}}">
                                        <input type="hidden" name="line_id" value="{{$line ? $line->id : 0}}">
                                        {{-- Radios and Questions --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">How well has your time been utilized here?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qOne">
                                                            <option value="1" {{isset($line) ? ($line->qOne == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qOne == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qOne == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qOne == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qOne == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                            How much is this course helpful for you?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-square" name="qTwo" autocomplete="off">
                                                            <option {{isset($line) ? ($line->qTwo == "1" ? 'selected' : '' ) : '' }} value="1">0%</option>
                                                            <option {{isset($line) ? ($line->qTwo == "2" ? 'selected' : '' ) : '' }} value="2">25%</option>
                                                            <option {{isset($line) ? ($line->qTwo == "3" ? 'selected' : '' ) : '' }} value="3">50%</option>
                                                            <option {{isset($line) ? ($line->qTwo == "4" ? 'selected' : '' ) : '' }} value="4">75%</option>
                                                            <option {{isset($line) ? ($line->qTwo == "5" ? 'selected' : '' ) : '' }} value="5">100%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                            How was the quality of the content, graded upon relevance to the course?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qThree">
                                                            <option value="1" {{isset($line) ? ($line->qThree == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qThree == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qThree == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qThree == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qThree == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                        Is the language used by trainer easy to understand?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qFour">
                                                            <option value="1" {{isset($line) ? ($line->qFour == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qFour == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qFour == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qFour == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qFour == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                        How would you rate your trainer's preparation for the class every time?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qFive">
                                                            <option value="1" {{isset($line) ? ($line->qFive == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qFive == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qFive == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qFive == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qFive == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                        Was the trainer available for consultation outside the class as well?<sup class="text-danger">*</sup></label>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="radio radio-primary">
                                                            <input type="radio" name="qSix" {{isset($line) ? ($line->qSix == "1" ? 'checked' : '' ) : '' }} value="1" id="qSixexcellent">
                                                            <label for="qSixexcellent">Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="radio radio-danger">
                                                            <input type="radio" name="qSix" {{isset($line) ? ($line->qSix == "2" ? 'checked' : '' ) : '' }} value="2" id="qSixvery-good">
                                                            <label for="qSixvery-good">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                    Are you satisfied with the information the trainer covers during the course?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qSeven">
                                                            <option value="1" {{isset($line) ? ($line->qSeven == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qSeven == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qSeven == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qSeven == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qSeven == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                How would you rate the trainer's overall teaching effectiveness?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qEight">
                                                            <option value="1" {{isset($line) ? ($line->qEight == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qEight == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qEight == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qEight == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qEight == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <a href="{{url('feedback/student/feedbacks')}}"><button class="btn btn-secondary btn-previous" type="button">Close</button></a>
                                        <button class="btn btn-primary btn-next" type="submit">Save & Next</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
    @endsection
@section('jcontent')

<script src="{{env('BACKEND_CDN_URL')}}/js/rating/jquery.barrating.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/rating/rating-script.js"></script>
<script>
        $(document).ready(function (){
        $('#edit_profile').validate({
            errorClass: "text-danger pt-1",
            errorPlacement: function(error, element) {
                    if (element.attr("type") == "radio") {
                        error.insertAfter($(element).parent().parent().parent());
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

                    qOne: {
                        required: true,
                    },

                    qTwo: {
                        required: true,
                    },

                    qThree: {
                        required: true,
                    },

                    qFour: {
                        required: true,
                    },

                    qFive: {
                        required: true,
                    },

                    qSix: {
                        required: true,
                    },

                    
                    qSeven: {
                        required: true,
                    },

                    qEight: {
                        required: true,
                    },

                },

                messages: {
                    course_id: {
                        required: "Please choose course",
                    },

                    coursebatch_id: {
                        required: "Please choose batch",
                    },                    
                    qOne: {
                        required: "Please choose an option",
                    },

                    qTwo: {
                        required: "Please choose an option",
                    },

                    qThree: {
                        required: "Please choose an option",
                    },

                    qFour: {
                        required: "Please choose an option",
                    },

                    qFive: {
                        required: "Please choose an option",
                    },

                    qSix: {
                        required: "Please choose an option",
                    },

                    
                    qSeven: {
                        required: "Please choose an option",
                    },

                    qEight: {
                        required: "Please choose an option",
                    },
                }



        });
    });

</script>
@endsection