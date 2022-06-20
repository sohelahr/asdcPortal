@extends('layouts.admin.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{env('BACKEND_CDN_URL')}}/css/rating.css">
@endpush
@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>{{$student_name}}'s Feedback</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/feedback')}}">Feedbacks</a></li>
            <li class="breadcrumb-item"><a href="{{url('/feedback/lines/'.$feedback_header->id)}}">Feedback Line</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback</li>
    @endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="d-flex p-1 m-0 border header-buttons">
                    <div>
                        <button class="btn bg-white" type="button" >
                            Course : {{$course->name}}
                        </button>
                    </div>
                    <div>
                        <button class="btn bg-white" type="button" >
                            Batch : {{$batch->batch_identifier}}
                        </button>
                    </div>
                    <div>
                        <button class="btn bg-white" type="button" >
                            Instructor : {{$instructor->firstname." ".$instructor->lastname}}
                        </button>
                    </div>
                    <div>
                        <button class="btn bg-white" type="button" >
                            Start Date : {{$feedback_header->start_date}}
                        </button>
                    </div>
                    
                    <div>
                        <button class="btn bg-white" type="button" >
                            End Date : {{$feedback_header->end_date}}
                        </button>
                    </div>
                    <div>
                        <button class="btn bg-white" type="button" >
                            Status : {{($feedback_header->status == '0' ? 'Initialized' : ($feedback_header->status == '1' ? 'Active' : 'Expired')) }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-body">How well has your time been utilized here?<sup class="text-danger">*</sup></label>
                                <div class="checkboxes">
                                    <div class="rating-container">
                                        <select disabled class="u-rating-reversed" name="qOne">
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qOne == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qOne == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qOne == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qOne == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qOne == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option {{isset($feedback_line) ? ($feedback_line->qTwo == "1" ? 'selected' : '' ) : '' }} value="1">0%</option>
                                            <option {{isset($feedback_line) ? ($feedback_line->qTwo == "2" ? 'selected' : '' ) : '' }} value="2">25%</option>
                                            <option {{isset($feedback_line) ? ($feedback_line->qTwo == "3" ? 'selected' : '' ) : '' }} value="3">50%</option>
                                            <option {{isset($feedback_line) ? ($feedback_line->qTwo == "4" ? 'selected' : '' ) : '' }} value="4">75%</option>
                                            <option {{isset($feedback_line) ? ($feedback_line->qTwo == "5" ? 'selected' : '' ) : '' }} value="5">100%</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qThree == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qThree == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qThree == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qThree == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qThree == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qFour == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qFour == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qFour == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qFour == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qFour == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qFive == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qFive == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qFive == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qFive == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qFive == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                        <div class="radio radio-primary disabled">
                                            <input type="radio" readonly name="qSix" {{isset($feedback_line) ? ($feedback_line->qSix == "1" ? 'checked' : '' ) : '' }} value="1" id="qSixexcellent">
                                            <label for="qSixexcellent">Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="radio radio-danger disabled">
                                            <input type="radio" readonly name="qSix" {{isset($feedback_line) ? ($feedback_line->qSix == "2" ? 'checked' : '' ) : '' }} value="2" id="qSixvery-good">
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qSeven == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qSeven == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qSeven == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qSeven == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qSeven == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qEight == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qEight == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qEight == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qEight == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qEight == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label class="form-label text-body">
                                How would you rate your trainer's expertise?<sup class="text-danger">*</sup></label>
                                <div class="checkboxes">
                                    <div class="rating-container">
                                        <select class="u-rating-reversed" name="qNine">
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qNine == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qNine == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qNine == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qNine == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qNine == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qTen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qTen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qTen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qTen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qTen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qEleven == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qEleven == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qEleven == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qEleven == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qEleven == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qTwelve == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qTwelve == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qTwelve == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qTwelve == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qTwelve == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qThirteen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qThirteen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qThirteen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qThirteen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qThirteen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qFourteen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qFourteen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qFourteen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qFourteen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qFourteen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qFifteen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qFifteen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qFifteen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qFifteen == "2" ? 'selected' : '' ) : '' }}>Always</option>
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
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qSixteen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qSixteen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qSixteen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qSixteen == "2" ? 'selected' : '' ) : '' }}>Always</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-body">
                                When I fail to understand the topic the trainer notices me and repeats the topic<sup class="text-danger">*</sup></label>
                                <div class="checkboxes">
                                    <div class="rating-container">
                                        <select class="u-rating-movie" name="qSeventeen" autocomplete="off">
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qSeventeen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qSeventeen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qSeventeen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qSeventeen == "2" ? 'selected' : '' ) : '' }}>Always</option>
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
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qEighteen == "5" ? 'selected' : '' ) : '' }}>Never</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qEighteen == "4" ? 'selected' : '' ) : '' }}>Sometimes</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qEighteen == "3" ? 'selected' : '' ) : '' }}>Often</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qEighteen == "2" ? 'selected' : '' ) : '' }}>Always</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qNineteen == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qNineteen == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qNineteen == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qNineteen == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qNineteen == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                            <option value="1" {{isset($feedback_line) ? ($feedback_line->qTwenty == "1" ? 'selected' : '' ) : '' }}>Poor</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qTwenty == "2" ? 'selected' : '' ) : '' }}>Average</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qTwenty == "3" ? 'selected' : '' ) : '' }}>Good</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qTwenty == "4" ? 'selected' : '' ) : '' }}>Very Good</option>
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qTwenty == "5" ? 'selected' : '' ) : '' }}>Excellent</option>
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
                                                <option value="1" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "1" ? 'selected' : '' ) : '' }}>1</option>
                                                <option value="2" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "2" ? 'selected' : '' ) : '' }}>2</option>
                                                <option value="3" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "3" ? 'selected' : '' ) : '' }}>3</option>
                                                <option value="4" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "4" ? 'selected' : '' ) : '' }}>4</option>
                                                <option value="5" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "5" ? 'selected' : '' ) : '' }}>5</option>
                                                <option value="6" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "6" ? 'selected' : '' ) : '' }}>6</option>
                                                <option value="7" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "7" ? 'selected' : '' ) : '' }}>7</option>
                                                <option value="8" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "8" ? 'selected' : '' ) : '' }}>8</option>
                                                <option value="9" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "9" ? 'selected' : '' ) : '' }}>9</option>
                                                <option value="10" {{isset($feedback_line) ? ($feedback_line->qTwentyOne == "10" ? 'selected' : '' ) : '' }}>10</option>
                                            </select>
                                            <span class="title current-rating">Current rating: {{isset($feedback_line) ? $feedback_line->qTwentyOne : ''}} </span>
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
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qTwentyTwo == "5" ? 'selected' : '' ) : '' }}>Yes</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qTwentyTwo == "4" ? 'selected' : '' ) : '' }}>No</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qTwentyTwo == "3" ? 'selected' : '' ) : '' }}>Maybe</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qTwentyTwo == "2" ? 'selected' : '' ) : '' }}>Not Sure</option>
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
                                            <option value="5" {{isset($feedback_line) ? ($feedback_line->qTwentyThree == "5" ? 'selected' : '' ) : '' }}>Yes</option>
                                            <option value="4" {{isset($feedback_line) ? ($feedback_line->qTwentyThree == "4" ? 'selected' : '' ) : '' }}>No</option>
                                            <option value="3" {{isset($feedback_line) ? ($feedback_line->qTwentyThree == "3" ? 'selected' : '' ) : '' }}>Maybe</option>
                                            <option value="2" {{isset($feedback_line) ? ($feedback_line->qTwentyThree == "2" ? 'selected' : '' ) : '' }}>Not Sure</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-body">Feedback in your own words<sup class="text-danger">*</sup></label>
                                <textarea id="location" class="form-control" name="feedback" readonly rows="10">{{isset($feedback_line) ? ($feedback_line->feedback) : ''}}</textarea>
                            </div>
                            <hr />
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
@endsection
@section('jcontent')

<script src="{{env('BACKEND_CDN_URL')}}/js/rating/jquery.barrating.js"></script>
<script src="{{env('BACKEND_CDN_URL')}}/js/rating/rating-script-disabled.js"></script>
@endsection
