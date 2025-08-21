
@props(['product'])
<div class="col-md-2 col-6 mb-2 h-100">
    <div class="offer-card position-relative shadow-sm rounded-4  overflow-hidden h-100">
        @php
            $hasStock = $product->quantity > 0;
            $discountedPrice = App\Models\Product::getDiscountPrice($product->id);
            $hasDiscount = $discountedPrice < $product->product_price;
            $averageRating = round($product->ratings_avg_rating ?? 0, 1);
            $fullStars = floor($averageRating);
            $halfStar = ($averageRating - $fullStars) >= 0.5;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        @endphp


        @if(!$hasStock)
            <a class="badge bg-danger position-absolute top-0 end-0 p-2 m-2" style="z-index: 1100;"> <small>Out of Stock</small></a>
        @endif

        @if($hasDiscount)
            <a class="badge bg-primary position-absolute top-0 start-0 p-2 m-2" style="z-index: 1100;">
             <small>   {{ round(100 - ($discountedPrice / $product->product_price) * 100) }}%</small>
            </a>
        @endif

        <a href="{{ url('ecommerce/product/' . encrypt($product->id)) }}">
            <img src="{{ asset('storage/' . $product->product_image) ?? asset('restaurant_frontend/default-image.png') }}"
                 class="card-img-top p-3 product-image" loading="lazy" alt="{{ $product->product_name }}" >
        </a>

        <div class="card-body p-3">
            <p class="fw-semibold mb-2">
                <a href="{{ url('ecommerce/product/' . encrypt($product->id)) }}"
                   class="text-dark text-decoration-none">
                   {{ Str::limit($product->product_name, 15) }}
                </a>
            </p>

            <span class="new-price">
                {{ $hasDiscount ? $discountedPrice : $product->product_price }} ETB
                @if($hasDiscount)
                    <small class="text-muted text-decoration-line-through ms-2">
                        {{ $product->product_price }} ETB
                    </small>
                @endif
            </span>

        </div>
    </div>
</div>

