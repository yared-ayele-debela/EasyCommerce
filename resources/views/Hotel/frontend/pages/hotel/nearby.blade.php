@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Nearby Hotels</h5>
    </div>
        <div id="nearby-hotels">
            <p>Loading nearby hotels...</p>
        </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Send to server using AJAX
                fetch(`/get-nearby-hotels?lat=${lat}&lng=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById("nearby-hotels");
                        container.innerHTML = data.html; // server will send pre-rendered HTML
                        $('.owl-carousel.hotel').owlCarousel({
                            loop: true,
                            margin: 10,
                            nav: false,
                            responsive: {
                                0: {
                                    items: 1
                                },
                                600: {
                                    items: 2
                                },
                                1000: {
                                    items: 4
                                }
                            }
                        });
                    });
            });
        } else {
            console.log("Geolocation not supported");
        }
    });
    </script>
@endsection
