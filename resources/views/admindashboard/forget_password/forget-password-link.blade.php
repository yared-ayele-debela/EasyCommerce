@include('admindashboard.css.css_file')
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center min-vh-100 align-items-center bg-light px-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm rounded-4 border-0" style="box-shadow: 1px 1px 11px 1px rgba(169, 229, 253, 0.7);">
                            <div class="card-body p-4">

                                {{-- Logo --}}
                                <div class="text-center mb-4">
                                    <img src="{{ $appsettings[0]['logo']}}" alt="Logo" class="img-fluid" style="max-height: 60px;">
                                </div>

                                <h5 class="text-center fw-bold mb-3">Reset Your Password</h5>
                                <p class="text-center text-muted small mb-4">Enter your email and new password to reset your account.</p>
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                @if(session('info'))
                                    <div class="alert alert-info">{{ session('info') }}</div>
                                @endif
                                <form action="{{ route('admin.reset.password.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    {{-- Email --}}
                                    <div class="mb-3">
                                        <label for="email_address" class="form-label">Email Address</label>
                                        <input type="email" id="email_address" name="email" class="form-control @error('email') is-invalid @enderror" required autofocus placeholder="Enter your email">
                                        @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- New Password --}}
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Enter new password">
                                        @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required placeholder="Confirm new password">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Submit --}}
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Reset Password</button>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="{{ url('admin/login') }}" class="small text-decoration-none text-primary">Back to Login</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@include('admindashboard.js.js_file')

