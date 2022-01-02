@extends('layouts.admin.app')
@section('content')
<div class="page-header">
    <h3 class="page-title">
        {{$student_name}}'s Feedback
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('/feedback')}}">Feedbacks</a></li>
            <li class="breadcrumb-item"><a href="{{url('/feedback/lines/'.$feedback_header->id)}}">Feedback Line</a></li>
            <li class="breadcrumb-item active" aria-current="page">Feedback</li>
        </ol>
    </nav>
</div>
    <div class="card">
        <div class="row">
            <div class="col-12">    
                    <div class="card-body">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-5 bg-white border-b border-gray-200">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="course_id" value="{{$course->id}}">
                                                    <label class="form-label">Course <sup class="text-danger">*</sup></label>
                                                    <input id="course" class="form-control form-control-sm" name="course" readonly value="{{$course->name}}"> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="coursebatch_id" value="{{$batch->id}}">
                                                    <label class="form-label">Batch<sup class="text-danger">*</sup></label>
                                                    <input id="coursebatch" class="form-control form-control-sm" name="coursebatch" readonly value="{{$batch->batch_identifier}}" >
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Instructor <sup class="text-danger">*</sup></label>
                                                    <input id="instructor" class="form-control form-control-sm" name="instructor" readonly value="{{$instructor->firstname." ".$instructor->lastname}}">
                                                </div>
                                            </div>
                                            {{-- Radios and Questions --}}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">How well has your time been utilised here? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qOne == '5' ? 'checked' : null}} class="form-check-input" name="qOne" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled class="form-check-input" name="qOne" value="4" {{$feedback_line->qOne == '4' ? 'checked' : null}} id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled class="form-check-input" name="qOne" value="3" {{$feedback_line->qOne == '3' ? 'checked' : null}} id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled class="form-check-input" name="qOne" value="2" {{$feedback_line->qOne == '2' ? 'checked' : null}} id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled class="form-check-input" {{$feedback_line->qOne == '1' ? 'checked' : null}} name="qOne" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                                How much this course is helpful for you <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qTwo == '5' ? 'checked' : null}} class="form-check-input" name="qTwo" value="5" id="excellent">
                                                            100%
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qTwo == '4' ? 'checked' : null}} class="form-check-input" name="qTwo" value="4" id="very-good">
                                                            75%
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qTwo == '3' ? 'checked' : null}} class="form-check-input" name="qTwo" value="3" id="good">
                                                            50%
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qTwo == '2' ? 'checked' : null}} class="form-check-input" name="qTwo" value="2" id="average">
                                                            25%
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qTwo == '1' ? 'checked' : null}} class="form-check-input" name="qTwo" value="1" id="poor">
                                                            0%
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                                How was the quality of the content, grade upon relevance to the course?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qThree == '5' ? 'checked' : null}} class="form-check-input" name="qThree" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qThree == '4' ? 'checked' : null}}class="form-check-input" name="qThree" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qThree == '3' ? 'checked' : null}} class="form-check-input" name="qThree" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qThree == '2' ? 'checked' : null}} class="form-check-input" name="qThree" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qThree == '1' ? 'checked' : null}} class="form-check-input" name="qThree" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                            The language used by trainer easy to understand? ?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFour == '5' ? 'checked' : null}} class="form-check-input" name="qFour" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFour == '4' ? 'checked' : null}} class="form-check-input" name="qFour" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFour == '3' ? 'checked' : null}} class="form-check-input" name="qFour" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFour == '2' ? 'checked' : null}} class="form-check-input" name="qFour" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFour == '1' ? 'checked' : null}} class="form-check-input" name="qFour" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                            How would you rate your trainer’s preparation for the class every time ?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFive == '5' ? 'checked' : null}} class="form-check-input" name="qFive" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFive == '4' ? 'checked' : null}} class="form-check-input" name="qFive" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFive == '3' ? 'checked' : null}} class="form-check-input" name="qFive" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFive == '2' ? 'checked' : null}} class="form-check-input" name="qFive" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qFive == '1' ? 'checked' : null}} class="form-check-input" name="qFive" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                            Is The trainer was available for consultation outside the class as well ? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSix == '1' ? 'checked' : null}} name="qSix" value="1" id="excellent">
                                                            Yes
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSix == '2' ? 'checked' : null}} name="qSix" value="2" id="very-good">
                                                            No
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                        Are you satisfied with the information the trainer covers during the course?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeven == '5' ? 'checked' : null}} name="qSeven" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeven == '4' ? 'checked' : null}} name="qSeven" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeven == '3' ? 'checked' : null}} name="qSeven" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeven == '2' ? 'checked' : null}} name="qSeven" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeven == '1' ? 'checked' : null}} name="qSeven" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    How would you rate the trainer overall teaching effectiveness <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qEight == '5' ? 'checked' : null}}  class="form-check-input" name="qEight" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qEight == '4' ? 'checked' : null}} class="form-check-input" name="qEight" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qEight == '3' ? 'checked' : null}}  class="form-check-input" name="qEight" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qEight == '2' ? 'checked' : null}}  class="form-check-input" name="qEight" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qEight == '1' ? 'checked' : null}}  class="form-check-input" name="qEight" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    How would you rate your trainer’s expertise? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qNine == '5' ? 'checked' : null}} class="form-check-input" name="qNine" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qNine == '4' ? 'checked' : null}} class="form-check-input" name="qNine" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qNine == '3' ? 'checked' : null}}  class="form-check-input" name="qNine" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qNine == '2' ? 'checked' : null}}  class="form-check-input" name="qNine" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" disabled {{$feedback_line->qNine == '1' ? 'checked' : null}}  class="form-check-input" name="qNine" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    How would you rate your trainer’s empathy? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qTen == '5' ? 'checked' : null}} class="form-check-input" name="qTen" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qTen == '4' ? 'checked' : null}}  class="form-check-input" name="qTen" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qTen == '3' ? 'checked' : null}}  class="form-check-input" name="qTen" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qTen == '2' ? 'checked' : null}}  class="form-check-input" name="qTen" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qTen == '1' ? 'checked' : null}} class="form-check-input" name="qTen" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    How would you rate this course overall?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio"  disabled {{$feedback_line->qEleven == '5' ? 'checked' : null}}  class="form-check-input" name="qEleven" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qEleven == '4' ? 'checked' : null}}  name="qEleven" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qEleven == '3' ? 'checked' : null}}  name="qEleven" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qEleven == '2' ? 'checked' : null}}  name="qEleven" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qEleven == '1' ? 'checked' : null}}  name="qEleven" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    How ASDC staff voluntarily putting efforts for training students who are slow learners.<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwelve == '5' ? 'checked' : null}}  name="qTwelve" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwelve == '4' ? 'checked' : null}} name="qTwelve" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwelve == '3' ? 'checked' : null}}  name="qTwelve" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwelve == '2' ? 'checked' : null}}  name="qTwelve" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwelve == '1' ? 'checked' : null}}  name="qTwelve" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Are you comfortable with the level of quality education at ASDC? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qThirteen == '5' ? 'checked' : null}} name="qThirteen" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qThirteen == '4' ? 'checked' : null}}  name="qThirteen" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qThirteen == '3' ? 'checked' : null}}  name="qThirteen" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qThirteen == '2' ? 'checked' : null}}  name="qThirteen" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qThirteen == '1' ? 'checked' : null}}  name="qThirteen" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Does the trainer encourage the students to recall what they have learnt in the previous session? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qFourteen == '5' ? 'checked' : null}} name="qFourteen" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qFourteen == '4' ? 'checked' : null}}  name="qFourteen" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qFourteen == '3' ? 'checked' : null}}  name="qFourteen" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qFourteen == '2' ? 'checked' : null}}  name="qFourteen" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qFourteen == '1' ? 'checked' : null}}  name="qFourteen" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Does the trainer conducts exercise and Activities in the class? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qFifteen == '5' ? 'checked' : null}} name="qFifteen" value="5" id="excellent">
                                                            Never
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qFifteen == '4' ? 'checked' : null}}  name="qFifteen" value="4" id="very-good">
                                                            Some times
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qFifteen == '3' ? 'checked' : null}}  name="qFifteen" value="3" id="good">
                                                            often
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qFifteen == '2' ? 'checked' : null}}  name="qFifteen" value="2" id="average">
                                                            Always
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Do the trainer provides appropriate examples during explanation? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSixteen == '5' ? 'checked' : null}}  name="qSixteen" value="5" id="excellent">
                                                            Never
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSixteen == '4' ? 'checked' : null}}  name="qSixteen" value="4" id="very-good">
                                                            Some times
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSixteen == '3' ? 'checked' : null}}  name="qSixteen" value="3" id="good">
                                                            often
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSixteen == '2' ? 'checked' : null}}  name="qSixteen" value="2" id="average">
                                                            Always
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    When I fail to understand the topic the trainer notices me and repeats the topic <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeventeen == '5' ? 'checked' : null}}  name="qSeventeen" value="5" id="excellent">
                                                            Never
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeventeen == '4' ? 'checked' : null}}  name="qSeventeen" value="4" id="very-good">
                                                            Some times
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeventeen == '3' ? 'checked' : null}}  name="qSeventeen" value="3" id="good">
                                                            often
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qSeventeen == '2' ? 'checked' : null}}  name="qSeventeen" value="2" id="average">
                                                            Always
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Does the trainer checks, whether the students have understood the session? <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qEighteen == '5' ? 'checked' : null}}  name="qEighteen" value="5" id="excellent">
                                                            Never
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qEighteen == '4' ? 'checked' : null}}  name="qEighteen" value="4" id="very-good">
                                                            Some times
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qEighteen == '3' ? 'checked' : null}}  name="qEighteen" value="3" id="good">
                                                            often
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qEighteen == '2' ? 'checked' : null}}  name="qEighteen" value="2" id="average">
                                                            Always
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Administration Staff Behaviour<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qNineteen == '5' ? 'checked' : null}}  name="qNineteen" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qNineteen == '4' ? 'checked' : null}}  name="qNineteen" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qNineteen == '3' ? 'checked' : null}}  name="qNineteen" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qNineteen == '2' ? 'checked' : null}}  name="qNineteen" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="qNineteen"  disabled {{$feedback_line->qNineteen == '1' ? 'checked' : null}}  value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Do you find Hygiene and Cleanliness maintained at ASDC ?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwenty == '5' ? 'checked' : null}}  name="qTwenty" value="5" id="excellent">
                                                            Excellent
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwenty == '4' ? 'checked' : null}}  name="qTwenty" value="4" id="very-good">
                                                            Very good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwenty == '3' ? 'checked' : null}}  name="qTwenty" value="3" id="good">
                                                            Good
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwenty == '2' ? 'checked' : null}}  name="qTwenty" value="2" id="average">
                                                            Average
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwenty == '1' ? 'checked' : null}}  name="qTwenty" value="1" id="poor">
                                                            Poor
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    How do you rate your overall experience of learning at ASDC ?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyOne == '10' ? 'checked' : null}}  name="qTwentyOne" value="10" id="excellent">
                                                            10
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyOne == '9' ? 'checked' : null}}  name="qTwentyOne" value="9" id="very-good">
                                                            9
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyOne == '8' ? 'checked' : null}}  name="qTwentyOne" value="8" id="good">
                                                            8
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyOne == '7' ? 'checked' : null}}  name="qTwentyOne" value="7" id="average">
                                                            7
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyOne == '6' ? 'checked' : null}}  name="qTwentyOne" value="6" id="poor">
                                                            6
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyOne == '5' ? 'checked' : null}}  name="qTwentyOne" value="5" id="excellent">
                                                            5
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyOne == '4' ? 'checked' : null}} name="qTwentyOne" value="4" id="very-good">
                                                            4
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyOne == '3' ? 'checked' : null}} name="qTwentyOne" value="3" id="good">
                                                            3
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyOne == '2' ? 'checked' : null}} name="qTwentyOne" value="2" id="average">
                                                            2
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-danger">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyOne == '1' ? 'checked' : null}} name="qTwentyOne" value="1" id="poor">
                                                            1
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Do you recommend ASDC to your friends and relatives?<sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyTwo == '5' ? 'checked' : null}} name="qTwentyTwo" value="5" id="excellent">
                                                            Yes
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyTwo == '4' ? 'checked' : null}} name="qTwentyTwo" value="4" id="very-good">
                                                            No
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyTwo == '3' ? 'checked' : null}} name="qTwentyTwo" value="3" id="good">
                                                            Maybe
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyTwo == '2' ? 'checked' : null}} name="qTwentyTwo" value="2" id="average">
                                                            Not Sure
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">
                                                    Join us as a Volunteer <sup class="text-danger">*</sup></h5>
                                                    <div class="checkboxes">
                                                        <div class="form-check form-check-primary">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyThree == '5' ? 'checked' : null}} name="qTwentyThree" value="5" id="excellent">
                                                            Yes
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-success">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyThree == '4' ? 'checked' : null}}  name="qTwentyThree" value="4" id="very-good">
                                                            No
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-info">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"  disabled {{$feedback_line->qTwentyThree == '3' ? 'checked' : null}} name="qTwentyThree" value="3" id="good">
                                                            Maybe
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                        <div class="form-check form-check-warning">
                                                            <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" disabled {{$feedback_line->qTwentyThree == '2' ? 'checked' : null}} name="qTwentyThree" value="2" id="average">
                                                            Not Sure
                                                            <i class="input-helper"></i></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h5 class="form-label">Feedback in your own words <sup class="text-danger">*</sup></h5>
                                                    <textarea id="location" class="form-control" name="feedback" rows="10">{{$feedback_line->feedback}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div> 
                    </div>   
            </div>
        </div>
    </div>
@endsection
@section('jcontent')
@endsection
