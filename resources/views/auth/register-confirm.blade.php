@extends('layouts.guest')
@section('title')
    <title>Registration Confirmation</title>
@endsection
@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <!-- Validation Errors -->
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h5>Hello, {{$user->name}}</h5>
                                @if($user->is_verified == 1)
                                    <p>
                                        Thankyou for verifying your email, Please click on login
                                    </p>
                                    <div class="mt-2">
                                        <a href="{{url('/login')}}" class="btn btn-block btn-primary btn-sm font-weight-medium">Login</a>
                                    </div>
                                @else
                                    <p>
                                        We have sent you confirmation email, please check.
                                        If email not received click on resend email.
                                    </p>
                                    <div class="mt-2">
                                        <a href="{{url('/register/resend-verification-email/'.base64_encode($user->id))}}" onclick="showLoader(this);" class="btn btn-block btn-primary btn-sm font-weight-medium"><i style="font-size: 12px;" class="far fa-envelope"></i>&nbsp; Resend Verification Email</a>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jcontent')
    <script>

        $(function(){
            @if(\Illuminate\Support\Facades\Session::has('success'))
            $.toast({
                heading: 'Email Send',
                text: 'Verification email resend successfully.',
                position:'top-right',
                icon: 'info',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
            @elseif(\Illuminate\Support\Facades\Session::has('error'))
            $.toast({
                heading: 'Opps,',
                text: 'Something went wrong we are unable to send the email.',
                position:'top-right',
                icon: 'danger',
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600'  // To change the background
            })
            @endif
        });

        function showLoader(_this)
        {
            $(_this).children('i').removeClass('far fa-envelope').addClass('fa fa-spinner fa-pulse');
        }

    </script>

@endsection


