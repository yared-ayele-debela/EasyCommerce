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
        </form>
    </div>


    </div>
    </div>
    </form>

    <!-- Footer Content Sections -->
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-3 text-center mb-4 mb-md-0">
            <img src="{{ asset('restaurant_frontend/assets/img/icon.png') }}" alt="Logo" class="img-fluid footer-image">
        </div>

        <div class="col-6 col-md-2">
            <h5 class="text-uppercase text-white">Customer Support</h5>
            <ul class="list-unstyled">
                <li><a href="#" class="text-white">Bole, Addis Abab</a></li>
                <li><a href="#" class="text-white">easy@gmail.com</a></li>
                <li><a href="#" class="text-white">091011212</a></li>
            </ul>
        </div>

        <div class="col-6 col-md-2">
            <h5 class="text-uppercase text-white">Account</h5>
            <ul class="list-unstyled">
                <li><a href="#" class="text-white">My Account</a></li>
                <li><a href="#" class="text-white">Login / Register</a></li>
            </ul>
        </div>

        <div class="col-6 col-md-2">
            <h5 class="text-uppercase text-white">Quick Links</h5>
            <ul class="list-unstyled">
                <li><a href="#" class="text-white">Privacy Policy</a></li>
                <li><a href="#" class="text-white">Terms Of Use</a></li>
                <li><a href="#" class="text-white">FAQ</a></li>
                <li><a href="#" class="text-white">Contact</a></li>
            </ul>
        </div>

        <!-- Download App Section -->
        <div class="col-6 col-md-3">
            <h5 class="text-uppercase text-white">Download App</h5>
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
            <div class="d-flex justify-content-start">
                <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <!-- Copyright Section -->
    <div class="row pt-3">
        <div class="col text-center">
            <p class="text-white">&copy; 2025 easybuy. All Rights Reserved.</p>
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

        // Function to move the slider
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
    document.getElementById('submitRating').addEventListener('click', function () {
        let ratingValue = document.querySelector('input[name="rating"]:checked');
        let review= document.getElementById('review').value;
        let restaurantId = document.getElementById('restaurant_id').value;


        if (!ratingValue) {
            showAlert('info', 'Please select a rating.');
            return;
        }

        // Check if user is logged in
        fetch("{{ route('restaurant.rate') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                restaurant_id: restaurantId, // Replace with actual restaurant ID
                rating: ratingValue.value,
                review: review
            })
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = "{{ route('auth.login') }}";
            }
            return response.json();
        })
        .then(data =>{
            if (data.status === "error") {
                showAlert('info', data.message);
                setTimeout(() => {
                    alert("hello");
                let modal = new bootstrap.Modal('#ratingModal');
                modal.hide(); // Close modal after successful rating
            }, 1000);
            } else if (data.status === "success") {
                showAlert('success', data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>

</body>

</html>

