<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')

<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('hotel.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">REservations</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <h4>All Reservations</h4>
            @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @endsession
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Hotel</th>
                            <th>Room</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>

                            <th>Total Amount</th>
                            <th>Other Info</th>
                            <th>Reservation Status</th>
                            <th>Payment Status</th>
                            <th>Payment Detail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" style="font-size: 12px;" data-toggle="modal" data-target="#modelId{{ $reservation->id }}">
                                    View Customer
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modelId{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">User Informations</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if($reservation->user->profile_photo_path || (!empty($reservation->user->profile_photo_path) && \Illuminate\Support\Facades\Storage::exists('public/'.$reservation->user->profile_photo_path)))
                                                <img src="{{ asset('storage/' . $reservation->user->profile_photo_path) }}" alt="Profile Image" class=" img-fluid -bottom-3 mb-2" style="width: 100px; height: 100px; padding:2px; border:4px solid rgb(93, 94, 93); border-radius: 50%;">
                                                @else
                                                <img src="{{ asset('restaurant_frontend/no-image.jpg') }}" alt="Profile Image" class=" img-fluid -bottom-3 mb-2" style="width: 100px; height: 100px; padding:2px; border:4px solid rgb(93, 94, 93); border-radius: 50%;">

                                                @endif
                                                <p><strong>Name:</strong> {{ $reservation->user->name }}</p>
                                                <p><strong>Phone:</strong> {{ $reservation->user->mobile }}</p>
                                                <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                                                <p><strong>Address:</strong> {{ $reservation->user->address }}</p>
                                                <p><strong>City:</strong> {{ $reservation->user->city }}</p>
                                                <p><strong>State:</strong> {{ $reservation->user->state }}</p>
                                                <p><strong>Country:</strong> {{ $reservation->user->country }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" style="font-size: 12px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Hotel{{ $reservation->id }}">
                                    View Hotel Detail
                                </button>

                                <div class="modal fade" id="Hotel{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hotel Detail</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if($reservation->hotel)
                                                @if($reservation->hotel->banner_image)
                                                <img src="{{ $reservation->hotel->banner_image }}" alt="Profile Image" class=" img-fluid -bottom-3 mb-2" >
                                                @else
                                                <img src="{{ asset('restaurant_frontend/no-image.jpg') }}" alt="Profile Image" class=" img-fluid -bottom-3 mb-2" >
                                                @endif
                                                <p class="card-text"><strong>Hotel Name :</strong> {{ $reservation->hotel->name }}</p>
                                                <p class="card-text"><strong>Hotel Phone Number :</strong> {{ $reservation->hotel->phone }}</p>
                                                <p class="card-text"><strong>Category :</strong> {{ $reservation->hotel->category->name }}</p>
                                                <p class="card-text"><strong>Address :</strong> {{ $reservation->hotel->location }}</p>
                                                <p class="card-text"><strong>Price per Night :</strong> {{ $reservation->hotel->price_per_night }} ETB</p>
                                                @endif

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($reservation->room)
                                <button type="button" style="font-size: 12px;" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Room{{ $reservation->id }}">
                                    View Room Detail
                                </button>

                                <div class="modal fade" id="Room{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Room Detail</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="card-text"><strong>Room Number :</strong><strong> {{ $reservation->room->room_number }}</strong></p>
                                                <p class="card-text"><strong>Room Type :</strong> {{ $reservation->room->room_type }}</p>
                                                <p class="card-text"><strong>Capacity :</strong> {{ $reservation->room->capacity }}</p>
                                                <p class="card-text"><strong>Room Price :</strong> {{ $reservation->room->price }} ETB</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <p>No Room</p>
                                @endif
                            </td>
                            <td>{{ $reservation->check_in_date }}</td>
                            <td>{{ $reservation->check_out_date }}</td>

                            <td>{{ number_format($reservation->vendor_earning, 2) }} ETB</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#otherInfo{{ $reservation->id }}">
                                  View Detail
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="otherInfo{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Other information</h5>
                                                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                             <p class="card-text">
                                                <strong>Number of Guests :</strong> {{ $reservation->total_adult + $reservation->total_child + $reservation->total_infant }} <br>
                                                {{ $reservation->total_adult }} adult, {{ $reservation->total_child }} child, {{ $reservation->total_infant }} Infant
                                             </p>
                                             <p class="card-text">
                                               Reserved days {{ $reservation->total_night }}
                                             </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="btn btn-sm @if($reservation->status == 'Pending') btn-warning
                                @elseif($reservation->status == 'Confirmed') btn-info
                                @elseif($reservation->status == 'Checked_in') btn-success
                                @elseif($reservation->status == 'Completed') btn-secondary
                                @elseif($reservation->status == 'Cancelled') btn-danger
                                @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                                <!-- Button trigger modal -->
                                 @adminCan('update_hotel_reservation_status')

                                <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#status{{ $reservation->id }}">
                                    Update
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="status{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Reservation Status</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('reservations.updateStatus', $reservation->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-3">
                                                        <label for="status" class="form-lable">Select Status:</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="Pending" @if($reservation->status == 'Pending') selected @endif>Pending</option>
                                                            <option value="Confirmed" @if($reservation->status == 'Confirmed') selected @endif>Confirmed</option>
                                                            <option value="Cancelled" @if($reservation->status == 'Cancelled') selected @endif>Cancelled</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                @endadminCan

                            </td>
                            <td>
                                <span class="btn btn-sm @if($reservation->payment_status == 'Pending') btn-warning
                                @elseif($reservation->payment_status == 'Paid') btn-success
                                @elseif($reservation->payment_status == 'Failed') btn-danger
                                @elseif($reservation->payment_status == 'Cancelled') btn-outline-danger
                                @elseif($reservation->payment_status == 'Processing') btn-secondary
                                @endif">
                                    {{ ucfirst($reservation->payment_status) }}
                                </span>
                                <!-- Button trigger modal -->
                                 @adminCan('update_hotel_reservation_payment_status')

                                <button type="button" class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#paymentstatus{{ $reservation->id }}">
                                    Update
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="paymentstatus{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Reservation Status</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('reservations.updatePaymentStatus', $reservation->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-3">
                                                        <label for="status" class="form-lable">Payment Status:</label>
                                                        <select name="payment_status" id="payment_status" class="form-control">
                                                            <option value="Pending" @if($reservation->payment_status == 'Pending') selected @endif>Pending</option>
                                                            <option value="Paid" @if($reservation->payment_status == 'Paid') selected @endif>Paid</option>
                                                            <option value="Failed" @if($reservation->payment_status == 'Failed') selected @endif>Failed</option>
                                                            <option value="Cancelled" @if($reservation->payment_status == 'Cancelled') selected @endif>Cancelled</option>
                                                            <option value="Processing" @if($reservation->payment_status == 'Processing') selected @endif>Processing</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endadminCan
                            </td>
                            <td>
                                @if($reservation->hotel_reservation_payment_info)
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Reservation{{ $reservation->id }}">
                                    <i class="bi bi-eye-fill"></i> Payment information
                                </button>

                                <div class="modal fade" id="Reservation{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Payment Detail</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Receipt:</p>
                                                @if($reservation->hotel_reservation_payment_info->receipt)
                                                <img src="{{ $reservation->hotel_reservation_payment_info->receipt }}"  class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}">
                                                @else
                                                <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}">
                                                @endif
                                                {{-- <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid" alt="{{ $reservation->hotel_reservation_payment_info->bank_name }}"> --}}
                                                <p class="card-text"><strong>Bank Name :</strong> {{ $reservation->hotel_reservation_payment_info->bank_name }}</p>
                                                <p class="card-text"><strong>Transaction Number :</strong> <strong>{{ $reservation->hotel_reservation_payment_info->transaction_number }}</strong></p>
                                                <p class="card-text"><strong>Amount Paid :</strong> {{ $reservation->vendor_earning }} ETB</p>
                                                <p class="card-text"><strong>Payment Status :</strong> {{ $reservation->hotel_reservation_payment_info->payment_status }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else

                                @endif
                            </td>
                            <td>
                                @adminCan('delete_hotel_reservation')
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="mb-2" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm delete-restaurant"><i class="bi bi-trash-fill"></i></button>
                                </form>
                                @endadminCan
                                <form action="{{ route('reservations.receipt') }}" method="GET" target="_blank">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ encrypt( $reservation->id) }}">
                                    <button type="submit" class="btn btn-secondary btn-sm "><i class="bi bi-printer-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on("click", ".delete-restaurant", function(e) {
            e.preventDefault();
            let form = $(this).closest("form");

            Swal.fire({
                title: "Are you sure?"
                , text: "You won't be able to revert this!"
                , icon: "warning"
                , showCancelButton: true
                , confirmButtonColor: "#d33"
                , cancelButtonColor: "#3085d6"
                , confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form after confirmation
                }
            });
        });
    });

</script>
@endsection

