@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .offer-card {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        border-radius: 10px;
        border: 1px solid #b2f7b2;
        box-shadow: 0 2px 10px rgb(204, 252, 204) !important;
    }

    .offer-card img {
        transition: transform 0.3s ease-in-out;
    }

    .offer-card:hover img {
        transform: scale(1.05);
    }

    .product-card {
        position: relative;
        border: 1px solid #17BE18;
        border-radius: 7px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(65, 255, 23, 0.1);
    }

    .product-card img {
        width: 100%;
        height: 300px;
    }

    .product-card .card-body {
        padding: 15px;
    }

    .product-card .product-name {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .product-card .price {
        font-size: 1rem;
        color: #999;
        text-decoration: line-through;
    }

    .product-card .discount-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #17BE18;
    }

    .product-card .icons {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1100;
    }

    .product-card .icons a {
        color: #333;
        margin: 0 5px;
        font-size: 1.5rem;
    }

    .product-card-banner {
        background-color: #17BE18;
        color: white;
        padding: 20px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .product-card-banner img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .product-card-banner .content {
        position: absolute;
        bottom: 20px;
        left: 20px;
    }

    .btn-custom-banner {
        color: white;
        text-decoration: none;
        font-weight: bold;
        border: 2px solid #ffffff !important;
        border-radius: 4px;
        align-items: center !important;
    }

    .scrollable-list {
        max-height: 450px;
        overflow-y: auto;
        scrollbar-width: thin;
        /* For Firefox */
        scrollbar-color: #e1e6e1 #f1f1f1;
        /* Scrollbar color */
    }

    .scrollable-list::-webkit-scrollbar {
        width: 4px !important;
        /* Scrollbar width */
    }

    .scrollable-list::-webkit-scrollbar-thumb {
        background: #17BE18;
        /* Scroll thumb (handle) color */
        border-radius: 10px;
        /* Rounded edges */
    }

    .scrollable-list::-webkit-scrollbar-thumb:hover {
        background: #17BE18;
        /* Darker shade on hover */
    }

    .scrollable-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Background track color */
        border-radius: 10px;
    }

    /* .hero {
        background: url('assets/img/banner2.png') no-repeat center center;
        background-size: cover;
        color: white;
        padding: 50px;
        text-align: left;
    } */

    .category-box {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .category-box.active,
    .category-box:hover {
        background: #17BE18;
        color: white;
    }

    .category-list {
        position: relative;
    }

    .category-list li {
        cursor: pointer;
        position: relative;
    }

    .subcategory-dropdown {
        background: #ffffff;
        border: 1px solid #dee2e6;
        padding: 10px;
        display: none;
        z-index: 1100 !important;
        border-radius: 0.5rem;
        margin-top: 10px;
    }


    .subcategory-dropdown li {
        list-style: none;
        padding: 5px 10px;
    }

    .subcategory-dropdown li a {
        text-decoration: none;
        color: #333;
        display: block;
    }

    .subcategory-dropdown li a:hover {
        color: #27b40b;
        font-weight: 500;
    }

    .list-group-item.active {
        z-index: 2;
        color: rgb(63, 62, 62);
        background-color: #F0F5FA !important;
        border-color: var(--bs-list-group-active-border-color);
    }

    /* Hover for desktop */
    @media (min-width: 992px) {
        .subcategory-dropdown {
            position: absolute;
            top: 0;
            left: 100%;
            min-width: 800px;
            margin-top: 0;
            z-index: 1100 !important;

            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .category-list li:hover .subcategory-dropdown {
            display: block;
            z-index: 1100 !important;
        }
    }

    /* Click-to-toggle on mobile */
    @media (max-width: 991.98px) {
        .category-list li {
            padding-bottom: 0.5rem;
        }

        .category-list li.active .subcategory-dropdown {
            display: block;
        }

        .category-list li .toggle-icon {
            float: right;
            font-size: 1.1rem;
            color: #666;
            cursor: pointer;
        }
    }

</style>
<div class="container pt-2 pb-1">
    <div class="row d-flex justify-content-center align-items-center pt-3">
        <div class="custom-nav-container">
            <nav class="nav justify-content-between custom-nav p-2">
                <a href="{{ url('/') }}" class="custom-switch nav-link fw-bold {{ request()->is('/')?' text-white nav-active':'text-dark' }}">Order
                    Food</a>
                <a href="{{ url('/hotel') }}" class="custom-switch nav-link fw-bold {{ request()->is('hotel')?' text-white nav-active':'text-dark' }}">Reserve
                    Hotel</a>
                <a href="{{ url('/ecommerce') }}" class="custom-switch nav-link text-white fw-bold {{ request()->is('ecommerce')?' text-white nav-active':'text-dark' }}">Buy Goods</a>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid p-2 p-md-4">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <div class="card border border-1 shadow-sm">
                <div class="card-header bg-white pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> <i class="bi bi-list text-primary me-2 "></i>Categories</h5>
                    <div id="categoryToggle" role="button">
                        <i class="bi bi-toggle-on text-primary" style="font-size: 20px;"></i>
                    </div>
                </div>
                <ul class="list-group list-group-flush category-list d-none d-lg-block" id="categoryList">
                    @foreach ($group as $group)
                    @if(count($group['categories']) > 0)
                    <li class="list-group-item position-relative">
                        <i class="bi bi-phone me-2 text-primary"></i> {{$group['name']}}
                        <span class="badge bg-primary rounded-pill float-end">{{ $group['categories']->count() }}</span>
                        <ul class="subcategory-dropdown">
                            <div class="row">
                                @foreach ($group['categories'] as $category )
                                <div class="col-4">
                                    <li>
                                        <a href="{{ url($category['url']) }}">{{ $category['name'] }}</a>
                                        <ul>
                                            @foreach ($category['subcategories'] as $subcategory)
                                            <li>
                                                <a href="{{ url($subcategory['url']) }}">{{ $subcategory['name'] }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </div>
                                @endforeach
                            </div>
                        </ul>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-9 mb-2">
            <div id="promoCarousel" class="carousel slide carousel-fade card shadow-sm" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="d-flex align-items-center banner-box {{ $index % 2 === 0 ? 'text-white' : 'text-dark' }}" style="border-radius:6px; background: url('{{ asset('/storage/banner/' . $banner['image']) }}') center center / cover no-repeat;">
                            <div class="container py-5 px-4">
                                <h1 class="display-6 fw-bold">{{ $banner['title'] ?? 'Promotion' }}</h1>
                                <p class="lead">{{ $banner['alt'] ?? 'Don’t miss out on our latest offers!' }}</p>
                                @if (!empty($banner['link']))
                                <a href="{{ $banner['link'] }}" class="btn {{ $index % 2 === 0 ? 'btn-light' : 'btn-dark' }} btn-lg rounded-pill mt-2 shadow-sm">
                                    Shop Now <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pb-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-fire text-danger me-2"></i> Flash Sales
        </h3>

        <!-- This wrapper keeps countdown + button in one row -->
        <div class="d-flex align-items-center gap-3 flex-wrap">

            <!-- All Button -->
            <a href="{{ route('ecommerce.products.flash.sales') }}" class="btn btn-outline-primary order-2 order-md-1 fw-semibold">
                View All
            </a>
            <!-- Countdown Box -->
            <div class="d-flex gap-3 text-center bg-primary px-3 py-2 rounded-2 order-1 order-md-2 shadow-sm">
                <div>
                    <strong id="days" class="text-white fs-5">03</strong>
                    <div class="small text-white">Days</div>
                </div>
                <div>
                    <strong id="hours" class="text-white fs-5">23</strong>
                    <div class="small text-white">Hours</div>
                </div>
                <div>
                    <strong id="minutes" class="text-white fs-5">19</strong>
                    <div class="small text-white">Minutes</div>
                </div>
                <div>
                    <strong id="seconds" class="text-white fs-5">56</strong>
                    <div class="small text-white">Seconds</div>
                </div>
            </div>

        </div>
    </div>

    @if ($featured_flash_deal && $flash_deal_products->count())
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($flash_deal_products as $item)
            @php $product = $item->product; @endphp
            <div class="item mb-2 h-100">
                <div class="offer-card position-relative shadow-sm rounded-4 overflow-hidden h-100">
                    @php
                    $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                    $hasDiscount = $getDiscountPrice > 0;
                    @endphp
                    @if($hasDiscount)
                    <span class="badge bg-primary position-absolute top-0 start-0 p-2 m-2" style="z-index: 1100;">
                        -{{ round(100 - ($getDiscountPrice / $product['product_price']) * 100) }}%
                    </span>
                    @endif
                    <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}">
                        @if($product['product_image'])
                        <img src="{{ asset('storage/products/' . $product['product_image']) }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @endif
                    </a>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                        <h6 class="fw-semibold mb-2">
                            <a href="{{ url('product/'.$product['id']) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product['product_name'], 40) }}
                            </a>
                        </h6>
                        @if($product['is_offer_price'] === "yes")
                        <span class="text-primary fw-bold">Offer Price</span>
                        @else
                        <h5 class="text-primary fw-bold mb-1">
                            {{ App\Helper\Helper::currency_converter($hasDiscount ? $getDiscountPrice : $product['product_price']) }}
                            @if($hasDiscount)
                            <small class="text-muted text-decoration-line-through ms-2">
                                {{ App\Helper\Helper::currency_converter($product['product_price']) }}
                            </small>
                            @endif
                        </h5>
                        @endif
                        <div class="text-warning small">
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <small class="text-muted">(88)</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const endTime = new Date("{{ \Carbon\Carbon::parse($featured_flash_deal->end_date)->format('Y-m-d H:i:s') }}").getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    document.getElementById("countdown").innerHTML = "⏰ Deal ended";
                    return;
                }
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").textContent = String(days).padStart(2, '0');
                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');

            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });

    </script>
    @endif
