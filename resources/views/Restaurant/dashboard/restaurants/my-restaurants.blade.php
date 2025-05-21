@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

 <div class="container ">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('restaurant.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Restaurant detail</li>
        </ol>
    </nav>
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #20c997, #38f9d7);">
            <h3 class="mb-0">
                <i class="bi bi-shop me-2"></i> <span class="fw-bold">{{ $restaurant->name }}</span> Restaurant
            </h3>
        </div>

        <div class="card-body p-4">
            {{-- Cover Image --}}
            <div class="mb-4">
                <img src="{{ $restaurant->cover }}" class="img-fluid rounded-3 shadow-sm w-100" alt="Cover Image" style="max-height: 350px; object-fit: cover;">
            </div>

            {{-- Logo & Basic Info --}}
            <div class="d-flex align-items-center gap-3 mb-4">
                <img src="{{ $restaurant->logo }}" class="rounded-circle shadow p-2" width="50" height="50" alt="Logo">
                <div>
                    <h4 class="mb-1">{{ $restaurant->name }}</h4>
                    <p class="text-muted mb-0"><i class="bi bi-envelope me-1"></i>{{ $restaurant->email }}</p>
                </div>
            </div>

            {{-- Details --}}
            <div class="row gy-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <strong><i class="bi bi-telephone me-2"></i>Phone:</strong><br>
                        {{ $restaurant->phone }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <strong><i class="bi bi-geo-alt me-2"></i>Address:</strong><br>
                        {{ $restaurant->address }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <strong><i class="bi bi-toggle-on me-2"></i>Is Open:</strong><br>
                        <span class="badge bg-{{ $restaurant->is_open ? 'success' : 'danger' }} px-3 py-2">
                            {{ $restaurant->is_open ? 'Open' : 'Close' }}
                        </span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <strong>Description:</strong><br>
                        <p>{{ $restaurant->description }}</p>
                    </div>
                </div>
            </div>

            {{-- Image Gallery --}}
            @if($restaurant->images && count($restaurant->images))
                <h4 class="mt-5 mb-3"><i class="bi bi-images me-2"></i>Image Gallery</h4>
                <div id="restaurantGallery" class="carousel slide carousel-fade shadow rounded" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($restaurant->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{$image->image_path}}" class="d-block w-100 rounded" alt="Gallery Image" style="max-height: 500px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#restaurantGallery" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#restaurantGallery" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
