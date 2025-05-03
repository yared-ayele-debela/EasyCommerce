@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container pb-3">
        <div class="header">
            <button class="btn btn-link text-dark" onclick="history.back()">
                <i class="bi bi-arrow-left"></i>
            </button>
            <h5 class="my-4 text-dark text-center">Contact Us</h5>
        </div>
    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-6">
            <div class="p-4 offer-card border rounded shadow">
                <h2 class="mb-4 fw-bold text-dark">Get In Touch With Us</h2>
                @session('success')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    </div>
                @endsession
                <form action="{{ url('/contact') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact-name" class="form-label">Your Name <span class="text-danger">*</span></label>
                            <input type="text" id="contact-name" name="name" class="form-control" placeholder="Enter your name" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact-email" class="form-label">Your Email <span class="text-danger">*</span></label>
                            <input type="email" id="contact-email" name="email" class="form-control" placeholder="Enter your email" required>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="contact-phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" id="contact-phone" name="phone" class="form-control" placeholder="Enter your phone number" required>
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <label for="contact-message" class="form-label">Message</label>
                        <textarea id="contact-message" name="message" class="form-control" rows="4" placeholder="Write your message..."></textarea>
                        @error('message')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary rounded rounded-1 w-100">Send Message</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="p-4 offer-card border rounded shadow">
                <h2 class="mb-3 fw-bold text-dark">Information About Us</h2>
                <p class="text-muted">
                    {{ $appsettings[0]['description'] }}
                </p>
                <h2 class="mt-4 fw-bold text-dark">Contact Us</h2>
                <div class="mt-3">
                    <h6 class="fw-bold text-dark"><i class="bi bi-geo-fill text-primary"></i> Location</h6>
                    <p class="text-muted">{{ $appsettings[0]['address'] }}</p>
                </div>
                <div class="mt-3">
                    <h6 class="fw-bold text-dark"><i class="bi bi-send text-primary"></i> Email</h6>
                    <p class="text-muted">{{ $appsettings[0]['email_address'] }}</p>
                </div>
                <div class="mt-3">
                    <h6 class="fw-bold text-dark"><i class=" bi bi-phone-vibrate text-primary"></i> Telephone</h6>
                    <p class="text-muted">{{ $appsettings[0]['phone_no'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
