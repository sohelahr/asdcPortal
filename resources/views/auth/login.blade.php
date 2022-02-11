@extends('layouts.guest')
@section('title')
    <title>Login</title>
@endsection
@section('content')
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">
                        <form class="theme-form login-form needs-validation" novalidate="" action="{{route('login')}}" method="POST">
                            <h4>Login</h4>
                            <h6>Welcome back! Log in to your account.</h6>
                            @csrf    
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <div class="form-group">
                                <label>Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-email"></i></span>
                                    <input class="form-control" type="email" required="" name="email" placeholder="Test@gmail.com" id="email" />
    	                            <div class="invalid-feedback">Please enter email.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-lock"></i></span>
                                    <input class="form-control" type="password" name="password" id="password" required="" placeholder="*********" />
                                    <div id="pwd_visibility" class="hide">
                                        <i class="fa fa-eye"></i>
                                    </div>
	                                <div class="invalid-feedback">Please enter password.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    {{-- <div class="checkbox">
                                        <input id="checkbox1" type="checkbox" />
                                        <label for="checkbox1">Remember password</label>
                                    </div>  --}} 
                                    <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                                </div>
                            </div>
                            <p>Are you a new ASDC student?<a class="ms-2" href="{{ route('register') }}">Create Account</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jcontent')
    <script>
        (function () {
	        "use strict";
	        window.addEventListener(
	            "load",
	            function () {
	                // Fetch all the forms we want to apply custom Bootstrap validation styles to
	                var forms = document.getElementsByClassName("needs-validation");
	                // Loop over them and prevent submission
	                var validation = Array.prototype.filter.call(forms, function (form) {
	                    form.addEventListener(
	                        "submit",
	                        function (event) {
	                            if (form.checkValidity() === false) {
	                                event.preventDefault();
	                                event.stopPropagation();
	                            }
	                            form.classList.add("was-validated");
	                        },
	                        false
	                    );
	                });
	            },
	            false
	        );
	    })();
         @if(\Illuminate\Support\Facades\Session::has('already_verfied'))   
                $.notify({
                        title:'Email Already Verified',
                        message:'Email already verified please Login to continue'
                    },
                    {
                        type:'info',
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
            @elseif(\Illuminate\Support\Facades\Session::has('email_verfied'))
                 $.notify({
                        title:'Email Verfied',
                        message:'Email verfied successfully please login to continue'
                    },
                    {
                        type:'success',
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
            @elseif(\Illuminate\Support\Facades\Session::has('verify_email'))
                $.notify({
                        title:'Account Created',
                        message:'Account created successfully, please verify your email (Check your mail) to continue'
                    },
                    {
                        type:'success',
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
            @elseif(\Illuminate\Support\Facades\Session::has('verify_email_first'))
                $.notify({
                        title:'Verify Mail',
                        message:'Please verify your email first'
                    },
                        {
                        type:'warning',
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
            
            @elseif(\Illuminate\Support\Facades\Session::has('error'))
                $.notify({
                    title:'Opps,',
                    message:'Something went wrong.'
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
    </script>
@endsection
