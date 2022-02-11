@extends('layouts.admin.app')

@section('content')
    @component('layouts.viho.components.breadcrumb')
		@slot('breadcrumb_title')
			<h3>Instructors</h3>
		@endslot
            <li class="breadcrumb-item"><a href="{{url('/instructor')}}">Instructors</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$instructor->firstname." ".$instructor->lastname}}</li>
	@endcomponent
    <div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-12">
                <div class="card">
                    <div class="row">
                        <div class="col-12">    
                                <div class="card-body">{{-- 
                                    @if(\App\Http\Helpers\CheckPermission::hasPermission('update.instructors')) --}}
                                    <div class="float-right" style="margin-top: -10px">
                                        <a href="{{url('instructor/'.$instructor->id.'/update/')}}" class="text-dark">
                                            <i class='fas fa-pencil-alt'></i>
                                        </a>
                                    </div>{{-- 
                                    @endif --}}
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4">
                                                <div class=" text-center pb-4">
                                                    @if($instructor->photo)
                                                        <img src="{{asset('storage/app/instructor_photos/'.$instructor->photo)}}" alt="instructor"
                                                                class="img-sm rounded-circle mb-3" height="200" width="200">
                                                    @else
                                                        <img src = "{{asset('/storage/app/instructor_photos/blankimage.png')}}" alt = "" height="200" width="200" class="img-sm rounded-circle mb-3">
                                                    @endif
                                                        
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 pl-lg-5">
                                            
                                                <div class=" justify-content-between">
                                                    <div>
                                                        <h4 class="txt-primary">{{$instructor->firstname}} {{$instructor->lastname}}</h4>
                                                    {{--  <div class="d-flex align-items-center">
                                                            <h5 class="mb-0 mr-2 text-muted text-capitalize">{{$instructor->gender}}
                                                                ({{$instructor->age}})</h5>
                                                        </div> --}}
                                                        <div class="profile-feed">
                                                            <div class="border-bottom py-1">
                                                                <label class="form-label text-dark">Designation : <span class="text-secondary">{{$instructor->designation}}</span></label>
                                                            </div>
                                                            <div class="border-bottom py-1">
                                                                <label class="form-label text-dark">Course : <span class="text-secondary">{{$instructor->Course->name}}</span></label>
                                                            </div>

                                                            <div class="border-bottom py-1">
                                                                <label class="form-label text-dark">Mobile : <span class="text-secondary">{{$instructor->phone}}</span></label>
                                                            </div>
                                                            <div class="border-bottom py-1">
                                                                <label class="form-label text-dark">Email : <span class="text-secondary"> {{$instructor->email}}</span></label>
                                                            </div>
                                                            <div class="border-bottom py-1">
                                                                <label class="form-label text-dark">Address : <span class="text-secondary">{{$instructor->address}}</span></label>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
