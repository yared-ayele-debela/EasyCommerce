<!-- resources/views/amenities/index.blade.php -->
@extends('Hotel.dashboard.layouts')
@section('hotel-dashboard')
<div class="pagetitle shadow-sm">
    <nav class=" p-2 text-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Reviews</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-4">Hotel Reviews <i class="bi bi-star-fill text-warning"></i>
                @php
                $averageRating = $hotel->reviews->avg('rating');
                @endphp
                {{ number_format($averageRating, 1) }} / 5
            </h4>
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <div class="card-body">
           <div class="table-responsive">
            <table class="table ">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Hotel</th>
                        <th>Room</th>
                        <th>Rating</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>
                            @if($review->user)
                            {{ $review->user->name }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($review->hotel)
                            {{ $review->hotel->name }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($review->room)
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Room{{ $review->id }}">
                              View Room Detail
                            </button>

                            <div class="modal fade" id="Room{{ $review->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Room Detail</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                        </div>
                                        <div class="modal-body">
                                           <p class="card-text"><strong>Room Type :</strong> {{ $review->room->room_type }}</p>
                                           <p class="card-text"><strong>Capacity :</strong> {{ $review->room->capacity }}</p>
                                           <p class="card-text"><strong>Room Price :</strong> {{ $review->room->price }} ETB</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($review->rating)
                            {{ $review->rating }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td>
                            @if($review->review)
                            {{ $review->review }}
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
           </div>
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection

