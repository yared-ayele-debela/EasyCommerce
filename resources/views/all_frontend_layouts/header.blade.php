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
    <link href="{{ $appsetting['favicon'] }}" rel="shortcut icon">
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
        .tooltip-wrapper {
  position: relative;
  display: inline-block;
}

.tooltip-wrapper::after {
  content: "Out of range product";
  position: absolute;
  bottom: 120%;
  left: 50%;
  transform: translateX(-50%);
  background-color: rgba(0, 0, 0, 0.75);
  color: #fff;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 13px;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s;
  z-index: 10;
}

.tooltip-wrapper:hover::after {
  opacity: 1;
}

        @media (max-width: 768px) {
            .custom-order-btn {
                font-size: 9px;
                padding-right: 3px;
                padding-left: 3px;
            }
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
            border: 1px solid #055935 !important;

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
            background: linear-gradient(90deg, #055935, #32CB32) !important;
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
            color: #055935 !important;
            font-weight: 600 !important;
            border-bottom: 2px solid #055935 !important;
        }

        .goog-te-banner-frame.skiptranslate,
        .goog-te-gadget-icon {
            display: none !important;
        }

        body {
            top: 0px !important;
        }

        .VIpgJd-ZVi9od-ORHb-OEVmcd {
            display: none !important;
        }

        .goog-te-gadget-simple {
            display: inline-block !important;
            font-weight: 400 !important;
            text-align: center !important;
            white-space: nowrap !important;
            vertical-align: middle !important;
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            border: 1px solid transparent !important;
            padding: .12rem .45rem !important;
            font-size: 1rem !important;
            line-height: 1.5 !important;
            border-radius: .25rem !important;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out !important;
            background-color: #055935 !important;
            color: white !important;
        }

        .goog-te-gadget-simple span a {
            color: white !important;
        }

        /* Remove Google icon */
        .goog-te-gadget-icon {
            display: none !important;
        }

        /* Dropdown arrow */
        .goog-te-gadget-simple span[aria-hidden="true"] {
            color: #fdfdfd !important;
        }

        /* Make sure the language menu is visible and styled */
        .VIpgJd-ZVi9od-vH1Gmf {
            display: block !important;
            visibility: visible !important;
            background-color: #fff !important;
            border: 1px solid #ddd !important;
            padding: 5px 0 !important;
            width: auto !important;
            min-width: 120px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            z-index: 9999 !important;
            font-family: Arial, sans-serif !important;
        }

        /* Style each language item */
        .VIpgJd-ZVi9od-vH1Gmf a {
            display: block !important;
            padding: 6px 12px !important;
            text-decoration: none !important;
            color: #333 !important;
            font-size: 14px !important;
            transition: background-color 0.2s ease-in-out;
        }

        /* On hover */
        .VIpgJd-ZVi9od-vH1Gmf a:hover {
            background-color: #f0f0f0 !important;
            color: #000 !important;
        }

        .with-bottom-nav {
            padding-bottom: 70px !important;
            /* Adjust this value based on nav height */
        }

        .responsive-form {
        width: 100%;
        margin-left: 0.25rem;  /* mx-1 ≈ 0.25rem on each side */
        margin-right: 0.25rem;
        position: relative;
        }

         .search-type{
            max-width: 100px !important;
        }
        @media (min-width: 768px) {
        .responsive-form {
            width: 50%;
            margin-left: 1.5rem;  /* mx-4 ≈ 1.5rem on each side */
            margin-right: 1.5rem;
            display: flex; /* equivalent to d-md-flex */
        }
        .search-type{
            max-width: 150px !important;
        }
        }

    .splash-screen {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      /* background: linear-gradient(to bottom right, #28e341, #ffffff); */
      color: #fff;
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
      z-index: 9999;
      transition: opacity 0.4s ease;
    }

    .splash-screen.active {
      display: flex;
    }

    .splash-logo {
      width: 100px;
      margin-bottom: 20px;
    }

    .splash-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .splash-desc {
      font-size: 1rem;
      margin-bottom: 30px;
    }

    .button-group {
      display: flex;
      justify-content: space-between;
      width: 100%;
      max-width: 300px;
      gap: 10px;
    }

    .btns {
      padding: 10px;
      flex: 1;
      background: #fff;
      color: #28e341;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .skip-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background: none;
      border: none;
      color: #fff;
      text-decoration: underline;
      font-weight: bold;
      cursor: pointer;
    }

    .main-content {
      display: none;
    }

    @media (min-width: 768px) {
      .splash-screen {
        display: none !important;
      }
    }
    </style>
</head>

<body>

<!-- Splash Screens -->
  <div class="splash-screen active" style="background-image: url({{ asset('restaurant_frontend/assets/img/2.jpg') }})" id="splash1">
    <button class="skip-btn" onclick="skipAll()">Skip</button>
    {{-- <img src="{{ asset(path: 'restaurant_frontend/assets/img/1.jpg') }}" alt="Logo" class="splash-logo" />
    <div class="splash-title">Welcome!</div>
    <div class="splash-desc">Discover amazing products at your fingertips.</div> --}}
    <div class="button-group">
      <button class="btns" disabled>Previous</button>
      <button class="btns" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash2" style="background-image: url({{ asset('restaurant_frontend/assets/img/3.jpg') }})">
    <button class="skip-btn" onclick="skipAll()">Skip</button>
    {{-- <img src="{{ asset('restaurant_frontend/assets/img/2.jpg') }}" alt="Logo" class="splash-logo" />
    <div class="splash-title">Fast Delivery</div>
    <div class="splash-desc">Get your orders quickly and reliably.</div> --}}
    <div class="button-group">
      <button class="btns" onclick="prevScreen()">Previous</button>
      <button class="btns" onclick="nextScreen()">Next</button>
    </div>
  </div>

  <div class="splash-screen" id="splash3" style="background-image: url({{ asset('restaurant_frontend/assets/img/4.jpg') }})">
    <button class="skip-btn" onclick="skipAll()">Skip</button>
    {{-- <img src="{{ asset('restaurant_frontend/assets/img/3.jpg') }}" alt="Logo" class="splash-logo" />
    <div class="splash-title">Get Started</div>
    <div class="splash-desc">Join us today and enjoy the best deals.</div> --}}
    <div class="button-group">
      <button class="btns" onclick="prevScreen()">Previous</button>
      <button class="btns" onclick="skipAll()">Start</button>
    </div>
  </div>

  <div class="main-content" id="main">


        <header>
            <!-- Top Bar -->
            <div class="bg-light border-bottom py-2">
                <div class="container">
                    <div class="row align-items-center text-center text-md-start">
                        <div class="col-md-6 d-none d-md-block  mb-2 mb-md-0">
                            <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-start align-items-center gap-2">
                                <small class="text-muted">
                                    <i class="bi bi-telephone-fill text-primary me-1"></i>{{ $appsetting['phone_no'] }}
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-envelope-fill text-primary me-1"></i>{{ $appsetting['email_address'] }}
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex flex-md-row justify-content-between justify-content-md-end align-items-center gap-2">
                                <div id="google_translate_element" class="text-md-end text-center"></div>

                                <a href="{{ url('track-custom-order') }}" class="btn btn-outline-primary btn-sm">
                                    Track Order
                                </a>

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#customOrder">
                                    Custom Order
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Main Header -->
            <div class="py-2 py-md-3 bg-white shadow-sm">
                <div class="container d-flex align-items-center justify-content-between">
                    <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ $appsetting['logo']?? asset('restaurant_frontend/assets/img/logo.png') }}" alt="Logo" style="height: 40px;">
                    </a>

                    <form class="responsive-form" >
                        <div class="input-group position-relative border border-1 rounded rounded-2">
                            {{-- Search type selector --}}
                            <select class="form-select w-auto border border-0 search-type" id="search-type" name="type">
                                <option value="restaurant" selected>Restaurant</option>
                                <option value="hotel">Hotel</option>
                                <option value="ecommerce">E-commerce</option>
                            </select>

                            {{-- Search box --}}
                            <input class="form-control search-input border-0" id="search-box" name="query" type="search" placeholder="Search products, food, rooms..." autocomplete="off">

                            {{-- Submit button --}}
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <div id="search-results" class="list-group position-absolute w-100 shadow-sm bg-white rounded d-none" style="top: 100%; z-index: 999;"></div>
                    </form>

                    <!-- Icons -->
                    <div class="d-none d-md-flex align-items-center">

                        @php
                        $wishlistCount = Auth::check() ? \App\Models\Restaurant\Wishlist::where('user_id', Auth::id())->count() : 0;
                        $ecommerce_wishlistCount = Auth::check() ? \App\Models\Wishlist::where('user_id', Auth::id())->count() : 0;
                        $sessionCount = \App\Helper\Helper::totalRestaurantCartItems();
                        $helperCount = \App\Helper\Helper::totalCartItems();
                        $cartCount = $sessionCount + $helperCount;
                        @endphp
                        <a href="{{ route('restaurant.wishlist.index') }}" class="btn btn-light btn-sm position-relative me-2">
                            <i class="bi bi-heart text-primary fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" id="whishlist-count">
                                {{ $wishlistCount + $ecommerce_wishlistCount }}
                            </span>
                        </a>
                        <a href="{{ url('my-cart') }}" class="btn btn-light btn-sm position-relative me-2">
                            <i class="bi bi-cart text-primary fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" id="cart-count">
                                {{ $cartCount }}
                            </span>
                        </a>

                        @if(Auth::check())
                        <div class="dropdown">
                            <a class="btn btn-light btn-sm" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Auth::user()->profile_photo_path)
                                <img src="{{ auth()->user()->profile_photo_path }}" width="28" class="rounded-circle border shadow-sm">
                                @else
                                <i class="bi bi-person-circle fs-5 text-primary"></i>
                                @endif
                                <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                                    0
                                 <span class="visually-hidden">unread messages</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                 <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ url('/notifications') }}">
                                        <span><i class="bi bi-bell text-primary"></i> Notifications &nbsp;</span>
                                        <span id="notification-badge1" class="badge bg-danger rounded-pill" style="display: none;">0<span>
                                    </a>
                                </li>
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
                        <div class="dropdown">
                            <a class="btn btn-light btn-sm" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle text-primary fs-5"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('auth.login') }}">Login As Customer</a></li>
                                <li><a class="dropdown-item" href="{{ route('vendor-register') }}"> Become A Vendor</a></li>
                                <li><a class="dropdown-item" href="{{ url('register/delivery-man') }}"> Become A Delivery Man</a></li>
                            </ul>
                        </div>
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
                        <img src="{{ $appsetting['logo']?? asset('restaurant_frontend/assets/img/logo.png') }}" alt="Logo" style="height: 40px;">
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
     <script>
        function checkNotifications() {
            fetch('/check-notifications')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    const badge1 = document.getElementById('notification-badge1');
                    const badge2 = document.getElementById('notification-badge2');
                    const badge3 = document.getElementById('notification-badge3');
                    if (data.unread > 0) {
                        badge.innerText = data.unread;
                        badge.style.display = 'inline-block';
                        badge1.innerText = data.unread;
                        badge1.style.display = 'inline-block';
                        badge2.innerText = data.unread;
                        badge2.style.display = 'inline-block';
                        badge3.innerText = data.unread;
                        badge3.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                        badge1.style.display = 'none';
                        badge2.style.display = 'none';
                        badge3.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Notification check failed:', error);
                });
        }

        // Check immediately and then every 10 seconds
        checkNotifications();
        setInterval(checkNotifications, 5000);
    </script>

        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'en'
                    , includedLanguages: 'en,am,om,ti,so'
                    , layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element');
            }

        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchBox = document.getElementById('search-box');
                const searchType = document.getElementById('search-type');
                const resultsBox = document.getElementById('search-results');
                let timeout = null;

                searchBox.addEventListener('keyup', function() {
                    clearTimeout(timeout);
                    const query = this.value.trim();
                    const type = searchType.value;

                    if (query.length < 2) {
                        resultsBox.classList.add('d-none');
                        resultsBox.innerHTML = '';
                        return;
                    }

                    timeout = setTimeout(() => {
                        fetch(`/restaurant/live-search?query=${encodeURIComponent(query)}&type=${type}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Response:', data); // for debugging
                                resultsBox.innerHTML = '';

                                if (data.length > 0) {
                                    data.forEach(item => {
                                        const div = document.createElement('div');
                                        div.className = 'search-item list-group-item list-group-item-action d-flex justify-content-between align-items-center';

                                        const shortDescription = item.description.length > 10 ?
                                            item.description.substring(0, 30) + '...' :
                                            item.description;

                                        div.innerHTML = `
                                        <div>
                                            <strong>${item.name}</strong><br>
                                            <small class="text-muted"> ${shortDescription}, <b>Price: ${item.price} ETB</b></small>
                                        </div>
                                        <i class="bi bi-eye-fill text-primary"></i>
                                    `;
                                        div.onclick = () => window.location.href = item.url;
                                        resultsBox.appendChild(div);
                                    });

                                    resultsBox.classList.remove('d-none');
                                    resultsBox.classList.add('fade-in');
                                } else {
                                    resultsBox.classList.add('d-none');
                                }
                            })

                    }, 300);
                });

                document.addEventListener('click', function(e) {
                    if (!resultsBox.contains(e.target) && e.target !== searchBox) {
                        resultsBox.classList.add('d-none');
                    }
                });
            });

        </script>
