<div class="item">
    <a href="{{ url('ecommerce/vendor/' . encrypt($vendor->id)) }}" class="text-decoration-none">
        <div class="card shadow-sm">
            <img src="{{ asset('storage/' . ($vendor->vendorbusinessdetails->image ?? 'restaurant_frontend/default-image.png')) }}"
                 class="card-img-top"
                 alt="{{ $vendor->vendorbusinessdetails->business_name }}"
                 style="height: 150px; object-fit: cover;"
                 loading="lazy">
            <div class="card-body text-center">
                <h6 class="card-title">{{ $vendor->vendorbusinessdetails->business_name }}</h6>
                <p class="text-muted small">Products: {{ $vendor->products_count }}</p>
                <p class="text-muted small">Reviews: {{ $review_count }}</p>
            </div>
        </a>
    </div>
