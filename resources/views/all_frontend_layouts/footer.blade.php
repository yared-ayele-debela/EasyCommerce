@php
use App\Models\AppSetting;
use App\Models\CmsPage;
$cms_pages = CmsPage::all()->toArray();
$appsettings=AppSetting::all()->toArray();

@endphp
<footer class="bg-primary pt-5 pb-3 d-none d-md-block">
    <div class="container-fluid">
        <form class="newsletter-form" id="newsletterForm">
            @csrf
            <div class="row d-flex justify-content-center align-items-center mb-4">
                <div class="col-12 col-md-4 text-center">
                    <h4 class="text-white">Exclusive Subscribe</h4>
                    <p class="text-white">Get 10% off your first order</p>
                    <div class="d-flex justify-content-center align-items-center newsletter-container p-2 rounded">
                        <input type="email" class="form-control newsletter-input me-2 border-0" id="newsletterEmail" name="email" placeholder="Enter your email">
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
                <p class="text-white"> {{ $appsettings[0]['panel_footer_text'] }} Developed by <a href="https://www.afroel.com" target="_blank" class="text-white">Afroel Technologies</a></p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS (Optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('restaurant_frontend/assets/js/index.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    let pages = 1;
    let loadings = false;

    function loadMoreRestaurants() {
        if (loadings) return;

        loadings = true;
        $('#restaurant_loading').show();
        pages++;

        $.ajax({
            url: "{{ route('fetch.restaurants') }}?page=" + pages
            , type: "GET"
            , success: function(data) {
                if (data.trim().length === 0) {
                    $(window).off('scroll');
                    $('#restaurant_loading').html('<p class="text-muted">No more restaurants.</p>');
                    return;
                }
                $('#auto-restaurant-container').append(data);
                $('#restaurant_loading').hide();
                loadings = false;
            }
            , error: function() {
                $('#restaurant_loading').html('<p class="text-danger">Something went wrong.</p>');
            }
        });
    }

    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            loadMoreRestaurants();
        }
    });

</script>
<script>
    let page = 1;
    let loading = false;

    function loadMoreProducts() {
        if (loading) return;

        loading = true;
        $('#loading').show();
        page++;

        $.ajax({
            url: "{{ route('fetch.products') }}?page=" + page
            , type: "GET"
            , success: function(data) {
                if (data.trim().length === 0) {
                    $(window).off('scroll');
                    $('#loading').html('<p class="text-muted">No more products.</p>');
                    return;
                }
                $('#product-container').append(data);
                $('#loading').hide();
                loading = false;
            }
            , error: function() {
                $('#loading').html('<p class="text-danger">Something went wrong.</p>');
            }
        });
    }

    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            loadMoreProducts();
        }
    });

</script>

<script>
    function updateCartCount() {
        fetch("{{ route('cart.count') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById("cart-count").innerText = data.total;
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
                document.getElementById("cart-count").innerText = '0';
            });
    }

    function updateTotalWishlistCount() {
        Promise.all([
                fetch("{{ route('count-ecommerce-wishlist') }}").then(res => res.json())
                , fetch("{{ route('wishlist.count') }}").then(res => res.json())
            ])
            .then(([ecommerceData, restaurantData]) => {
                const totalCount = (ecommerceData.count || 0) + (restaurantData.count || 0);
                document.getElementById("wishlist-count").innerText = totalCount;
            })
            .catch(error => {
                console.error('Error fetching wishlist counts:', error);
                document.getElementById("wishlist-count").innerText = '0'; // fallback
            });
    }



    $(document).ready(function() {
        $('.wishlist-btn').click(function(e) {
            e.preventDefault();

            let button = $(this);
            let productId = button.data('product-id');

            $.ajax({
                url: "{{ route('wishlist.toggle') }}", // Define this route
                type: "POST"
                , data: {
                    product_id: productId
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    if (response.status === 'added') {
                        button.find('i').removeClass('far').addClass('fas text-primary');
                        showAlert('success', 'Product added to wishlist');

                    } else if (response.status === 'removed') {
                        button.find('i').removeClass('fas text-primary').addClass('far');
                        showAlert('success', 'Product removed from wishlist');
                    }
                    updateTotalWishlistCount();
                }
                , error: function(xhr) {
                    if (xhr.status === 401) {
                        // User is not authenticated
                        showAlert('error', 'Please login to manage your wishlist.');

                    } else {
                        showAlert('error', 'Something went wrong. Please try again.');
                    }
                }
            });
        });
    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        updateTotalWishlistCount();
        updateCartCount();
    });

