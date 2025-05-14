@props(['vendor', 'reviewCount' => 0])

@php
    $shopImage = !empty($vendor->vendorbusinessdetails['shop_image'])
        ? $vendor->vendorbusinessdetails['shop_image']
        : asset('banner.png');

    $vendorImage = !empty($vendor->adminvendor['image'])
        ? $vendor->adminvendor['image']
        : asset('no_vendor.png');
@endphp

<div class="item mb-2 h-100">
    <div class="offer-card h-100 rounded-2">
        <div class="shop-banner-container position-relative">
            <img src="{{ $shopImage }}" class="w-100" style="height: 150px; object-fit: cover;" alt="Shop Banner">

            <div class="position-absolute bottom-0 start-0 translate-middle-y ms-3 mb-1">
                <img src="{{ $vendorImage }}" class="rounded-circle border border-2" width="60" height="60" style="object-fit: cover;" alt="Vendor Image">
            </div>
        </div>

        <div class="card-body pt-4">
            <h5 class="fw-bold text-primary">{{ $vendor->name }}</h5>

            <p class="text-muted small mb-2">
                {{ Str::limit($vendor->vendorbusinessdetails['shop_name'] ?? 'Shop Name not available', 40) }}
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ url('/vendor/detail/' . encrypt($vendor->id)) }}" class="btn btn-sm btn-primary">
                    Products ({{ $vendor->products_count }})
                </a>
                <a href="{{ url('/vendor/detail/' . encrypt($vendor->id)) }}" class="btn btn-sm btn-outline-primary">
                    Reviews ({{ $reviewCount }})
                </a>
            </div>
        </div>
    </div>
</div>
