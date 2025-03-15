@extends('fontend.layout.layout')

@section('content')

<div class="page-account u-s-p-t-80">
    <div class="container">
        <div class="row">
            <!-- Login -->
            <div class="col-lg-6">
                <div class="login-wrapper p-4 rounded-sm shadow-sm">
                    <h2 class="account-h2 u-s-m-b-20 text-center">Login </h2>
                    <h6 class="account-h6 u-s-m-b-30 text-center">Login With Your Vendor Account.</h6>
                    <form method="POST" action="{{ url('admin/login') }}" >
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-name-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" class="text-field" id="email" required="" placeholder="Email">
                            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="login-password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password" id="login-password" class="text-field" placeholder="Password">
                            <div class="invalid-feedback">Please enter your password!</div>

                        </div>
                        <div class="group-inline u-s-m-b-30">
                            <div class="group-1">
                                <input type="checkbox" class="check-box" id="remember-me-token">
                                <label class="label-text" for="remember-me-token">Remember me</label>
                            </div>
                            <div class="group-2 text-right">
                                <div class="page-anchor">
                                    <a href="lost-password.html">
                                        <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Lost your password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-45">
                            <button type="submit" class="button button-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
            <!-- Register -->
            <div class="col-lg-6">
                <div class="reg-wrapper p-4 rounded-sm shadow-sm">
                    <h2 class="account-h2 u-s-m-b-20 text-center">Registration</h2>
                    <h6 class="account-h6 u-s-m-b-30 text-center">Wellcome back to register become a seller</h6>
                    <form action="{{ url('/vendor/register') }}" method="POST">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-name">Name
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="name"  class="text-field" placeholder="Name">
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" id="email" class="text-field" placeholder="Email">
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="phone">phone
                                <span class="astk">*</span>
                            </label>
                            <input type="number" name="phone" id="phone" class="text-field" placeholder="Phone Number">
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password"  class="text-field" placeholder="Password">
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" class="check-box" id="accept">
                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                <a href="terms-and-conditions.html" class="u-c-brand">terms &amp; conditions</a>
                            </label>
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