</div>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h3 class="fw-bold">Categories</h3>
        <div class="d-flex gap-3 text-center">
            <form action="{{ route('ecommerce.categories.index') }}" method="GET">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
    </div>
    <div class="row text-center mt-3">
        <div class="owl-carousel owl-theme categories mt-4">
            @foreach ($getCategory as $category)
            <div class="item mb-2">
                <div class="category-item">
                    <a href="{{ url('ecommerce/category/'.encrypt($category['id'])) }}">
                        <img src="{{ asset('storage/category/' . $category['image']) }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="{{ $category->name }}">
                        <p class="text-dark">{{ $category->name }}</p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-2 pt-4">
        <h3 class="fw-bold">Featured Products</h3>
        <div class="d-flex gap-3 text-center">
            <form action="{{ route('ecommerce.products.featured') }}" method="GET">
                <input type="hidden" name="name" value="featured_products">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($isfeatured as $product)
            <div class="item mb-2 h-100">
                <div class="offer-card position-relative shadow-sm rounded-4 overflow-hidden h-100" style="z-index: 1100;">
                    @php
                    $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                    $hasDiscount = $getDiscountPrice > 0;
                    @endphp
                    @if($hasDiscount)
                    <span class="badge bg-primary position-absolute top-0 start-0 p-2 m-2" style="z-index: 1100;">
                        -{{ round(100 - ($getDiscountPrice / $product['product_price']) * 100) }}%
                    </span>
                    @endif
                    <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}">
                        @if($product['product_image'])
                        <img src="{{ asset('storage/products/' . $product['product_image']) }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @endif                    </a>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                        <h6 class="fw-semibold mb-2">
                            <a href="{{ url('product/'.$product['id']) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product['product_name'], 40) }}
                            </a>
                        </h6>
                        @if($product['is_offer_price'] === "yes")
                        <span class="text-primary fw-bold">Offer Price</span>
                        @else
                        <h5 class="text-primary fw-bold mb-1">
                            {{ App\Helper\Helper::currency_converter($hasDiscount ? $getDiscountPrice : $product['product_price']) }}
                            @if($hasDiscount)
                            <small class="text-muted text-decoration-line-through ms-2">
                                {{ App\Helper\Helper::currency_converter($product['product_price']) }}
                            </small>
                            @endif
                        </h5>
                        @endif
                        <div class="text-warning small">
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <small class="text-muted">(88)</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if(isset($fixbanners[0]['image']))
    <a href="{{ $fixbanners[0]['link']}}" target="_blank">
        <div class="hero rounded-3 my-2 p-4 fix-banner-box" style="background:url({{ asset('/storage/banner/'.$fixbanners[0]['image']) }});" class="img-fluid">
        </div>
    </a>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-2 pt-4">
        <h3 class="fw-bold">Latest Products</h3>
        <div class="d-flex gap-3 text-center">
            <form action="{{ route('ecommerce.products.latest') }}" method="GET">
                <input type="hidden" name="name" value="latest_products">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
    </div>
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($new_products as $product)
            <div class="item mb-2 h-100">
                <div class="offer-card position-relative shadow-sm rounded-4 overflow-hidden h-100">
                    @php
                    $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                    $hasDiscount = $getDiscountPrice > 0;
                    @endphp
                    @if($hasDiscount)
                    <span class="badge bg-primary position-absolute top-0 start-0 p-2 m-2" style="z-index: 1100;">
                        -{{ round(100 - ($getDiscountPrice / $product['product_price']) * 100) }}%
                    </span>
                    @endif
                    <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}">
                        @if($product['product_image'])
                        <img src="{{ asset('storage/products/' . $product['product_image']) }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @endif
                    </a>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                        <h6 class="fw-semibold mb-2">
                            <a href="{{ url('product/'.$product['id']) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product['product_name'], 40) }}
                            </a>
                        </h6>
                        @if($product['is_offer_price'] === "yes")
                        <span class="text-primary fw-bold">Offer Price</span>
                        @else
                        <h5 class="text-primary fw-bold mb-1">
                            {{ App\Helper\Helper::currency_converter($hasDiscount ? $getDiscountPrice : $product['product_price']) }}
                            @if($hasDiscount)
                            <small class="text-muted text-decoration-line-through ms-2">
                                {{ App\Helper\Helper::currency_converter($product['product_price']) }}
                            </small>
                            @endif
                        </h5>
                        @endif
                        <div class="text-warning small">
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <small class="text-muted">(88)</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-2 pt-4">
        <h3 class="fw-bold">Discounted Products</h3>
        <div class="d-flex gap-3 text-center">
            <form action="{{ route('ecommerce.products.discounted') }}" method="GET">
                <input type="hidden" name="name" value="discounted">
                <button type="submit" class="btn btn-sm btn-white">
                    <h6>View All</h6>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($discountedproduct as $product)
            <div class="item mb-2 h-100">
                <div class="offer-card position-relative shadow-sm rounded-4 overflow-hidden h-100">
                    @php
                    $getDiscountPrice = App\Models\Product::getDiscountPrice($product['id']);
                    $hasDiscount = $getDiscountPrice > 0;
                    @endphp
                    @if($hasDiscount)
                    <span class="badge bg-primary position-absolute top-0 start-0 p-2 m-2" style="z-index: 1100;">
                        -{{ round(100 - ($getDiscountPrice / $product['product_price']) * 100) }}%
                    </span>
                    @endif
                    <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}">
                        @if($product['product_image'])
                        <img src="{{ asset('storage/products/' . $product['product_image']) }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @else
                        <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                        @endif                    </a>
                    <div class="card-body p-3">
                        <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                        <h6 class="fw-semibold mb-2">
                            <a href="{{ url('product/'.$product['id']) }}" class="text-dark text-decoration-none">
                                {{ Str::limit($product['product_name'], 40) }}
                            </a>
                        </h6>
                        @if($product['is_offer_price'] === "yes")
                        <span class="text-primary fw-bold">Offer Price</span>
                        @else
                        <h5 class="text-primary fw-bold mb-1">
                            {{ App\Helper\Helper::currency_converter($hasDiscount ? $getDiscountPrice : $product['product_price']) }}
                            @if($hasDiscount)
                            <small class="text-muted text-decoration-line-through ms-2">
                                {{ App\Helper\Helper::currency_converter($product['product_price']) }}
                            </small>
                            @endif
                        </h5>
                        @endif
                        <div class="text-warning small">
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <small class="text-muted">(88)</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if(isset($fixbanners[1]['image']))
    <a href="{{ $fixbanners[1]['link']}}" target="_blank">
        <div class="hero rounded-3 my-2 p-4 fix-banner-box" style="background:url({{ asset('/storage/banner/'.$fixbanners[1]['image']) }});" class="img-fluid">
        </div>
    </a>
    @endif
