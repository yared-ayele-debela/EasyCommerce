@extends('Restaurant.dashboard.layouts')
@section('restaurant-dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
 <nav class="breadcrumb">
    <a class="breadcrumb-item" href="#">Home</a>
    <a class="breadcrumb-item active" href="#">Restaurant</a>
 </nav>
 <div class="container mt-4">
    <div class="card">
        <div class="card-header text-dark">
            <h3><span style="color: rgb(73, 243, 58);">{{ $restaurant->name }}</span> Restaurants</h3>
        </div>
        <div class="card-body mt-3">
            <img src="{{ asset('storage/' . $restaurant->cover) }}" class="img-fluid rounded mb-3" alt="Cover Image">

            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('storage/' . $restaurant->logo) }}" class="rounded-circle me-2" width="60" height="60" alt="Logo">
                <div>
                    <h5 class="mb-0">{{ $restaurant->name }}</h5>
                    <small class="text-muted">{{ $restaurant->email }}</small>
                </div>
            </div>
            <p><strong>Phone:</strong> {{ $restaurant->phone }}</p>
            <p><strong>Address:</strong> {{ $restaurant->address }}</p>
            <p><strong>Status:</strong> 
                <span class="btn btn-{{ $restaurant->is_active ? 'success' : 'danger' }}">
                    {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                </span>
            </p>
            <h4>Restaurant Image Gallery</h4>
            <div id="restaurantGallery" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($restaurant->images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" style="max-height: 500px" alt="Gallery Image">
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
        </div>
    </div>
</div>

@endsection