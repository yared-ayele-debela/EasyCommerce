@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>

        <div class="d-flex align-items-center gap-2">
                    <h5 class="my-4 text-dark text-center">Nearby Hotels</h5>

            <label for="radiusInput" class="mb-0">Radius (km):</label>
            <input type="number" id="radiusInput" name="radius" value="100" min="1" max="100" step="1" class="form-control form-control-sm" style="width: 80px;">
            <button id="searchRadiusBtn" class="btn btn-primary btn-sm">Search</button>
                    <form action="{{ url('nearby-hotels') }}" method="GET">
            @csrf

        </form>
        </div>
    </div>
        <div id="nearby-hotels">
            <p>Loading nearby hotels...</p>
        </div>
</div>
<script>
   document.addEventListener("DOMContentLoaded", function() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Save user location to localStorage or just use it directly
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Optional: store them if you want
            localStorage.setItem('user_lat', lat);
            localStorage.setItem('user_lng', lng);

            // Initial fetch with default radius from input
            const radiusInput = document.getElementById('radiusInput');
            const radius = radiusInput.value || 30;

            function fetchHotels(radiusValue) {
                fetch(`/get-nearby-hotels?lat=${lat}&lng=${lng}&radius=${radiusValue}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById("nearby-hotels");
                        container.innerHTML = data.html;

                        $('.owl-carousel.hotel').owlCarousel({
                            loop: true,
                            margin: 30,
                            nav: true,
                            navText: [
                                '<button class="custom-prevs"><i class="bi bi-arrow-left"></i></button>',
                                '<button class="custom-nexts"><i class="bi bi-arrow-right"></i></button>'
                            ],
                            dots: false,
                            responsive: {
                                0: { items: 1 },
                                600: { items: 2 },
                                1000: { items: 4 }
                            }
                        });
                    });
            }

            // Fetch initially
            fetchHotels(radius);

            // Add event listener for radius search button
            document.getElementById('searchRadiusBtn').addEventListener('click', function() {
                const newRadius = document.getElementById('radiusInput').value || 30;
                fetchHotels(newRadius);
            });
        });
    } else {
        console.log("Geolocation not supported");
    }
});
    </script>
@endsection
