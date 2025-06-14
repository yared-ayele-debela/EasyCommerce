@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">All Restaurants</h5>
    </div>
    <div class="row g-3 offer-card align-items-end mb-4 mx-1 bg-white p-3 ">
        <div class="col-md-2">
            <label for="name" class="form-label fw-semibold">name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Search by restaurant name" />
        </div>
        <div class="col-md-2">
            <label for="city" class="form-label fw-semibold">City</label>
            <select id="city" class="form-select shadow-sm">
                <option value="">-- Select City --</option>
                @foreach($cities as $city)
                <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="state" class="form-label fw-semibold">State</label>
            <select id="state" class="form-select shadow-sm">
                <option value="">-- Select State --</option>
                @foreach($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="delivery_zone" class="form-label fw-semibold">Delivery Zone</label>
            <select id="delivery_zone" class="form-select shadow-sm">
                <option value="">-- Select Zone --</option>
                @foreach($delivery_zones as $zone)
                <option value="{{ $zone }}">{{ $zone }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label for="delivery_fee" class="form-label fw-semibold">Start From Fee</label>
            <select id="delivery_fee" class="form-select shadow-sm">
                <option value="">-- Select Fee --</option>
                @foreach($delivery_fees as $fee)
                <option value="{{ $fee }}">{{ $fee }} ETB</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 text-end">
            <button class="btn btn-primary w-100 shadow-sm" id="filterBtn">
             <i class="bi bi-arrow-clockwise"></i>   Reset Form
            </button>
        </div>
    </div>

    <div class="row" id="restaurantResults">
        @include('all_frontend_layouts.partials.restaurant-cards')
        <div class="col-12">
            {{ $auto_restaurants->links() }}
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Attach change event to all select filters
        $('#city, #state, #delivery_zone, #delivery_fee, #name').on('change keyup', function () {
            let city = $('#city').val();
            let name = $('#name').val(); // assuming there's an input with id="name"
            let state = $('#state').val();
            let delivery_zone = $('#delivery_zone').val();
            let delivery_fee = $('#delivery_fee').val();

            $.ajax({
                url: "{{ route('restaurants.filter') }}",
                method: 'GET',
                data: {
                    city: city,
                    name: name,
                    state: state,
                    delivery_zone: delivery_zone,
                    delivery_fee: delivery_fee
                },
                beforeSend: function () {
                    $('#restaurantResults').html('<div class="text-center my-5">Loading...</div>');
                },
                success: function (response) {
                    $('#restaurantResults').html(response.html);
                },
                error: function () {
                    $('#restaurantResults').html('<div class="text-danger text-center my-5">Something went wrong. Please try again.</div>');
                }
            });
        });
        $('#filterBtn').on('click', function () {
            $('#city').val('');
            $('#state').val('');
            $('#delivery_zone').val('');
            $('#delivery_fee').val('');
            $('#name').val('');

            $('#city, #state, #delivery_zone, #delivery_fee, #name').trigger('change');
        });

    });
</script>

@endsection

