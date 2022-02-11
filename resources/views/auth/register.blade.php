@extends('layouts.guest')
@section('title')
    <title>Register</title>
@endsection
@section('content')
    <section>
	    <div class="container-fluid p-0">
	        <div class="row m-0">
	            <div class="col-12 p-0">
	                <div class="login-card">
	                    <form class="theme-form login-form needs-validation"  action="{{route('register')}}" method="POST" id="register" novalidate >
                           
	                        <h4>Create your account</h4>
	                        <h6>Enter your personal details to create account</h6>
                            @csrf
                            <x-auth-validation-errors class="mb-4 text-warning" :errors="$errors"/>

	                        <div class="form-group">
	                            <label>First Name</label>
	                                <div class="input-group">
	                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                        <input type="text" class="form-control" id="firstname"
                                                   placeholder="First Name" required name="first_name">
    	                                <div class="invalid-feedback">Please enter first name.</div>
                                        
                                    </div>
	                        </div>
							<div class="form-group">
	                            <label>Last Name</label>
								 <div class="input-group">
									<span class="input-group-text"><i class="icon-user"></i></span>
									<input class="form-control" name="last_name" id="lastname" type="text" required="" placeholder="Last Name" />
									<div class="invalid-feedback">Please enter last name.</div>
								</div>
							</div>
	                        <div class="form-group">
	                            <label>Email Address</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-email"></i></span>
	                                <input class="form-control" name="email" type="email" id="email" required="" placeholder="Test@gmail.com" />
    	                            <div class="invalid-feedback">Please enter valid email address.</div>
                                
                                </div>
	                        </div>
	                        <div class="form-group">
	                            <label>Password</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                    
                                    <input type="password" class="form-control" id="password"
                                             name="password" required="" placeholder="*********">
                                    <div id="pwd_visibility" class="hide">
                                        <i class="fa fa-eye"></i>
                                    </div>
	                                <div class="invalid-feedback">Please enter password.</div>
	                            </div>
	                        </div>
                            
	                        <div class="form-group">
	                            <label>Confirm Password</label>
	                            <div class="input-group">
	                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                    
                                    <input type="password" class="form-control" id="password_confirmation"
                                             name="password_confirmation" required="" placeholder="*********">
                                    <div id="pwd_confirm_visibility" class="hide">
                                        <i class="fa fa-eye"></i>
                                    </div>
	                                <div class="invalid-feedback">Please confirm password.</div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <button class="btn btn-primary btn-block" type="submit">Create Account</button>
	                        </div>
	                        <p>Are you an existing ASDC student?<br> Please sign in<a href="{{ route('login') }}"> here</a>.</p>
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
    </script>
@endsection


