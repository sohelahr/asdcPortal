@extends('layouts.guest')
@section('title')
    <title>Login</title>
@endsection
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            {{--<div class="brand-logo">
                                <img src="{{env('BACKEND_CDN_URL')}}/images/logo.svg" alt="logo">
                            </div>--}}
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="mt-3">
                                    <a href="{{url('/admin/dashboard')}}" class="btn btn-block btn-primary btn-lg font-weight-medium">Login</a>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        {{--<label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>--}}
                                    </div>
                                    <a href="javascript:void(0);" class="auth-link text-black">Forgot password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
