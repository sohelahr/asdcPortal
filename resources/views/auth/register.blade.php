@extends('layouts.guest')
@section('title')
    <title>Register</title>
@endsection
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <!-- Validation Errors -->
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            {{--<div class="brand-logo">
                                <img src="{{env('BACKEND_CDN_URL')}}/images/logo.svg" alt="logo">
                            </div>--}}
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign up to continue.</h6>
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form class="pt-3"  action="{{route('register')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" id="email" placeholder="Full Name" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-sm" id="email" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" name="password">
                                </div>
                                <div class="form-group">
                                    <input id="password_confirmation" class="form-control form-control-sm"
                                                    type="password"
                                                    name="password_confirmation" required  placeholder="Confirm Password"/>
                                </div>
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium" value="Register">
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
