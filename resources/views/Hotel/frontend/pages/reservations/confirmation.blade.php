
@extends('all_frontend_layouts.layouts')
@section('title', 'Reservation Confirmation')
@section('content')
<div class="container d-flex justify-content-center align-items-center py-4">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="offer-card my-5">
                <div class="card-body">
                    <div class="d-flex justify-content-center mb-4">
                        <i class="bi bi-check-circle-fill text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="mb-0 text-dark text-center mb-3">Reservation Successful</h2>
                    <h6 class="fw-bold text-center text-dark" style="font-size: 18px;">Your reservation has been successfully processed!</h6>
                    <p class="text-center text-muted">Thank you for choosing our services. You can check your reservation status anytime.</p>
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('my.reservation') }}" class="btn btn-primary shadow-sm rounded rounded-1">
                            <i class="bi bi-eye"></i> Check Reservation Status
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
