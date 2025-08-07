@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
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
                <img src="{{ asset('storage/'.$allvendor->vendorbusinessdetails['shop_image']) }}" class="w-100 rounded" style="height: 250px; object-fit: cover;" alt="Shop Banner">
            @else
                <img src="{{ asset('banner.png') }}" class="w-100 rounded" style="height: 250px; object-fit: cover;" alt="Shop Banner">
            @endif
            <div class="position-absolute bottom-0 start-0 translate-middle-y ms-4 mb-2">
                @if(!empty($allvendor->adminvendor['image']))
                    <img src="{{ asset('storage/'.$allvendor->adminvendor['image']) }}" class="rounded-circle border border-2 bg-white" width="100" height="100" style="object-fit: cover;" alt="Vendor Image">
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
                 <x-product-card :product="$product" />
                @endforeach
            </div>
            @endif
        </div>
        {{-- Pagination --}}
        <div class="">
            {{ $vendorProducts->links() }}
        </div>

    </div>
</div>
@endsection

