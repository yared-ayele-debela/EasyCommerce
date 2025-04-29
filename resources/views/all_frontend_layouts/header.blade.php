<!DOCTYPE html>
<html lang="en">
@php
use App\Models\Restaurant\Product;
use App\Models\AppSetting;
$appsetting = AppSetting::first();
use Illuminate\Support\Facades\Storage;

@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appsetting['tiltle'] }}</title>
    <link href="{{ asset('/storage/appsettings/'.$appsetting['favicon']) }}" rel="shortcut icon">
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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @media (max-width: 768px) {
            .custom-order-btn {
                font-size: 9px;
                padding-right: 3px;
                padding-left: 3px;
            }
        }

        #search-results {
            position: absolute;
            z-index: 1000;
            max-height: 250px;
            overflow-y: auto;
            width: 100%;
            background: rgba(132, 254, 123, 0.2) !important;
            /* Semi-transparent */
            backdrop-filter: blur(10px) !important;
            /* Apply blur effect */
            border-radius: 10px;
            padding: 5px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

        .custom-nav-active {
            color: #17BE18 !important;
            font-weight: 600 !important;
            border-bottom: 2px solid #17BE18 !important;
        }

    </style>
</head>

<body>

    <header>
        <!-- Top Bar -->
        <div class="bg-light border-bottom py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <small class="me-3 text-muted"><i class="bi bi-telephone-fill text-primary me-1"></i>{{ $appsetting['phone_no'] }}</small>
                    <small class="me-3 text-muted"><i class="bi bi-envelope-fill text-primary me-1"></i>{{ $appsetting['email_address'] }}</small>
                </div>
                <div class="d-flex align-items-center">
                    {{-- <div class="dropdown me-3">
                <a class="text-muted dropdown-toggle text-decoration-none small" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Language</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">English</a></li>
                  <li><a class="dropdown-item" href="#">Amharic</a></li>
                </ul>
              </div> --}}
                    <div>
                        <button type="button" class="btn btn-primary btn-sm me-2 custom-order-btn" data-bs-toggle="modal" data-bs-target="#customOrder">
                            Custom Order
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="py-2 py-md-3 bg-white shadow-sm">
            <div class="container d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('restaurant_frontend/assets/img/logo.png') }}" alt="Logo" style="height: 40px;">
                </a>

                <form class="d-none d-md-flex w-50 mx-4">
                    <div class="input-group position-relative">
                        <input class="form-control border-1  search-input" id="search-box" type="search" placeholder="Search for products">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                    <div id="search-results" class="list-group position-absolute w-100 shadow-sm bg-white rounded d-none" style="top: 100%; z-index: 999;"></div>
                </form>

                <!-- Icons -->
                <div class="d-flex align-items-center">

                    @php
                    $wishlistCount = Auth::check() ? \App\Models\Restaurant\Wishlist::where('user_id', Auth::id())->count() : 0;
                    $ecommerce_wishlistCount = Auth::check() ? \App\Models\Wishlist::where('user_id', Auth::id())->count() : 0;
                    $sessionCount = count(session('cart', []));
                    $helperCount = \App\Helper\Helper::totalCartItems();
                    $cartCount = $sessionCount + $helperCount;
                    @endphp

                    <a href="{{ route('restaurant.wishlist.index') }}" class="btn btn-light btn-sm position-relative me-2">
                        <i class="bi bi-heart text-primary fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            {{ $wishlistCount + $ecommerce_wishlistCount }}
                        </span>
                    </a>
                    <a href="{{ url('my-cart') }}" class="btn btn-light btn-sm position-relative me-2">
                        <i class="bi bi-cart text-primary fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            {{ $cartCount }}
                        </span>
                    </a>

                    @if(Auth::check())
                    <div class="dropdown">
                        <a class="btn btn-light btn-sm" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" width="28" class="rounded-circle border shadow-sm">
                            @else
                            <i class="bi bi-person-circle fs-5"></i>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ url('user/account/update') }}"><i class="bi bi-gear text-primary"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ url('my-orders') }}"><i class="bi bi-bag text-primary"></i> My Orders</a></li>
                            <li><a class="dropdown-item" href="{{ url('my-delivery-addresses') }}"><i class="bi bi-geo-alt text-primary"></i> My Addresses</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ url('user/logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('auth.login') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-person-circle fs-5 text-primary"></i>
                    </a>
                    @endif
                    <button class="btn btn-light d-lg-none btn-sm ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
                        <i class="bi bi-list fs-2"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Desktop Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-top shadow-sm d-none d-lg-block">
            <div class="container">
                <div class="collapse navbar-collapse show">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link {{ request()->is('/')?' custom-nav-active':'' }}" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('blogs')?' custom-nav-active':'' }}" href="{{ url('blogs') }}">Blog</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('faq')?' custom-nav-active':'' }}" href="{{ url('faq') }}">FAQ</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('contact')?' custom-nav-active':'' }}" href="{{ url('contact') }}">Contact</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('ecommerce/vendors')?' custom-nav-active':'' }}" href="{{ url('ecommerce/vendors') }}">Vendors</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Offcanvas Mobile Menu -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileMenuLabel">
                    <img src="{{ asset('restaurant_frontend/assets/img/logo.png') }}" alt="Logo" style="height: 40px;">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/')?' custom-nav-active':'' }}" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('blogs')?' custom-nav-active':'' }}" href="{{ url('blogs') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('faq')?' custom-nav-active':'' }}" href="{{ url('faq') }}">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact')?' custom-nav-active':'' }}" href="{{ url('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('ecommerce/vendors')?' custom-nav-active':'' }}" href="{{ url('ecommerce/vendors') }}">Vendors</a></li>
                </ul>
            </div>
        </div>
    </header>
    @include('all_frontend_layouts.custom_order.index')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search-box').on('keyup', function() {
                let query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: "{{ route('search') }}"
                        , type: "GET"
                        , data: {
                            query: query
                        }
                        , success: function(data) {
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
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#search-box, #search-results').length) {
                    $('#search-results').addClass('d-none');
                }
            });
    });
    </script>
