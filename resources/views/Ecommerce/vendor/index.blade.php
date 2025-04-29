@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">All Vendors</h5>
    </div>
    <div class="row g-4">
        @foreach ($allvendors as $vendor)
        <div class="col-md-3 mb-2 h-100">
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
                        <a href="{{ url('/vendor/detail/'.encrypt($vendor->id)) }}" class="btn btn-sm btn-outline-primary">
                            Reviews ({{ $vendorRatingsCount[$vendor->id] ?? 0 }})
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">
                {{ $allvendors->links() }}
        </div>
    </div>
</div>
@endsection