</div>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mt-2 pt-4">
        <h3 class="fw-bold">Our Vendors</h3>
        <div class="d-flex gap-3 text-center">
            <h6><a href="{{ route('ecommerce.vendors.index') }}" class="text-dark" id="days">All</a></h6>
        </div>
    </div>
    <div class="row g-4">
        <div class="owl-carousel owl-theme vendors mt-4">
            @foreach ($allvendor as $vendor)
            <div class="item mb-2 h-100">
                <div class="offer-card h-100 rounded-2">
                    <div class="shop-banner-container position-relative">
                        @if(!empty($vendor->vendorbusinessdetails['shop_image']))
                        <img src="{{ asset('storage/admin/image/'.$vendor->vendorbusinessdetails['shop_image']) }}" class="w-100 " style="height: 150px; object-fit: cover;" alt="Shop Banner">
                        @else
                        <img src="{{ asset('banner.png') }}" class="w-100 " style="height: 150px; object-fit: cover;" alt="Shop Banner">
                        @endif
                        <div class="position-absolute bottom-0 start-0 translate-middle-y ms-3 mb-1">
                            @if(!empty($vendor->adminvendor['image']))
                            <img src="{{ asset('storage/admin/image/'.$vendor->adminvendor['image']) }}" class="rounded-circle border border-2" width="60" height="60" style="object-fit: cover;" alt="Vendor Image">
                            @else
                            <img src="{{ asset('no_vendor.png') }}" class="rounded-circle border border-2" width="60" height="60" style="object-fit: cover;" alt="Vendor Image">
                            @endif
                        </div>
                    </div>
                    <div class="card-body pt-4">
                        <h5 class="fw-bold text-primary">{{ $vendor->name }}</h5>

                        <p class="text-muted small mb-2">
                            {{ Str::limit($vendor->vendorbusinessdetails['shop_name'] ?? 'Shop Name not available', 40) }}
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ url('/vendor/detail/'.encrypt($vendor->id)) }}" class="btn btn-sm btn-primary ">
                                Products ({{ $vendor->products_count }})
                            </a>
                            <a href="{{ url('/vendor/detail/'.encrypt($vendor->id)) }}" class="btn btn-sm btn-outline-primary ">
                                Reviews ({{ $vendorRatingsCount[$vendor->id] ?? 0 }})
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="container-fluid pb-4">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h3 class="fw-bold">Brands</h3>
        <div class="d-flex gap-3 text-center">
        </div>
    </div>
    <div class="row text-center mt-2">
        <div class="owl-carousel owl-theme categories mt-4">
            @foreach ($allbrands as $brand)
            <div class="item mb-2">
                <div class="category-item">
                    <a href="javascript:void(0);">
                        @if($brand['image'])
                        <img src="{{ asset('/storage/brand/'.$brand['image']) }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="brand">
                        @else
                        <img src="{{ asset('new_frontend/images/banners/b1.png') }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="brand">
                        @endif
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h3 class="fw-bold">All Products</h3>
        <div class="d-flex gap-3 text-center">
            <h6><a href="" class="text-dark">All</a></h6>
        </div>
    </div>
    <div class="row" id="data-containers">
        @include('fontend.layout.autoloadproduct.data')
    </div>
    @include('all_frontend_layouts.partial_index')
</div>

<script>
    var pages = 2;

    $(document).ready(function() {
        loadMoreData();
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadMoreData();
            }
        });
    });

    function loadMoreData() {
        $.ajax({
            url: '/fetch-product-data?page=' + pages
            , type: 'get'
            , dataType: 'html'
            , success: function(response) {
                $('#data-containers').append(response);
                pages++;
            }
        });
    }

</script>
<script>
    function initializeFlashCountdowns() {
        const countdowns = document.querySelectorAll('.flash-countdown');

        countdowns.forEach(el => {
            const endTime = parseInt(el.dataset.end) * 1000; // milliseconds
            const countdownText = el.querySelector('.countdown-text');

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance <= 0) {
                    countdownText.innerText = 'Deal Ended';
                    clearInterval(interval);
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownText.innerText = `${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        });
    }

    document.addEventListener('DOMContentLoaded', initializeFlashCountdowns);

</script>
@endsection
