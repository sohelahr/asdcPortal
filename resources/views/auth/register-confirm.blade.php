@extends('layouts.guest')
@section('title')
    <title>Registration Confirmation</title>
@endsection
@section('content')
<section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">
                        <div class="theme-form login-form">
                            <h5 class="txt-primary text-center">Hello, {{$user->name}}</h5>
                                @if($user->is_verified == 1)
                                    <p>
                                        Thank you for verifying your email, Please click on login.
                                    </p>
                                    <div class="mt-2">
                                        <a href="{{url('/login')}}" class="btn btn-block btn-primary btn-sm font-weight-medium">Login</a>
                                    </div>
                                @else
                                    <p>
                                        We have sent you a confirmation email for <br>
                                        <b class="txt-primary">{{$user->email}}</b>,
                                        <br> please check your mailbox / spam folder.<br><br>
                                        It can take upto 5 minutes for email to be recieved<br> 
                                        <br>If you have still not received the email,<br>
                                        <b>There is a high chance the email entered is wrong</b>
                                        <br> please check your email or click below.
                                    </p>
                                    <div class="mt-2">
                                        @if($user->no_of_tries < 2)
                                            <a href="{{url('/register/resend-verification-email/'.base64_encode($user->id))}}" 
                                                onclick="showLoader(this);" 
                                                class="btn btn-block btn-primary btn-sm font-weight-medium">
                                                <i style="font-size: 12px;" class="fa fa-envelope"></i>
                                                &nbsp; Resend Verification Email</a>
                                        @else
                                                <a href="#" 
                                                class="btn btn-block btn-warning btn-sm font-weight-medium" style="color:black">
                                                Number of tries exceeded,<br>Please Contact Admin Centre</a>
                                        @endif
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('jcontent')
    <script>
        let url = "{{url('/register/resend-verification-email/'.base64_encode($user->id))}}";
        $(function(){
            @if(\Illuminate\Support\Facades\Session::has('success'))
            $.notify({
                    title:'Email Send',
                    message:'Verification email resend successfully.'
                },
                {
                    type:'success',
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:5000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
                });
            @elseif(\Illuminate\Support\Facades\Session::has('error'))
            $.notify({
                    title:'Opps,',
                    message:'Something went wrong we are unable to send the email.'
                },
                {
                    type:'danger',
                    allow_dismiss:true,
                    newest_on_top:false ,
                    mouse_over:true,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'center'
                    },
                    offset:{
                        x:30,
                        y:30
                    },
                    delay:1000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated pulse',
                        exit:'animated bounce'
                    }
                });
            @endif
        });
        
        
        function showLoader(_this)
        {
            $(_this).children('i').removeClass('far fa-envelope').addClass('fa fa-spinner fa-pulse');
        }

    </script>

@endsection


