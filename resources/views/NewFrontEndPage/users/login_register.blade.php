@extends('fontend.layout.layout')

@section('content')
<style>
    @media (min-width: 768px) {
.omb_row-sm-offset-3 div:first-child[class*="col-"] {
margin-left: 25%;
}
}
.omb_login .omb_authTitle {
text-align: center;
line-height: 300%;
}
.omb_login .omb_socialButtons a {
color: white; // In yourUse @body-bg
opacity:0.9;
}
.omb_login .omb_socialButtons a:hover {
color: white;
opacity:1;
}
.omb_login .omb_socialButtons .omb_btn-facebook {background: #3b5998;}
.omb_login .omb_socialButtons .omb_btn-twitter {background: #00aced;}
.omb_login .omb_socialButtons .omb_btn-google {background: #c32f10;}
.omb_login .omb_loginOr {
position: relative;
font-size: 1.5em;
color: #aaa;
margin-top: 1em;
margin-bottom: 1em;
padding-top: 0.5em;
padding-bottom: 0.5em;
}
.omb_login .omb_loginOr .omb_hrOr {
background-color: #cdcdcd;
height: 1px;
margin-top: 0px !important;
margin-bottom: 0px !important;
}
.omb_login .omb_loginOr .omb_spanOr {
display: block;
position: absolute;
left: 50%;
top: -0.6em;
margin-left: -1.5em;
background-color: white;
width: 3em;
text-align: center;
}
.omb_login .omb_loginForm .input-group.i {
width: 2em;
}
.omb_login .omb_loginForm .help-block {
color: red;
}
@media (min-width: 768px) {
.omb_login .omb_forgotPwd {
text-align: right;
margin-top:10px;
}
}
</style>

<div class="page-account u-s-p-t-80">
    <div class="container">
        <div class="row">
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> <?php echo Session::get('success_message') ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> <?php echo Session::get('error_message') ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            <div class="col-lg-6">
                <div class="login-wrapper p-4 rounded shadow-sm">
                    <h2 class="account-h2 u-s-m-b-20 text-center">Login</h2>
                    <h6 class="account-h6 u-s-m-b-30 text-center">Welcome back! Sign in to your account.</h6>
                    <form method="POST" action="{{ url('user/login') }}">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-name-email">Username or Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" class="text-field" id="email" required="" placeholder="Email">
                            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                            @error('email')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="login-password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password" id="login-password" class="text-field" placeholder="Password">
                            <div class="invalid-feedback">Please enter your password!</div>
                            @error('password')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="group-inline u-s-m-b-30">
                            <div class="group-1">
                                <input type="checkbox" class="check-box" id="remember-me-token">
                                <label class="label-text" for="remember-me-token">Remember me</label>
                            </div>
                            <div class="group-2 text-right">
                                <div class="page-anchor">
                                    <a href="{{ url('user/forgot-password') }}">
                                        <i class="label-text"></i>Lost your password?
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-45">
                            <button type="submit" class="button button-outline-secondary w-100 mb-1">Login</button>
                        </div>
                        <div class="row omb_row-sm-offset-3 omb_socialButtons">
                            <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
                        <div class="container">
                                <div class="omb_login">
                                    <h3 class="omb_authTitle">Login or <a href="#">Sign up</a></h3>
                                    <div class="row omb_row-sm-offset-3 omb_socialButtons justify-around justify-center ">
                                    <div class="col-xs-4 ml-3 shadow-sm">
                                        <a href="{{ route('login.linkedin') }}" class="btn btn-lg btn-block pb-2" style="background-color: rgb(0,119,181);">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 15 15">
                                                <path fill-rule="evenodd" d="M7.979 5v1.586a3.5 3.5 0 0 1 3.082-1.574C14.3 5.012 15 7.03 15 9.655V15h-3v-4.738c0-1.13-.229-2.584-1.995-2.584-1.713 0-2.005 1.23-2.005 2.5V15H5.009V5h2.97ZM3 2.487a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" clip-rule="evenodd"/>
                                                <path d="M3 5.012H0V15h3V5.012Z"/>
                                              </svg>
                                        </a>
                                    </div>
                                    <div class="col-xs-4 ml-3 shadow-sm">
                                        <a href="{{ route('login.github') }}" class="btn btn-lg btn-block bg-dark ">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="col-xs-4 ml-3 shadow-sm ">
                                        <a href="{{ route('login.google') }}" class="btn btn-lg btn-block bg-danger">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                                                <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                                              </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
            <!-- Login /- -->
            <div class="col-lg-6">
                <div class="reg-wrapper p-4 rounded shadow-sm">
                    <h2 class="account-h2 u-s-m-b-20 text-center">Register</h2>
                    <h6 class="account-h6 u-s-m-b-30 text-center">Registering for this site allows you to access your order status and history.</h6>
                    <form action="{{ url('/user/register') }}" method="POST">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-name">Name
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="name"  class="text-field" placeholder="Name">
                            @error('name')
                            <small class=" text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="emails" id="emails" class="text-field" placeholder="Email">
                            @error('emails')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="phone">phone
                                <span class="astk">*</span>
                            </label>
                            <input type="number" name="phone" id="phone" class="text-field" placeholder="Phone Number">
                            @error('phone')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password"  class="text-field" placeholder="Password">
                            @error('password')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" class="check-box" id="accept">
                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                <a href="javascript:void();" class="u-c-brand">terms &amp; conditions</a>
                            </label>
                             @error('terms')
                            <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="u-s-m-b-45">
                            <button type="submit" class="button button-primary w-100">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register /- -->
        </div>
    </div>
</div>
@endsection
