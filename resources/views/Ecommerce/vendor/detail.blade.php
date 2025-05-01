@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $allvendor->name }}</h5>
    </div>
    <div class="container-fluid mb-5">
        {{-- Vendor Banner --}}
        <div class="position-relative">
            @if(!empty($allvendor->vendorbusinessdetails['shop_image']))
                <img src="{{ $allvendor->vendorbusinessdetails['shop_image'] }}" class="w-100 rounded" style="height: 250px; object-fit: cover;" alt="Shop Banner">
            @else
                <img src="{{ asset('banner.png') }}" class="w-100 rounded" style="height: 250px; object-fit: cover;" alt="Shop Banner">
            @endif
            <div class="position-absolute bottom-0 start-0 translate-middle-y ms-4 mb-2">
                @if(!empty($allvendor->adminvendor['image']))
                    <img src="{{ $allvendor->adminvendor['image']}}" class="rounded-circle border border-2 bg-white" width="100" height="100" style="object-fit: cover;" alt="Vendor Image">
                @else
                    <img src="{{ asset('no_vendor.png') }}" class="rounded-circle border border-2 bg-white" width="100" height="100" style="object-fit: cover;" alt="Vendor Image">
                @endif
            </div>
        </div>

        {{-- Vendor Info --}}
        <div class="mt-4 ps-4">
            <h2 class="fw-bold text-primary">{{ $allvendor->vendorbusinessdetails['shop_name'] ?? $allvendor->name }}</h2>
            <p class="text-muted small">
                {{ $allvendor->shop_state }}, {{ $allvendor->shop_city }}, {{ $allvendor->vendorbusinessdetails['shop_address'] ?? 'No Address Available' }}, {{ $allvendor->shop_country }}
            </p>
            <p>
                {{ $allvendor->vendorbusinessdetails['shop_description'] ?? 'No Description Available' }}
            </p>
        </div>
        <h4 class="mt-5 mb-3 fw-bold">Products</h4>
        <div class="row">
            @if($vendorProducts->isEmpty())
            <div class="col-12 text-center">
                <img src="{{ asset('no-product-found..png') }}" class="img-fluid" style="max-width: 300px;" alt="No Products">
            </div>
            @else
            <div class="owl-carousel owl-theme ecommerce_products mt-4">
                @foreach($vendorProducts as $product)
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
                            <img src="{{ $product['product_image'] }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
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
            @endif

        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $vendorProducts->links() }}
        </div>

    </div>
</div>
@endsection

