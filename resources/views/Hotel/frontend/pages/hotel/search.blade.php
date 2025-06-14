@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Hotels</h5>
    </div>
    <div class="offer-card shadow-sm rounded-4 p-3 mb-4 bg-white">
        <h4 class="mb-3"><i class="bi bi-funnel-fill me-2 text-primary"></i> Advanced Hotel Filters</h4>
        <div class="row mb-4">
            <div class="col-md-3 mb-2">
                <div class="form-group">
                    <label for="search" class="form-label">Hotel Name</label>
                    <div class="input-group">
                        <input type="text" id="search" class="form-control" placeholder="Search by hotel name">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="min_price" class="form-label">Min Price</label>
                    <div class="input-group">
                        <span class="input-group-text">ETB</span>
                        <input type="number" id="min_price" class="form-control" placeholder="Min Price">
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="max_price" class="form-label">Max Price</label>
                    <div class="input-group">
                        <span class="input-group-text">ETB</span>
                        <input type="number" id="max_price" class="form-control" placeholder="Max Price">
                    </div>
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="rating" class="form-label">Min Rating</label>
                    <div class="input-group">
                        <input type="number" id="rating" class="form-control" placeholder="Min Rating" min="1" max="5">
                        <span class="input-group-text"><i class="bi bi-star"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" class="form-select">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="country" class="form-label">Country</label>
                    <select id="country" class="form-select">
                        <option value="">Select country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="state" class="form-label">State</label>
                    <select id="state" class="form-select">
                        <option value="">Select state</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->name }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="form-group">
                    <label for="city" class="form-label">City</label>
                    <select id="city" class="form-select">
                        <option value="">Select city</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <label for="" class="pt-4"></label>
                <div class="form-check form-switch">
                    <input class="form-check-input amenity-filter" type="checkbox" value="1" id="is_featured">
                    <label class="form-check-label badge bg-primary text-light px-3 py-2" for="is_featured">
                        Featured
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="hotel-list"></div>
</div>
<script>
    function fetchHotels() {
    // Gather selected filters
    const selectedCategory = $('#category').val();
    const selectedCountry = $('#country').val();
    const selectedState = $('#state').val();
    const selectedCity = $('#city').val();
    const selectedRating = $('#rating').val();
    const selectedMinPrice = $('#min_price').val();
    const selectedMaxPrice = $('#max_price').val();
    const selectedIsFeatured = $('#is_featured').is(':checked') ? 1 : 0;
    const search = $('#search').val();

    // AJAX request to fetch filtered hotels
    $.ajax({
        url: '{{ route('hotels.filter') }}',
        method: 'GET',
        data: {
            search: search,
            min_price: selectedMinPrice,
            max_price: selectedMaxPrice,
            rating: selectedRating,
            category: selectedCategory,
            country: selectedCountry,
            state: selectedState,
            city: selectedCity,
            is_featured: selectedIsFeatured,
        },
        success: function(response) {
            let html = '';
            if (response.hotels.length === 0) {
                html = '<div class="col-12"><p>No hotels found.</p></div>';
            } else {
                response.hotels.forEach(hotel => {
                    html += `
                    <div class="col-md-3 mb-4">
                        <div class="offer-card h-100">
                             <a href="{{ url('hotel/${hotel.id}/detail') }}">
                            <img src="${hotel.banner_image}" class="card-img-top" alt="Hotel Image" style="height:200px; object-fit:cover;">
                            </a>
                            <div class="card-body">
                                <span class="badge bg-primary mt-0">${hotel.category.name}</span>
                                <h5 class="card-title">${hotel.name}</h5>
                                <p class="card-text">
                                    <a  href="https://www.google.com/maps?q= ${hotel.latitude},${hotel.longitude}"
                                    target="_blank" class="small text-muted mb-2">
                                    Location: ${hotel.state}, ${hotel.city} ${hotel.location}<br>
                                    </a>
                                    Price per Night: <strong>${hotel.price_per_night} ETB</strong><br>
                                    Rating: <strong>${hotel.rating} <i class="bi bi-star-fill text-primary"></i></strong><br>
                                </p>
                                <p class="card-text">${hotel.description.substring(0, 120)}...</p>
                            </div>
                        </div>
                    </div>`;
                });
            }
            $('#hotel-list').html(html);
        }
    });
}

// Trigger the fetch when filters change
$('#search, #min_price, #max_price, #rating, #category, #country, #state, #city').on('input', fetchHotels);
$('#is_featured, #is_active').on('change', fetchHotels);
$(document).ready(fetchHotels);
</script>
@endsection

