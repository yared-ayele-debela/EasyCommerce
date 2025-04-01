@php
    use App\Models\AppSetting;
    use App\Models\CmsPage;
    $cms_pages = CmsPage::all()->toArray();
    $appsettings=AppSetting::all()->toArray();

@endphp
<footer class="bg-primary pt-5 pb-3">
    <div class="container-fluid">
        <!-- Exclusive Subscribe Section -->
        <form class="newsletter-form" action="{{ url('newslettersubscriber') }}" method="POST">
            @csrf
            <div class="row d-flex justify-content-center align-items-center mb-4">
                <div class="col-12 col-md-4 text-center">
                    <h4 class="text-white">Exclusive Subscribe</h4>
                    <p class="text-white">Get 10% off your first order</p>
                    <div class="d-flex justify-content-center align-items-center newsletter-container p-2 rounded">

                        <input type="email" class="form-control newsletter-input me-2 border-0" name="email" placeholder="Enter your email">
                        <button type="submit" class="btn newsletter-button">SUBMIT</button>
                    </div>
                </div>
            </div>
        </form>

    <!-- Footer Content Sections -->
    <div class="row d-flex justify-content-center align-items-center align-items-stretch">
        <div class="col-12 col-md-3 text-center mb-4 mb-md-0">
            <img src="{{ asset('restaurant_frontend/assets/img/icon.png') }}" alt="Logo" class="img-fluid footer-image">
        </div>

        <div class="col-6 col-md-2">
            <h5 class="text-uppercase text-white">Address</h5>
            <ul class="list-unstyled">
                <li class="mb-2"><a href="javascript:void(0)" class="text-white">{{ $appsettings[0]['address'] }}</a></li>
                <li class="mb-2"><a href="{{ $appsettings[0]['email_address'] }}" target="_blank" class="text-white">{{ $appsettings[0]['email_address'] }}</a></li>
                <li class="mb-2"><a href="{{ $appsettings[0]['phone_no'] }}" target="_blank" class="text-white">{{ $appsettings[0]['phone_no'] }}</a></li>
            </ul>
        </div>

        <div class="col-6 col-md-2">
            <h5 class="text-uppercase text-white">Customer Service</h5>
            <ul class="list-unstyled">
                @foreach ($cms_pages as $page)
                <li class="text-white mb-2"><a href="{{ url('page/'.$page['url']) }}" class="text-white">{{ $page['title'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-6 col-md-2">
            <h5 class="text-uppercase text-white top-0">Quick Links</h5>
            <ul class="list-unstyled">
                <li class="mb-2"><a href="{{ url('/') }}" class="text-white ">Home</a></li>
                <li class="mb-2"><a href="{{ url('faq') }}" class="text-white ">FAQ</a></li>
                <li class="mb-2"><a href="{{ url('contact') }}" class="text-white ">Contact</a></li>
            </ul>
        </div>

        <!-- Download App Section -->
        <div class="col-6 col-md-3">
            <h5 class="text-uppercase text-white top-0">Download App</h5>
            <div class="row mb-2">
                <div class="col-4 col-md-4">
                    <img src="{{ asset('restaurant_frontend/assets/img/qr.jpeg') }}" alt="QR Code" class="img-fluid">
                </div>
                <div class="col-8 col-md-8">
                    <div class="d-grid gap-2 col-8 mx-auto">
                        <img src="{{ asset('restaurant_frontend/assets/img/playstore.png') }}" alt="Google Play" class="img-fluid" style="width: 100px;">
                        <img src="{{ asset('restaurant_frontend/assets/img/appstore.png') }}" alt="App Store" class="img-fluid" style="width: 100px;">
                    </div>
                </div>
            </div>
            @php
            $facebookUrl = $appsettings[0]['facebook'];
            $twitter = $appsettings[0]['twitter'];
            $youtube = $appsettings[0]['youtube'];
            $whatsapp = $appsettings[0]['whatsapp'];


            // Check if the URL has a scheme, if not, prepend 'http://'
            if (!Str::startsWith($facebookUrl, ['http://', 'https://'])) {
                $facebookUrl = 'http://' . $facebookUrl;
            }
            if (!Str::startsWith($twitter, ['http://', 'https://'])) {
                $twitter = 'http://' . $twitter;
            } if (!Str::startsWith($youtube, ['http://', 'https://'])) {
                $youtube = 'http://' . $youtube;
            } if (!Str::startsWith($whatsapp, ['http://', 'https://'])) {
                $whatsapp = 'http://' . $whatsapp;
            }

        @endphp

            <div class="d-flex justify-content-start">
                <a href="{{$facebookUrl }}" class="text-white me-3" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="{{ $twitter }}" class="text-white me-3" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="{{ $youtube }}" class="text-white me-3" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="{{ $whatsapp }}" class="text-white me-3" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="row pt-3">
        <div class="col text-center">
            <p class="text-white">{{ $appsettings[0]['panel_footer_text'] }}</p>
        </div>
    </div>
</div>
</footer>
<!-- Bootstrap 5 JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('restaurant_frontend/assets/js/index.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    function showAlert(type, message) {
        Swal.fire({
            title: type === 'success' ? '🎉 Success!' : '⚠️ Oops!'
            , text: message
            , icon: type
            , showConfirmButton: false
            , timer: 2000
            , toast: true
            , position: 'top-end'
        });
    }

    function updateWishlistCount() {
        fetch("{{ route('wishlist.count') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById("wishlist-count").innerText = data.count;
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateWishlistCount();
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".add-to-wishlist").forEach(button => {
            button.addEventListener("click", function() {
                let productId = this.getAttribute("data-product");
                let icon = this.querySelector("i");
                if (!@json(Auth::check())) {
                    Swal.fire({
                        title: "Login Required!"
                        , text: "Please log in to add items to your wishlist."
                        , icon: "info"
                        , confirmButtonText: "OK"
                    , });
                    return;
                }
                fetch("{{ route('restaurant.wishlist.add') }}", {
                        method: "POST"
                        , headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            , "Content-Type": "application/json"
                        }
                        , body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.added) {
                            showAlert('success', 'Item added to your wishlist 💖');
                            icon.classList.remove("bi-heart");
                            icon.classList.add("bi-heart-fill");
                        } else {
                            showAlert('error', 'Item removed from your wishlist 💔');
                            icon.classList.remove("bi-heart-fill");
                            icon.classList.add("bi-heart");
                        }
                        updateWishlistCount();
                    });
            });
        });

    });

