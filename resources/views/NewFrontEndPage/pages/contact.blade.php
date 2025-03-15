@extends('fontend.layout.layout')
@section('content')

<div class="page-contact u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="touch-wrapper">
                    <h1 class="contact-h1">Get In Touch With Us</h1>
                    <form action="{{ url('/contact') }}" method="POST">
                        @csrf
                        <div class="group-inline u-s-m-b-30">
                            <div class="group-1 u-s-p-r-16">
                                <label for="contact-name">Your Name
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="contact-name" name="name" class="text-field" placeholder="Name">
                            </div>
                            <div class="group-2">
                                <label for="contact-email">Your Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="contact-email" class="text-field" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="contact-subject">Phone Number
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="contact-subject" class="text-field " name="phone" placeholder="Subject">
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="contact-message">Message:</label>
                            <textarea class="text-area" id="contact-message" name="message"></textarea>
                        </div>
                        <div class="u-s-m-b-30">
                            <button type="submit" class="button button-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="information-about-wrapper">
                    <h1 class="contact-h1">Information About Us</h1>
                    <p>
                        {{ $appsettings[0]['description'] }}
                    </p>

                </div>
                <div class="contact-us-wrapper">
                    <h1 class="contact-h1">Contact Us</h1>
                    <div class="contact-material u-s-m-b-16">
                        <h6>Location</h6>
                        <span>{{ $appsettings[0]['address'] }}</span>
                    </div>
                    <div class="contact-material u-s-m-b-16">
                        <h6>Email</h6>
                        <span>{{ $appsettings[0]['email_address'] }}</span>
                    </div>
                    <div class="contact-material u-s-m-b-16">
                        <h6>Telephone</h6>
                        <span>{{ $appsettings[0]['phone_no'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
