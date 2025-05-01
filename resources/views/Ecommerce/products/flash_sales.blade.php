@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid pb-5">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $name }}</h5>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="bi bi-fire text-primary"></i> Flash Sales</h3>
        <div class="d-flex gap-3 text-center bg-primary p-2 rounded rounded-1 shadow-sm">
            <div><strong id="days" class=" text-white">03</strong>
                <div class="small text-white">Days</div>
            </div>
            <div><strong id="hours" class=" text-white">23</strong>
                <div class="small text-white">Hours</div>
            </div>
            <div><strong id="minutes" class=" text-white">19</strong>
                <div class="small text-white">Minutes</div>
            </div>
            <div><strong id="seconds" class=" text-white">56</strong>
                <div class="small text-white">Seconds</div>
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
@endsection

