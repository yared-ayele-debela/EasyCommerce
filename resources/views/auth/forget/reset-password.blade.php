
@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="offer-card p-4 rounded shadow-sm ">
                <h2 class="account-h2 mb-3 text-dark text-center">Reset Your Password</h2>
                <p id="forget-error" class="text-danger"></p>
                <p id="forget-success" class="text-success"></p>
                <form class="needs-validation" method="POST" action="{{ route('reset.password') }}">
                    @csrf
                    <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            @error('password')
                            <p class="text-danger">{{ $message }}</p>          
                            @enderror                    
                        </div>
                    <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmation Password <span class="text-danger">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>          
                            @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn text-white bg-primary w-100">Reset Password</button>
                    </div>
                </form>
                <div class="page-anchor mt-3">
                    <a href="{{ url('auth/login') }}" class="text-decoration-none text-dark">
                        <i class="fas fa-arrow-left me-2"></i>Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
