<div class="item">
    <a href="{{ url('ecommerce/brand/' . encrypt($brand->id)) }}" class="text-decoration-none">
        <div class="card shadow-sm">
            <img src="{{ asset('storage/' . ($brand->image ?? 'restaurant_frontend/default-image.png')) }}"
                 class="card-img-top"
                 alt="{{ $brand->name }}"
                 style="height: 150px; object-fit: cover;"
                 loading="lazy">
            <div class="card-body text-center">
                <h6 class="card-title">{{ $brand->name }}</h6>
            </div>
        </a>
    </div>
