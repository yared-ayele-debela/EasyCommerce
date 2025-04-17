<!DOCTYPE html>
<html lang="en">
    @php
    use App\Models\Restaurant\Product;
@endphp
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="{{ asset('restaurant_frontend/assets/css/index.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- In your Blade file -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
#search-results {
    position: absolute;
    z-index: 1000;
    max-height: 250px;
    overflow-y: auto;
    width: 100%;
    background: rgba(132, 254, 123, 0.2) !important; /* Semi-transparent */
    backdrop-filter: blur(10px) !important; /* Apply blur effect */
    border-radius: 10px;
    padding: 5px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.list-group-item {
    transition: 0.3s ease-in-out;
    background: rgba(132, 254, 123, 0.2) !important; /* Semi-transparent */
    backdrop-filter: blur(10px) !important; /* Apply blur effect */
    color:rgb(36, 36, 36);
}


.list-group-item:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}
.toggle-btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            background: #f3f3f3;
            border-radius: 50px;
            padding: 5px;
            width: 150px;
            height: 40px;
            box-shadow: 1px 0px 1px 2px rgba(247, 247, 247, 0.74);
            border: 1px solid #17BE18 !important;

        }

        .toggle {
            flex: 1;
            text-align: center;
            line-height: 30px;
            margin-right: 0% !important;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
            position: relative;
            z-index: 2;

        }

        .slider {
            position: absolute;
            top: 5px;
            bottom: 5px;
            left: 5px;
            width: 70px;
            background: linear-gradient(90deg, #17BE18, #32CB32) !important;
            border-radius: 50px;
            transition: left 0.3s ease;
            z-index: 1;
        }

        .active {
            color: #6C757D;
        }

        .toggle-btn .toggle:not(.active) {
            color: #3f3f3f;
        }

        .toggle-btn .toggle.active~.slider {
            left: 5px;
        }

        .toggle-btn .toggle:not(.active):nth-child(2)~.slider {
            left: calc(100% - 75px);
        }

        .toggle:hover {
            color: #191716;
        }
</style>
</head>

<body>

    <!-- Desktop Navbar (Shown on Large Screens) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light d-none d-lg-flex">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('restaurant_frontend/assets/img/logo.png') }}" alt="Logo" style="width: 80px;">
        </a>

        <!-- Search Bar -->
        <div class="mx-auto search-form border bg-white border-1 p-1 rounded rounded-3 text-primary rounded w-50">
            <form class="d-flex position-relative">
                <input class="form-control me-2 search-input border-0" id="search-box" type="search" placeholder="Search for products" aria-label="Search">
                {{-- <button class="btn search-button" type="submit"><i class="bi bi-search"></i></button> --}}
                <div id="search-results" class="list-group position-absolute w-100 shadow-sm bg-white rounded d-none" style="margin-top: 40px;"></div>

            </form>
        </div>

        <!-- Wishlist, Cart, and Sign-in -->
        <div class="d-flex align-items-center">
            @php
                $wishlistCount = Auth::check() ? \App\Models\Restaurant\Wishlist::where('user_id', Auth::id())->count() : 0;
            @endphp
            <a href="{{ route('restaurant.wishlist.index') }}" class="text-decoration-none me-3 text-primary">
                <i class="bi bi-heart" style="font-size: 20px;">
                </i>
                <span id="wishlist-count">
                    {{ $wishlistCount }}
                </span>

            </a>
            <a  href="{{ route('restaurant.cart.count') }}"  data-bs-toggle="offcanvas" data-bs-target="#carInfoOffcanvas"  class="text-decoration-none me-3 text-primary">
                <i class="bi bi-cart" style="font-size: 20px;"></i>
                <span class="cart-count" id="cartCount">
                    {{ count(session('cart', [])) }}
                </span>
            </a>
            <div class="dropdown">

                    @if(Auth::check())
                    <a class="btn text-dark border border-0 p-1 d-flex align-items-center gap-1" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_photo_path)
                          <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" width="38" class="rounded-circle m-1 border border-3 shadow" alt="Profile Image">
                        @endif
                    </a>
                    @else

                    <div class="toggle-btn d-none d-lg-flex">
                        <a href="{{ route('auth.login') }}" class="toggle active" id="login">Login</a>
                        <a href="{{ route('auth.login') }}" class="toggle text-white" id="signup">
                            SignUp
                        </a>
                        <div class="slider"></div>
                    </div>
                    @endif


                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded" aria-labelledby="accountDropdown">
                    @if(Auth::check())
                        <li class="mb-2">
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ url('user/account/update') }}">
                                <i class="fas fa-cog text-primary"></i> My Profile
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ url('my-orders') }}">
                                <i class="far fa-heart text-primary"></i> My Orders
                            </a>
                        </li>

                        <li class="mb-2">
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="{{ url('user/logout') }}">
                                <i class="far fa-check-circle"></i> Logout
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('auth.login') }}">
                                <i class="fas fa-sign-in-alt text-success"></i> Login / Signup
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0);">
                                <i class="fas fa-user-tie text-primary"></i> Become a Vendor
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navbar (Shown on Small Screens) -->
<nav class="navbar navbar-light bg-light d-flex d-lg-none p-2">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('restaurant_frontend/assets/img/logo.png') }}" alt="Logo" style="width: 60px;">
        </a>

        <!-- Wishlist, Cart, and Sign-in -->
        <div class="d-flex align-items-center">
            <a href="whishlist.html" class="text-decoration-none me-3 text-primary">
                <i class="bi bi-heart" style="font-size: 18px;"></i>
            </a>
            <a href="cart.html" class="text-decoration-none me-3 text-primary">
                <i class="bi bi-cart" style="font-size: 18px;"></i>
            </a>
            <div class="dropdown">
                <a class="btn text-dark border border-0 p-1 d-flex align-items-center gap-1" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::check())
                        @if(Auth::user()->profile_photo_path)
                          <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" width="28" class="rounded-circle" alt="Profile Image">
                        @endif
                    @else
                        Login/Register
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded" aria-labelledby="accountDropdown">
                    @if(Auth::check())
                        <li class="mb-2">
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ url('user/account/update') }}">
                                <i class="fas fa-cog text-primary"></i> My Profile
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ url('my-orders') }}">
                                <i class="far fa-heart text-primary"></i> My Orders
                            </a>
                        </li>
                        <li class="mb-2">
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="{{ url('user/logout') }}">
                                <i class="far fa-check-circle"></i> Logout
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('auth.login') }}">
                                <i class="fas fa-sign-in-alt text-success"></i> Login / Signup
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:void(0);">
                                <i class="fas fa-user-tie text-primary"></i> Become a Vendor
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Search Bar (Full Width for Mobile) -->
    <div class="container mt-2">
        <div class="search-form border border-1 p-1 rounded w-100">
            <form class="d-flex">
                <input class="form-control me-2 search-input border-0" type="search" placeholder="Search for products" aria-label="Search">
                <button class="btn search-button" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="carInfoOffcanvas" aria-labelledby="carInfoLabel">
    <div class="offcanvas-header">
        <h5 id="carInfoLabel">Car Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="cartDetails">
            @if(session('cart') && count(session('cart')) > 0)
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach(session('cart') as $key => $item)
                        @php
                        $product=Product::find($item['product_id']);
                        if (!$product) continue; // Skip if product not found
                            $itemSubtotal = $item['price'] * $item['quantity'];
                            $subtotal += $itemSubtotal;
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $product['image']) }}" alt="Product Image" style="width: 50px; height: 50px;">
                                    <span class="ms-2">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($item['price'], 2) }} Birr</td>
                            <td>
                               <p>{{ $item['quantity'] }} x</p>
                            </td>
                            <td>{{ number_format($itemSubtotal, 2) }} Birr</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <p><strong>Subtotal:</strong> {{ number_format($subtotal, 2) }} Birr</p>
            <hr>
            <div class="d-flex justify-content-between">
                <a href="" class="btn btn-secondary rounded rounded-1  mt-2">Proceed to Checkout</a>
                <a href="{{ route('restaurant.cart.view') }}" class="btn bg-primary  rounded rounded-1 text-white mt-2">View Cart</a>
            </div>
        @else
            <p class="text-center">Your cart is empty.</p>
        @endif
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#search-box').on('keyup', function () {
            let query = $(this).val();

            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: { query: query },
                    success: function (data) {
                        let results = '';
                        if (data.length > 0) {
                            data.forEach(product => {
                                results += `<a href="/restaurant/product-detail/${product.id}" class="list-group-item list-group-item-action">
                                            <strong>${product.name}</strong> - ${product.description.substring(0, 50)}...
                                        </a>`;
                            });
                        } else {
                            results = `<div class="list-group-item text-muted">No results found</div>`;
                        }
                        $('#search-results').html(results).removeClass('d-none');
                    }
                });
            } else {
                $('#search-results').addClass('d-none');
            }
        });

        // Hide search results when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#search-box, #search-results').length) {
                $('#search-results').addClass('d-none');
            }
        });
    });
</script>
