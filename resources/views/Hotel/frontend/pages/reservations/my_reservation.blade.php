@extends('all_frontend_layouts.layouts')
@section('title', 'My Reservations')
@section('content')
<style>
    .card{
        border: 1px solid #b2f7b2 !important;
        box-shadow: 0 2px 10px rgb(204, 252, 204) !important;
    }
</style>
<div class="container py-5">
    <h4 class="mb-4">My Reservations ({{ $reservations->count() }})</h4>
        @if ($reservations->isEmpty())
            <div class="alert alert-info">
                You haven't made any reservations yet.
            </div>
        @else
        <div class="row">
            @foreach ($reservations as $reservation)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm" >
                        <div class="card-header pb-3 bg-primary text-white d-flex justify-content-between">
                            <span>{{ $reservation->hotel->name }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $reservation->room->room_type }} (No: {{ $reservation->room->room_number }})</h5>
                            <p class="card-text mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</p>
                            <p class="card-text mb-1"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</p>
                            <p class="card-text mb-1"><strong>Nights:</strong> {{ $reservation->total_night }}</p>
                            <p class="card-text mb-1"><strong>Guests:</strong> {{ $reservation->total_adult }} Adults, {{ $reservation->total_child }} Children, {{ $reservation->total_infant }} Infants</p>
                            <p class="card-text"><strong>Total:</strong> {{ number_format($reservation->total_price, 2) }} ETB</p>
                            <hr>
                            <p class="card-text mb-1"><strong>Reservation Status: {{ $reservation->status }}</strong></p>
                            <p class="card-text mb-1"><strong>Pyament Status: {{ $reservation->payment_status }}</strong> </p>

                        </div>
                        <div class="card-footer text-end">
                            <a href="" class="btn btn-sm btn-primary">
                                View Hotel
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
            <div class="d-flex justify-content-left">
                {{ $reservations->links() }}
            </div>
        @endif
</div>
@endsection
