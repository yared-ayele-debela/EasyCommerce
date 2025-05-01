
<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@foreach ($all_products as $product)
<div class="product-item col-lg-2 col-6 mb-4 all-product-layout">
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
            <img src="{{ $product['product_image'] }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
        </a>
        <div class="card-body p-2">
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
                <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
                <small class="text-muted">(88)</small>
            </div>
        </div>
    </div>
</div>
@endforeach

