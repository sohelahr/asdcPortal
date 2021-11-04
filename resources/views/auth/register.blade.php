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
                            @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{session('error')}}
                                </div>
                            @endif
                            {{--<div class="brand-logo">
                                <img src="{{env('BACKEND_CDN_URL')}}/images/logo.svg" alt="logo">
                            </div>--}}
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign up to continue.</h6>
                            <x-auth-validation-errors class="mb-4 text-warning" :errors="$errors"/>
                            <form class="pt-3" action="{{route('register')}}" method="POST" id="register">
                                @csrf
                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" id="firstname"
                                                   placeholder="First Name" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" id="lastname"
                                                   placeholder="Last Name" name="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-sm" id="email"
                                           placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-sm" id="password"
                                           placeholder="Password" name="password">
                                </div>
                                <div class="form-group">
                                    <input id="password_confirmation" class="form-control form-control-sm"
                                           type="password"
                                           name="password_confirmation" required placeholder="Confirm Password"/>
                                </div>
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium"
                                           value="Register">
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
        $(document).ready(function () {
            $('#register').validate({
                errorClass: "text-danger pt-1",
                rules: {
                    first_name: {
                        required: true,
                    },

                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true,
                    },

                    password_confirmation: {
                        required: true,
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter your name",
                    },
                    last_name: {
                        required: "Please enter your name",
                    },

                    email: {
                        required: "Please enter your email id",
                    },

                    password: {
                        required: "Please enter a password",
                    },

                    password_confirmation: {
                        required: "Please re-enter your password",
                    },
                }

            });
        });
    </script>
@endsection


