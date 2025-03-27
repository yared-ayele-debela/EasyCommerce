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
        <div class="mx-auto search-form border border-1 p-1 rounded w-50">
            <form class="d-flex">
                <input class="form-control me-2 search-input border-0" type="search" placeholder="Search for products" aria-label="Search">
                <button class="btn search-button" type="submit"><i class="bi bi-search"></i></button>
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
            <a href="{{ route('auth.login') }}" class="btn bg-primary text-white">Sign In</a>
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
            <a href="{{ route('auth.login') }}" class="btn btn-sm bg-primary text-white">Sign In</a>
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
