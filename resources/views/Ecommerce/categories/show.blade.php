@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid pb-5 pb-md-2">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $category->name }}</h5>
    </div>
    <div class="row g-4">
        @if(!$products->isEmpty())
        @foreach ($products as $product)
        <div class="col-md-2 col-6 mb-2 h-100">
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
                    <img src="{{ $product['product_image'] }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                </a>
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                    <h6 class="fw-semibold mb-2">
                        <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}" class="text-dark text-decoration-none">
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
                        @php
                            $averageRating = round($product->ratings_avg_rating ?? 0, 1);
                            $fullStars = floor($averageRating);
                            $halfStar = ($averageRating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                        @endphp

                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="fas fa-star-half-alt"></i>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="far fa-star"></i>
                        @endfor

                        <small class="text-muted">({{ $averageRating }})</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-md-12 text-center mt-5">
            <img src="{{ asset('no-product-found..png') }}" alt="No Products Found" class="img-fluid mb-3" style="width: 300px; height: 200px;">
        </div>
        @endif
    </div>
    <div class="my-4">
        {{ $products->links() }}
    </div>
</div>
@endsection

