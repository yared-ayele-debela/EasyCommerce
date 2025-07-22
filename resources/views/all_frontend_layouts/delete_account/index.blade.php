@php
    use App\Models\AppSetting;
$appsetting = AppSetting::first();
@endphp

@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container py-5">
<div class="row justify-content-center">

        <div class="col-md-8">
            <div class="offer-card card shadow-sm">
                <div class="card-header">
             <h3 class="my-2 text-center">Delete Your Account</h4>

                </div>
                <div class="card-body">
 <p class="mb-3">
                We're sorry to see you go. You can use the form below to request deletion of your account and all associated data.
                This action is permanent and cannot be undone.
            </p>
            <!-- Success Message -->
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Delete Account Form -->
        <form method="POST" action="{{ route('delete.account.delete') }}" id="deleteForm">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                 <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g., 2519xxxxxx" required>
                    <button type="button" class="btn btn-primary" id="sendOtpBtn">Send OTP</button>
                </div>
            </div>
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="mb-3 d-none" id="otpSection">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" class="form-control" id="otp" maxlength="6" placeholder="6-digit code">
                <button type="button" class="btn btn-success mt-2 " id="verifyOtpBtn">Verify OTP</button>
                <small class="text-muted">Check your phone for the verification code.</small>
                <div class="text-success mt-2 d-none" id="otpSuccess">✅ OTP Verified!</div>
                <div class="text-danger mt-2 d-none" id="otpError">❌ Invalid OTP. Try again.</div>
            </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Leaving (optional)</label>
                    <textarea class="form-control" name="reason" id="reason" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-danger" id="submitBtn" disabled>Request Account Deletion</button>
            </form>
            <hr>
            <p>
                Need help? Contact our support team at <a href="{{ $appsetting->email_address }}">{{ $appsetting->email_address }}</a>
            </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('sendOtpBtn').addEventListener('click', function () {
    const phone = document.getElementById('phone').value;

    if (!phone) {
        alert("Please enter a valid phone number.");
        return;
    }

    fetch("{{ route('delete.account.otp.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('otpSection').classList.remove('d-none');
        } else {
            alert("Failed to send OTP. Try again.");
        }
    });
});

document.getElementById('verifyOtpBtn').addEventListener('click', function () {
    const phone = document.getElementById('phone').value;
    const otp = document.getElementById('otp').value;

    fetch("{{ route('delete.account.otp.verify') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ phone: phone, otp: otp })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('otpSuccess').classList.remove('d-none');
            document.getElementById('otpError').classList.add('d-none');
            document.getElementById('phone').classList.add('disabled');
            document.getElementById('submitBtn').disabled = false;
        } else {
            document.getElementById('otpSuccess').classList.add('d-none');
            document.getElementById('otpError').classList.remove('d-none');
        }
    });
});
</script>

@endsection

