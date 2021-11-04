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

                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form class="pt-3"  action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-sm" id="email" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" name="password">
                                    <div id="pwd_visibility" class="hide">
                                        <i class="far fa-eye"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium" value="Login">
                                </div> 
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        {{--<label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>--}}
                                    </div>
                                    <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot password?</a>
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
    <script>
         @if(\Illuminate\Support\Facades\Session::has('already_verfied'))    
                $.toast({
                    heading: 'Email Already Verified',
                    text: 'Email already verified please Login to continue',
                    position:'top-right',
                    icon: 'info',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @elseif(\Illuminate\Support\Facades\Session::has('email_verfied'))
                $.toast({
                    heading: 'Email Verfied',
                    text: 'Email verfied successfully please login to continue',
                    position:'top-right',
                    icon: 'success',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @elseif(\Illuminate\Support\Facades\Session::has('verify_email'))
                $.toast({
                    heading: 'Account Created',
                    text: 'Account created successfully, please verify your email (Check your mail) to continue',
                    position:'top-right',
                    icon: 'success',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @elseif(\Illuminate\Support\Facades\Session::has('verify_email_first'))
            $.toast({
                heading: 'Account Created',
                text: 'Please verify your email first',
                position:'top-right',
                icon: 'warning',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
            
            @elseif(\Illuminate\Support\Facades\Session::has('error'))
                $.toast({
                    heading: 'Danger',
                    text: 'Something went wrong ',
                    position:'top-right',
                    icon: 'danger',
                    loader: true,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                })
            @endif
    </script>
@endsection
