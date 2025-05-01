@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .rounded-img {
        border-radius: 15px;
        object-fit: cover;
    }

    .room-type-btn {
        background-color: #0abe27;
        border: none;
        color: white;
        padding: 8px 24px;
        font-weight: 600;
        border-radius: 25px;
        font-size: 14px;
    }

    .guest-controls .btn {
        width: 36px;
        height: 36px;
        font-size: 18px;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
    }

    .btn-minus {
        background-color: #ccc;
        color: #fff;
    }

    .btn-plus {
        background-color: #00c600;
        color: #fff;
    }
    .btn-minus {
        background-color: #c1c1c1;
        color: white;
    }

    .btn-plus {
        background-color: #00c600;
        color: white;
    }

    .count-input {
        width: 50px;
        text-align: center;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-weight: bold;
        font-size: 16px;
        margin: 0 10px;
        padding: 6px;
    }

    .next-btn {
        background-color: #00c600;
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 12px;
        padding: 12px;
    }
    .card-custom {
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 30px 20px;
        max-width: 400px;
        margin: auto;
        background-color: #fff;
    }

    .room-type-btn {
        background-color: #0abe27;
        border: none;
        color: white;
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 20px;
    }

    .guest-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .guest-controls {
        display: flex;
        align-items: center;
    }

    .btn-minus,
    .btn-plus {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        font-size: 20px;
        font-weight: bold;
        border: none;
    }

    .btn-minus {
        background-color: #c1c1c1;
        color: white;
    }

    .btn-plus {
        background-color: #00c600;
        color: white;
    }
    .count-input {
        width: 50px;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        margin: 0 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 5px;
    }
    .next-btn {
        background-color: #00c600;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 10px;
        width: 100%;
        padding: 10px 0;
        margin-top: 20px;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-link text-dark me-2" onclick="history.back()">
            <i class="bi bi-arrow-left fs-5"></i>
        </button>
        <h4 class="mb-0 text-dark">{{ $room->hotel->name }}</h4>
    </div>

    <div class="offer-card shadow-sm mb-4">
        @if($room->cover_image)
        <img src="{{ $room->cover_image }}" class="w-100 rounded-img" height="400" alt="Room">
        @endif
        <div class="card-body">
            <div class="d-md-flex justify-content-between">
                <div>
                    <h5 class="fw-bold">{{ $room->room_type }}</h5>
                    <p class="text-muted mb-1"><i class="bi bi-geo-alt-fill text-primary"></i> {{ $room->hotel->location }}</p>
                    <p class="text-muted mb-1">⭐ 4.8 • 1.0 km away</p>
                    <p class="text-muted">Capacity: {{ $room->capacity }}</p>
                </div>
                <div class="text-md-end mt-3 mt-md-0">
                    <p class="text-muted mb-1">Room #: {{ $room->room_number }}</p>
                    <p class="text-muted mb-1">Floor: {{ $room->floor }}</p>
                    <h5 class="text-primary fw-bold">{{ $room->price }} ETB <small class="fw-normal">/ Night</small></h5>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('reservation.preview') }}" method="POST">
        @csrf
    <div class="row gy-4">

        <div class="col-md-8">
            <div class="offer-card shadow-sm p-4">
                <h5 class="mb-4">Select Dates</h5>
                <form method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            @error('room_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="hidden" name="user_id" value="@if(Auth::check()) {{ Auth::user()->id }} @endif">
                            @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <label class="form-label" for="check_in_date">Check-in Date</label>
                            <input type="text" id="check_in_date" name="check_in_date" class="form-control" placeholder="Check-in" required>
                            @error('check_in_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="check_out_date">Check-out Date</label>
                            <input type="text" id="check_out_date" name="check_out_date" class="form-control" placeholder="Check-out" required>
                            @error('check_out_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="total_night">Reserved Days</label>
                            <input type="number" id="total_night" readonly min="0" name="total_night" class="form-control w-100" placeholder="" required>
                            @error('total_night')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Book Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="offer-card shadow-sm p-4">
                <div class="border-0">
                    <h5 class="text-center fw-bold my-3">Selected Room Type</h5>
                    <div class="text-center mb-4">
                        <button class="room-type-btn">Queens</button>
                    </div>
                    <h6 class="text-center fw-semibold mb-4">Select Guest</h6>
                    <div class="guest-row">
                        <div>
                            <div class="fw-bold">Adults</div>
                            <small class="text-muted">Max: {{ $room->total_adult }}</small><br>
                            <small class="text-muted">Age 14 Or Above</small>
                        </div>
                        <div class="guest-controls">
                            <button type="button" class="btn-minus" onclick="changeCount('adult', -1)">−</button>
                            <input type="number" max="{{ $room->total_adult }}" class="count-input"  name="total_adult" id="adult-count" value="1" min="0">
                            <button type="button" class="btn-plus" onclick="changeCount('adult', 1)">+</button>
                        </div>
                        @error('total_adult')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                    <div class="guest-row">
                        <div>
                            <div class="fw-bold">Children </div>
                            <small class="text-muted">Max: {{ $room->total_child }}</small><br>
                            <small class="text-muted">Age 2-13</small>
                        </div>
                        <div class="guest-controls">
                            <button type="button" class="btn-minus" onclick="changeCount('child', -1)">−</button>
                            <input type="number" max="{{ $room->total_child }}" class="count-input"  name="total_child" id="child-count" value="0" min="0">
                            <button type="button" class="btn-plus" onclick="changeCount('child', 1)">+</button>
                        </div>
                        @error('total_child')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>

                    <div class="guest-row">
                        <div>
                            <div class="fw-bold">Infants </div>
                            <small class="text-muted">Max :{{ $room->total_infant }}</small><br>
                            <small class="text-muted">Under 2</small>
                        </div>
                        <div class="guest-controls">
                            <button type="button" class="btn-minus" onclick="changeCount('infant', -1)">−</button>
                            <input type="number" max="{{ $room->total_infant }}" class="count-input" name="total_infant" id="infant-count" value="0" min="0">
                            <button type="button" class="btn-plus" onclick="changeCount('infant', 1)">+</button>
                        </div>
                        @error('total_infant')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>
                    {{-- <button class="next-btn">Next</button> --}}
                </div>
            </div>
        </div>

    </div>
    </form>
</div>

@php
    $bookedRanges = App\Models\Reservation::where('room_id', $room->id)
        ->where('status', '!=', 'cancelled')
        ->get(['check_in_date', 'check_out_date']);
    $disabledDates = [];
    foreach ($bookedRanges as $range) {
        $start = \Carbon\Carbon::parse($range->check_in_date);
        $end = \Carbon\Carbon::parse($range->check_out_date);
        while ($start <= $end) {
            $disabledDates[] = $start->format('Y-m-d');
            $start->addDay();
        }
    }
@endphp

<script>
    function calculateTotalNights() {
    let checkIn = document.getElementById("check_in_date").value;
    let checkOut = document.getElementById("check_out_date").value;

    if (checkIn && checkOut) {
        let checkInDate = new Date(checkIn);
        let checkOutDate = new Date(checkOut);

        // Calculate the time difference in milliseconds
        let timeDiff = checkOutDate - checkInDate;

        // Convert time difference from milliseconds to days
        let nightCount = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

        // Update the total_night input field if the count is positive
        if (nightCount > 0) {
            document.getElementById("total_night").value = nightCount;
        } else {
            document.getElementById("total_night").value = '';
        }
    }
}

    let disabledDates = @json($disabledDates);

    flatpickr("#check_in_date", {
        minDate: "today",
        disable: disabledDates,
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            flatpickr("#check_out_date", {
                minDate: dateStr,
                disable: disabledDates,
                dateFormat: "Y-m-d"
            });
        }
    });

    flatpickr("#check_out_date", {
        minDate: "today",
        disable: disabledDates,
        dateFormat: "Y-m-d"
    });

    function checkAvailability() {
        let checkIn = document.getElementById("check_in_date").value;
        let checkOut = document.getElementById("check_out_date").value;
        let roomId = "{{ $room->id }}";

        if (checkIn && checkOut) {
            fetch("{{ route('check.availability') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ room_id: roomId, check_in_date: checkIn, check_out_date: checkOut }),
            })
            .then(res => res.json())
            .then(data => {
                if (!data.available) {
                    alert("This room is not available on selected dates.");
                    document.getElementById("check_in_date").value = "";
                    document.getElementById("check_out_date").value = "";
                }
            });
        }
    }

    document.getElementById("check_in_date").addEventListener("change", function () {
    checkAvailability();
    calculateTotalNights();
});

document.getElementById("check_out_date").addEventListener("change", function () {
    checkAvailability();
    calculateTotalNights();
});

    function changeCount(type, delta) {
        const input = document.getElementById(`${type}-count`);
        const max = parseInt(input.max);
        const min = parseInt(input.min);
        let value = parseInt(input.value);
        value = Math.min(max, Math.max(min, value + delta));
        input.value = value;
    }
</script>
@endsection
