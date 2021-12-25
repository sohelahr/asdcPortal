@extends('layouts.admin.app')
@section('content')
<div class="page-header">
    <h3 class="page-title">
        Instructors
    </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Instructor View</li>
        </ol>
    </nav>
</div>
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
                                    <div class="border-bottom text-center pb-4">
                                        @if($instructor->photo)
                                            <img src="{{asset('storage/app/instructor_photos/'.$instructor->photo)}}" alt="instructor"
                                                    class="img-lg rounded-circle mb-3">
                                        @else
                                            <img src = "{{asset('/storage/app/instructor_photos/blankimage.png')}}" alt = "" class="img-lg rounded-circle mb-3">
                                        @endif
                                            
                                    </div>
                                    <div class="border-bottom pt-4 pb-2">
                                        <p class="clearfix">
                                            <span class="float-left">
                                                Mobile
                                            </span>
                                            <span class="float-right text-muted">
                                                {{$instructor->phone}}
                                            </span>
                                        </p>
                                        <p class="clearfix">
                                            <span class="float-left">
                                               Designation
                                            </span>
                                            <span class="float-right text-muted">
                                                {{$instructor->designation}}
                                            </span>
                                        </p>
                                    </div>
                                    <div class=" border-bottom py-4 mb-1">
                                        <p class="clearfix">
                                            <span class="float-left">
                                                Email
                                            </span>
                                            <span class="float-right text-muted">
                                                {{$instructor->email}}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 pl-lg-5">
                                
                                    <div class=" justify-content-between">
                                        <div>
                                            <h3>{{$instructor->firstname}} {{$instructor->lastname}}</h3>
                                           {{--  <div class="d-flex align-items-center">
                                                <h5 class="mb-0 mr-2 text-muted text-capitalize">{{$instructor->gender}}
                                                    ({{$instructor->age}})</h5>
                                            </div> --}}
                                            <div class="profile-feed">
                                                <div class="border-bottom py-4">
                                                    <p>Course</p>
                                                    <div>
                                                        <label class="badge badge-outline-dark">{{$instructor->Course->name}}</label>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start profile-feed-item">
                                                    <img src="{{url('/public/images/state_icon.png')}}" alt="profile"
                                                        height="50" width="50" class="rounded-circle">
                                                    <div class="ml-4">
                                                        <h5>
                                                            Address
                                                        </h5>
                                                        <p> {{$instructor->address}}</p>
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
