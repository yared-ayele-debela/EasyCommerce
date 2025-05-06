@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-50">
        <div class="col-md-6 col-12 col-lg-4 py-3">
            <div class="border border-1 rounded rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-center">Verify OTP</h4>
                    <form method="POST" action="{{ route('verify-otp') }}">
                        @csrf
                        <input type="hidden" name="phone" value="{{ $phone }}">
                        <label class="form-label mb-2">Enter the 6-digit code sent to your phone:</label>
                        <div class="d-flex justify-content-between gap-2 mb-4">
                            @for($i = 0; $i < 6; $i++)
                                <input type="text" name="otp[]" maxlength="1" required class="form-control text-center  otp-input" style="width: 40px;">
                            @endfor
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 w-100">Verify</button>
                    </form>
                </div>
             </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.otp-input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // Auto-focus first input
        if (inputs.length > 0) {
            inputs[0].focus();
        }
    });
</script>
@endsection
