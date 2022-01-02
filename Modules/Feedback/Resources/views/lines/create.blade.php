<x-app-layout>
    <x-slot name="header" >
        <div class="page-header">
            <h5 class="font-semibold text-m text-gray-800 leading-tight">
                Give Feedback
            </h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Feedback Initialize</li>
                </ol>
            </nav>
        </div>
    </x-slot>
    <div id="overlay-loader" class="d-none">
        <div style="height: 100%;width:100%;background:rgba(121, 121, 121, 0.11);position: absolute;z-index:999;" class="d-flex justify-content-center align-items-center"> 
            <div> 
                <div class="dot-opacity-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>                
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('feedback_lines_create',[base64_encode($feedback_header->id)])}}" method="POST" enctype="multipart/form-data" id = "edit_profile">

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div id="admissions-by-batches-loader" class="d-none">
                        <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>    
                        </div>
                    </div>
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
                                                <input type="radio" class="form-check-input" name="qOne" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qOne" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qOne" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qOne" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qOne" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qTwo" value="5" id="excellent">
                                                100%
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwo" value="4" id="very-good">
                                                75%
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwo" value="3" id="good">
                                                50%
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwo" value="2" id="average">
                                                25%
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwo" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qThree" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThree" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThree" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThree" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThree" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qFour" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFour" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFour" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFour" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFour" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qFive" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFive" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFive" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFive" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFive" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qSix" value="1" id="excellent">
                                                Yes
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSix" value="2" id="very-good">
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
                                                <input type="radio" class="form-check-input" name="qSeven" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeven" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeven" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeven" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeven" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qEight" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEight" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEight" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEight" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEight" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qNine" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNine" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNine" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNine" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNine" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qTen" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTen" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTen" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTen" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTen" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qEleven" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEleven" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEleven" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEleven" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEleven" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qTwelve" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwelve" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwelve" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwelve" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwelve" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qThirteen" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThirteen" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThirteen" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThirteen" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qThirteen" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qFourteen" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFourteen" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFourteen" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFourteen" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFourteen" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qFifteen" value="5" id="excellent">
                                                Never
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFifteen" value="4" id="very-good">
                                                Some times
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFifteen" value="3" id="good">
                                                often
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qFifteen" value="2" id="average">
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
                                                <input type="radio" class="form-check-input" name="qSixteen" value="5" id="excellent">
                                                Never
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSixteen" value="4" id="very-good">
                                                Some times
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSixteen" value="3" id="good">
                                                often
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSixteen" value="2" id="average">
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
                                                <input type="radio" class="form-check-input" name="qSeventeen" value="5" id="excellent">
                                                Never
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeventeen" value="4" id="very-good">
                                                Some times
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeventeen" value="3" id="good">
                                                often
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qSeventeen" value="2" id="average">
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
                                                <input type="radio" class="form-check-input" name="qEighteen" value="5" id="excellent">
                                                Never
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEighteen" value="4" id="very-good">
                                                Some times
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEighteen" value="3" id="good">
                                                often
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qEighteen" value="2" id="average">
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
                                                <input type="radio" class="form-check-input" name="qNineteen" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNineteen" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNineteen" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNineteen" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qNineteen" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qTwenty" value="5" id="excellent">
                                                Excellent
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwenty" value="4" id="very-good">
                                                Very good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwenty" value="3" id="good">
                                                Good
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwenty" value="2" id="average">
                                                Average
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwenty" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="10" id="excellent">
                                                10
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="9" id="very-good">
                                                9
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="8" id="good">
                                                8
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="7" id="average">
                                                7
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="6" id="poor">
                                                6
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-primary">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="5" id="excellent">
                                                5
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="4" id="very-good">
                                                4
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="3" id="good">
                                                3
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="2" id="average">
                                                2
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-danger">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyOne" value="1" id="poor">
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
                                                <input type="radio" class="form-check-input" name="qTwentyTwo" value="5" id="excellent">
                                                Yes
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyTwo" value="4" id="very-good">
                                                No
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyTwo" value="3" id="good">
                                                Maybe
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyTwo" value="2" id="average">
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
                                                <input type="radio" class="form-check-input" name="qTwentyThree" value="5" id="excellent">
                                                Yes
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyThree" value="4" id="very-good">
                                                No
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyThree" value="3" id="good">
                                                Maybe
                                                <i class="input-helper"></i></label>
                                            </div>
                                            <div class="form-check form-check-warning">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="qTwentyThree" value="2" id="average">
                                                Not Sure
                                                <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="form-label">Feedback in your own words <sup class="text-danger">*</sup></h5>
                                        <textarea id="location" class="form-control" name="feedback" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <a class="btn btn-light" href="{{url('/dashboard')}}">Cancel</a>
                    </div>
                </div> 
            </form>

                </div>
            </div>
        </div>
        
    </div>
    {{-- <div class="page-header">
        <h3 class="page-title">
            Feedback Initialize
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Feedback Initialize</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div id="admissions-by-batches-loader" class="d-none">
                    <div  class="d-flex justify-content-center align-items-center show-loader">                                 
                        <div class="bar-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>    
                    </div>
                </div>
        <div class="card-body">
            
            
        </div>
    </div> --}}
@section('jcontent')
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

                    instructor_id: {
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

                    instructor_id: {
                        required: "Please select instructor",
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
</x-app-layout>