</script>

<script>
    $(document).ready(function() {
        $('#newsletterForm').on('submit', function(e) {
            e.preventDefault();
            var email = $('#newsletterEmail').val();
            $.ajax({
                url: '/subscribe-newsletter'
                , type: 'POST'
                , data: {
                    email: email
                    , status: 1
                    , _token: $('meta[name="csrf-token"]').attr('content')
                }
                , success: function(response) {
                    showAlert('success', response.message);
                    email = ''; // Clear the input field
                    $('#newsletterEmail').val('');
                }
                , error: function(xhr) {
                    let message = xhr.responseJSON ? .message || 'Subscription failed.';
                    showAlert('info', message);
                    $('#newsletterEmail').val('');

                }
            });
        });
    });

</script>
<script>
    // Toggle subcategories on click for mobile
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth < 992) {
            document.querySelectorAll('.category-list li').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Prevent toggling when clicking inside dropdown
                    if (e.target.closest('.subcategory-dropdown')) return;

                    // Close others
                    document.querySelectorAll('.category-list li').forEach(li => {
                        if (li !== item) li.classList.remove('active');
                    });

                    // Toggle current
                    item.classList.toggle('active');
                });
            });
        }
    });

</script>
<script>
    const toggleIcon = document.querySelector("#categoryToggle i");
    const categoryList = document.getElementById("categoryList");

    document.getElementById("categoryToggle").addEventListener("click", () => {
        categoryList.classList.toggle("d-none");
        toggleIcon.classList.toggle("bi-toggle-on");
        toggleIcon.classList.toggle("bi-toggle-off");
    });

</script>

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
                        updateTotalWishlistCount();
                    });
            });
        });

    });

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
    $('.ecommerce_products').owlCarousel({
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
                items: 5
            }
        }
    });
    $('.vendors').owlCarousel({
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
                items: 4
            }
        }
    });
    $('.ecommerce_sliders').owlCarousel({
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
    $('.ecommerce_categories').owlCarousel({
        loop: true
        , margin: 30
        , nav: false
        , dots: true
        , autoplay: true
        , autoplayHoverPause: true // Stops autoplay when hovered
        , responsiveClass: true
        , responsive: {
            0: {
                items: 3
                , nav: false
            }
            , 1024: {
                items: 6
            }
        }
    });
    $('.hotel').owlCarousel({
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
                items: 4
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

        let formData = new FormData(this);
        fetch("{{ route('restaurant.rate') }}", {
                method: "POST"
                , headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
                , body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    showAlert('success', "Rating submitted successfully!");
                    $('#ratingModal').modal('hide'); // Close the modal
                    $('#ratingForm')[0].reset(); // Reset the form fields
                } else {
                    showAlert('info', "Error: " + data.message);
                }
            })
            .catch(error => {
                showAlert('info', "An error occurred. Please try again later.");
            });
    });

    document.getElementById('addToCart').addEventListener('click', function() {
        let productId = this.getAttribute('data-product-id');
        let selectedSize = document.querySelector('input[name="size"]:checked');
        let quantity = document.getElementById('quantity').value;
        if (!selectedSize) {
            showAlert('info', 'Please select a size!');
            return;
        }
        let price = selectedSize.getAttribute('data-price');
        let size = selectedSize.getAttribute('data-size');

        fetch("{{ route('restaurant.cart.add') }}", {
                method: "POST"
                , headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    , "Content-Type": "application/json"
                }
                , body: JSON.stringify({
                    product_id: productId
                    , size: size
                    , price: price
                    , quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                showAlert(data.status, data.message);
                updateCartCount(); // Update cart count after adding item

            })
            .catch(error => console.error("Error:", error));
    });

</script>
</body>
</html>
