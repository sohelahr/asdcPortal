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
                                    <div class="stepwizard-step">
                                        <a class="btn btn-light" href="javascript:void(0);">1</a>
                                    </div>
                                    <div class="stepwizard-step">
                                        <a class="btn btn-light" href="javascript:void(0);">2</a>
                                    </div>
                                    <div class="stepwizard-step">
                                        <a class="btn btn-primary" href="javascript:void(0);">3</a>
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
                            <form action="{{route('feedback_lines_create',[base64_encode($feedback_header->id),'three'])}}" method="POST" enctype="multipart/form-data" id = "edit_profile">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
                                        <input type="hidden" name="coursebatch_id" value="{{$batch->id}}">
                                        <input type="hidden" name="line_id" value="{{$line ? $line->id : 0}}">
                                        {{-- Radios and Questions --}}

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                When I fail to understand the topic the trainer notices me and repeats the topic<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-movie" name="qSeventeen" autocomplete="off">
                                                            <option value="5" {{isset($line) ? ($line->qSeventeen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                                            <option value="4" {{isset($line) ? ($line->qSeventeen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                                            <option value="3" {{isset($line) ? ($line->qSeventeen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                                            <option value="2" {{isset($line) ? ($line->qSeventeen == "2" ? 'selected' : '' ) : '' }}>Always</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Does the trainer checks, whether the students have understood the session?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-movie" name="qEighteen" autocomplete="off">
                                                            <option value="5" {{isset($line) ? ($line->qEighteen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                                            <option value="4" {{isset($line) ? ($line->qEighteen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                                            <option value="3" {{isset($line) ? ($line->qEighteen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                                            <option value="2" {{isset($line) ? ($line->qEighteen == "2" ? 'selected' : '' ) : '' }}>Always</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Administration staff behaviour?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qNineteen">
                                                            <option value="1" {{isset($line) ? ($line->qNineteen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qNineteen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qNineteen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qNineteen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qNineteen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Do you find hygiene and cleanliness maintained at ASDC?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qTwenty">
                                                            <option value="1" {{isset($line) ? ($line->qTwenty == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qTwenty == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qTwenty == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qTwenty == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qTwenty == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                How will you rate your overall experience of learning at ASDC?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="star-ratings">
                                                        <div class="stars stars-example-fontawesome-o">
                                                            <select class="u-rating-fontawesome-o" name="qTwentyOne" autocomplete="off">
                                                                <option value="1" {{isset($line) ? ($line->qTwentyOne == "1" ? 'selected' : '' ) : '' }}>1</option>
                                                                <option value="2" {{isset($line) ? ($line->qTwentyOne == "2" ? 'selected' : '' ) : '' }}>2</option>
                                                                <option value="3" {{isset($line) ? ($line->qTwentyOne == "3" ? 'selected' : '' ) : '' }}>3</option>
                                                                <option value="4" {{isset($line) ? ($line->qTwentyOne == "4" ? 'selected' : '' ) : '' }}>4</option>
                                                                <option value="5" {{isset($line) ? ($line->qTwentyOne == "5" ? 'selected' : '' ) : '' }}>5</option>
                                                                <option value="6" {{isset($line) ? ($line->qTwentyOne == "6" ? 'selected' : '' ) : '' }}>6</option>
                                                                <option value="7" {{isset($line) ? ($line->qTwentyOne == "7" ? 'selected' : '' ) : '' }}>7</option>
                                                                <option value="8" {{isset($line) ? ($line->qTwentyOne == "8" ? 'selected' : '' ) : '' }}>8</option>
                                                                <option value="9" {{isset($line) ? ($line->qTwentyOne == "9" ? 'selected' : '' ) : '' }}>9</option>
                                                                <option value="10" {{isset($line) ? ($line->qTwentyOne == "10" ? 'selected' : '' ) : '' }}>10</option>
                                                            </select>
                                                            <span class="title current-rating">Current rating: {{isset($line) ? $line->qTwentyOne : ''}} </span>
                                                            <span class="title your-rating hidden">
                                                                Your rating: <span class="value digits"></span> <a class="clear-rating" href="javascript:void(0)"><i class="fa fa-times-circle"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Do you recommend ASDC to your friends and relatives?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-movie" name="qTwentyTwo" autocomplete="off">
                                                            <option value="5" {{isset($line) ? ($line->qTwentyTwo == "5" ? 'selected' : '' ) : '' }}>Yes</option>
                                                            <option value="4" {{isset($line) ? ($line->qTwentyTwo == "4" ? 'selected' : '' ) : '' }}>No</option>
                                                            <option value="3" {{isset($line) ? ($line->qTwentyTwo == "3" ? 'selected' : '' ) : '' }}>Maybe</option>
                                                            <option value="2" {{isset($line) ? ($line->qTwentyTwo == "2" ? 'selected' : '' ) : '' }}>Not Sure</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Join us as a Volunteer<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-movie" name="qTwentyThree" autocomplete="off">
                                                            <option value="5" {{isset($line) ? ($line->qTwentyThree == "5" ? 'selected' : '' ) : '' }}>Yes</option>
                                                            <option value="4" {{isset($line) ? ($line->qTwentyThree == "4" ? 'selected' : '' ) : '' }}>No</option>
                                                            <option value="3" {{isset($line) ? ($line->qTwentyThree == "3" ? 'selected' : '' ) : '' }}>Maybe</option>
                                                            <option value="2" {{isset($line) ? ($line->qTwentyThree == "2" ? 'selected' : '' ) : '' }}>Not Sure</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">Feedback in your own words<sup class="text-danger">*</sup></label>
                                                <textarea id="location" class="form-control" name="feedback" rows="10">{{isset($line) ? ($line->feedback) : ''}}</textarea>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                <div class="f1-buttons">
                                    <a href="{{route('feedback_lines_create',[base64_encode($feedback_header->id),'two'])}}"><button class="btn btn-secondary btn-previous" type="button">Previous</button></a>
                                    <button class="btn btn-primary btn-next" type="submit">Save & Submit</button>
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



                    qSeventeen: {
                        required: true,
                    },

                    qEighteen: {
                        required: true,
                    },

                    
                    qNineteen: {
                        required: true,
                    },

                    qTwenty: {
                        required: true,
                    },

                    qTwentyOne: {
                        required: true,
                    },

                    qTwentyTwo: {
                        required: true,
                    },

                    qTwentyThree: {
                        required: true,
                    },

                    feedback: {
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
                   
                    qSeventeen: {
                        required: "Please choose an option",
                    },

                    qEighteen: {
                        required: "Please choose an option",
                    },

                    
                    qNineteen: {
                        required: "Please choose an option",
                    },

                    qTwenty: {
                        required: "Please choose an option",
                    },

                    qTwentyOne: {
                        required: "Please choose an option",
                    },

                    qTwentyTwo: {
                        required: "Please choose an option",
                    },

                    qTwentyThree: {
                        required: "Please choose an option",
                    },

                    feedback: {
                        required: "Enter Your Feedback",
                    },
                }



        });
    });

</script>
@endsection