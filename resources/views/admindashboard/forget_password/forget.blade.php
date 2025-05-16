@include('admindashboard.css.css_file')

    <main>
       <div class="container">
          <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
             <div class="container">
                <div class="row justify-content-center min-vh-100 align-items-center bg-light">
    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body p-4">
                
                {{-- Logo --}}
                <div class="text-center mb-3">
                    <img src="{{ $appsettings[0]['logo'] }}" alt="Logo" class="img-fluid" style="max-height: 60px;">
                </div>

                {{-- Title --}}
                <h5 class="text-center fw-bold mb-2">Forgot Your Password?</h5>
                <p class="text-center text-muted small mb-4">No worries, we’ll send you a link to reset it.</p>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ route('admin.forgot.password.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="email_address" class="form-label">Email Address</label>
                        <input type="email" id="email_address" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="Enter your registered email">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ url('admin/login') }}" class="text-decoration-none text-primary small">Back to login</a>
                </div>
            </div>
        </div>
    </div>
</div>

           </div>
        </section>
     </div>

  </main>
  @include('admindashboard.js.js_file')
