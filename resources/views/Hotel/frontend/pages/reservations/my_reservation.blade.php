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
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm" >
                        <div class="card-header pb-3 bg-primary text-white d-flex justify-content-between">
                            <span>{{ $reservation->hotel->name }}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $reservation->room->room_type }} (Room No: {{ $reservation->room->room_number }})</h5>
                            <p class="card-text mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M d, Y') }}</p>
                            <p class="card-text mb-1"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M d, Y') }}</p>
                            <p class="card-text mb-1"><strong>Reserved days:</strong> {{ $reservation->total_night }}</p>
                            <p class="card-text mb-1"><strong>Guests:</strong> {{ $reservation->total_adult }} Adults, {{ $reservation->total_child }} Children, {{ $reservation->total_infant }} Infants</p>
                            <p class="card-text"><strong>Total:</strong> {{ number_format($reservation->final_price, 2) }} ETB</p>
                            <hr>
                            <p class="card-text mb-1"><strong>Reservation Status: <span class=" badge bg-secondary">{{ $reservation->status }}</span></strong></p>
                            <p class="card-text mb-1"><strong>Pyament Status: <span class="badge bg-info">{{ $reservation->payment_status }}</span></strong> </p>
                            <button class="btn btn-outline-primary btn-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#orderDetails-{{ $reservation->id }}">
                                View Details
                            </button>

                            <div id="orderDetails-{{ $reservation->id }}" class="collapse mt-3">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            @if($reservation->room->image)
                                            <a href="{{ url('hotel/room/'.$reservation->room->id.'/detail') }}">
                                            <img src="{{ asset('storage/' . $reservation->room->image) }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            </a>
                                            @endif
                                            <div>
                                                <p class="text-muted mb-1">Room Number #: {{ $reservation->room->room_number }}</p>
                                                <p class="text-muted mb-1">Capacity : {{ $reservation->room->capacity }}</p>
                                                <p class="text-muted mb-1">Floor: {{ $reservation->room->floor }}</p>
                                            </div>
                                        <span class="fw-bold">{{ $reservation->room->price }} ETB <small class="fw-normal">/ Night</small></span>
                                        </div>
                                    </li>
                                </ul>
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                        @if($reservation->hotel_reservation_payment_info)
                        <div class="d-flex justify-content-around align-items-center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Reservation{{ $reservation->id }}">
                                <i class="bi bi-eye-fill"></i> Payment information
                            </button> &nbsp;
                            <form action="{{ route('reservations.receipt') }}" method="GET" target="_blank">
                                @csrf
                                <input type="hidden" name="id" value="{{ encrypt($reservation->id) }}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm "><i class="bi bi-printer-fill"></i></button>
                            </form>
                        </div>
                        <div class="modal fade" id="Reservation{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Payment Detail</h5>
                                        <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Receipt:</p>
                                        @if($reservation->hotel_reservation_payment_info->receipt)

                                        <img src="{{ asset('storage/'.$reservation->hotel_reservation_payment_info->receipt) }}"  class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}">
                                        @else
                                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}">
                                        @endif
                                        <p class="card-text"><strong>Bank Name :</strong> {{ $reservation->hotel_reservation_payment_info->bank_name }}</p>
                                        <p class="card-text"><strong>Transaction Number :</strong> <strong>{{ $reservation->hotel_reservation_payment_info->transaction_number }}</strong></p>
                                        <p class="card-text"><strong>Amount Paid :</strong> {{ $reservation->hotel_reservation_payment_info->amount_paid }} ETB</p>
                                        <p class="card-text text-dark"><strong>Payment Status :</strong> <span class="btn btn-sm btn btn-secondary">{{ $reservation->hotel_reservation_payment_info->payment_status }}</span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        @endif

                        <a href="{{ url('hotel/'.$reservation->hotel->id.'/detail') }}" class="btn btn-sm btn-primary">
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