</script>
<script>
    function updateCartCount() {
        fetch('/restaurant/cart/count')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cartCount').innerText = data.count;
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }

</script>
<script>
    $('.products').owlCarousel({
        loop: true
        , margin: 30
        , nav: false
        , dots: true
        , autoplay: true
        , autoplayHoverPause: true // Stops autoplay when hovered
        , responsiveClass: true
        , responsive: {
            0: {
                items: 2
                , nav: false
            }
            , 1024: {
                items: 6
            }
        }
    });
    $('.imgs').owlCarousel({
        loop: true
        , margin: 30
        , nav: false
        , dots: true
        , autoplay: true
        , autoplayHoverPause: true // Stops autoplay when hovered
        , responsiveClass: true
        , responsive: {
            0: {
                items: 1
                , nav: false
            }
            , 1024: {
                items: 1
            }
        }
    });
    $('.categories').owlCarousel({
        loop: true
        , margin: 30
        , nav: false
        , dots: true
        , autoplay: true
        , autoplayHoverPause: true // Stops autoplay when hovered
        , responsiveClass: true
        , responsive: {
            0: {
                items: 4
                , nav: false
            }
            , 1024: {
                items: 13
            }
        }
    });
    $('.sliders').owlCarousel({
        loop: true
        , margin: 30
        , nav: false
        , dots: true
        , autoplay: true
        , autoplayHoverPause: true // Stops autoplay when hovered
        , responsiveClass: true
        , responsive: {
            0: {
                items: 1
                , nav: false
            }
            , 1024: {
                items: 3
            }
        }
    });
    $('.pro').owlCarousel({
        loop: true
        , margin: 30
        , nav: false
        , dots: true
        , autoplay: true
        , autoplayHoverPause: true // Stops autoplay when hovered

        , responsiveClass: true
        , responsive: {
            0: {
                items: 1
                , nav: false
            }
            , 1024: {
                items: 1
            }
        }
    });

</script>
<script>
    $(document).ready(function() {
        let currentIndex = 0;
        const totalProducts = $('.product').length;
        const productsToShow = 3;

        function moveSlider() {
            const offset = -(currentIndex * (100 / productsToShow)) + '%';
            $('.slider-wrapper').css('transform', 'translateX(' + offset + ')');
        }
        $('#nextBtn').click(function() {
            currentIndex = (currentIndex + 1) % (totalProducts - productsToShow + 1);
            moveSlider();
        });
        $('#prevBtn').click(function() {
            currentIndex = (currentIndex - 1 + (totalProducts - productsToShow + 1)) % (totalProducts - productsToShow + 1);
            moveSlider();
        });
    });

</script>
<script>
    document.getElementById('ratingForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData= new FormData(this);
        fetch("{{ route('restaurant.rate') }}", {
                method: "POST"
                , headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                 body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    showAlert('success',"Rating submitted successfully!");
                    $('#ratingModal').modal('hide'); // Close the modal
                    $('#ratingForm')[0].reset(); // Reset the form fields
                } else {
                    showAlert('info',"Error: " + data.message);
                }
            })
            .catch(error => {
            showAlert('info',"An error occurred. Please try again later.");
        });
  });

</script>
</body>
</html>

