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
                                        <a class="btn btn-primary" href="javascript:void(0);">2</a>
                                    </div>
                                    <div class="stepwizard-step">
                                        <a class="btn btn-light" href="javascript:void(0);">3</a>
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
                            <form action="{{route('feedback_lines_create',[base64_encode($feedback_header->id),'two'])}}" method="POST" enctype="multipart/form-data" id = "edit_profile">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="course_id" value="{{$course->id}}">
                                        <input type="hidden" name="coursebatch_id" value="{{$batch->id}}">
                                        <input type="hidden" name="line_id" value="{{$line ? $line->id : 0}}">
                                        {{-- Radios and Questions --}}
                                        <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                How would you rate your trainer's expertise?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qNine">
                                                            <option value="1" {{isset($line) ? ($line->qNine == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qNine == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qNine == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qNine == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qNine == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                How would you rate your trainer's empathy?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                     <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qTen">
                                                            <option value="1" {{isset($line) ? ($line->qTen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qTen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qTen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qTen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qTen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                How would you rate this course overall?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                     <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qEleven">
                                                            <option value="1" {{isset($line) ? ($line->qEleven == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qEleven == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qEleven == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qEleven == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qEleven == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                The number of efforts that Asdc volunteers put into helping slow learners<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qTwelve">
                                                            <option value="1" {{isset($line) ? ($line->qTwelve == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qTwelve == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qTwelve == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qTwelve == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qTwelve == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Are you comfortable with the level of quality education at ASDC?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qThirteen">
                                                            <option value="1" {{isset($line) ? ($line->qThirteen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qThirteen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qThirteen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qThirteen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qThirteen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Does the trainer encourage the students to recall what they have learned in the previous session?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-reversed" name="qFourteen">
                                                            <option value="1" {{isset($line) ? ($line->qFourteen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                                            <option value="2" {{isset($line) ? ($line->qFourteen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                                            <option value="3" {{isset($line) ? ($line->qFourteen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                                            <option value="4" {{isset($line) ? ($line->qFourteen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                                            <option value="5" {{isset($line) ? ($line->qFourteen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Does the trainer conduct exercise and activities in the class?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-movie" name="qFifteen" autocomplete="off">
                                                            <option value="5" {{isset($line) ? ($line->qFifteen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                                            <option value="4" {{isset($line) ? ($line->qFifteen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                                            <option value="3" {{isset($line) ? ($line->qFifteen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                                            <option value="2" {{isset($line) ? ($line->qFifteen == "2" ? 'selected' : '' ) : '' }}>Always</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label text-body">
                                                Do the trainer provides appropriate examples during the explanation?<sup class="text-danger">*</sup></label>
                                                <div class="checkboxes">
                                                    <div class="rating-container">
                                                        <select class="u-rating-movie" name="qSixteen" autocomplete="off">
                                                            <option value="5" {{isset($line) ? ($line->qSixteen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                                            <option value="4" {{isset($line) ? ($line->qSixteen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                                            <option value="3" {{isset($line) ? ($line->qSixteen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                                            <option value="2" {{isset($line) ? ($line->qSixteen == "2" ? 'selected' : '' ) : '' }}>Always</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <a href="{{route('feedback_lines_create',[base64_encode($feedback_header->id),'one'])}}"><button class="btn btn-secondary btn-previous" type="button">Previous</button></a>
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

                    qNine: {
                        required: true,
                    },

                    qTen: {
                        required: true,
                    },

                    qEleven: {
                        required: true,
                    },

                    qTwelve: {
                        required: true,
                    },
                    
                    qThirteen: {
                        required: true,
                    },

                    qFourteen: {
                        required: true,
                    },

                    qFifteen: {
                        required: true,
                    },

                    qSixteen: {
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
                   

                    qNine: {
                        required: "Please choose an option",
                    },

                    qTen: {
                        required: "Please choose an option",
                    },

                    qEleven: {
                        required: "Please choose an option",
                    },

                    qTwelve: {
                        required: "Please choose an option",
                    },
                    
                    qThirteen: {
                        required: "Please choose an option",
                    },

                    qFourteen: {
                        required: "Please choose an option",
                    },

                    qFifteen: {
                        required: "Please choose an option",
                    },

                    qSixteen: {
                        required: "Please choose an option",
                    },

                    
                }



        });
    });

</script>
@endsection