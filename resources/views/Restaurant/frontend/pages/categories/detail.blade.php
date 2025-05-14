@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .category-filter {
        color: #343a40;
        /* Bootstrap text-dark default */
    }

    .category-filter.nav-active {
        color: white !important;
    }

</style>
<div class="container my-4">
    <div class="header d-flex align-items-center justify-content-between p-2">
        <button onclick="history.back()" class="btn btn-link text-dark">
            <i class="bi bi-arrow-left"></i>
        </button>
        <div class="d-flex align-items-center justify-content-center text-center shadow-sm p-2 mx-auto" style="border-radius: 100px; min-width: 200px;">
            <img src="{{ $category->image?$category->image:asset('restaurant_frontend/default-image.png')}}" alt="Burger" style="width: 30px; height: 30px; border-radius: 50%;">
            <h5 class="ms-2 mb-0">{{ $category->name }}</h5>
        </div>
        <div style="width: 40px;"></div>
    </div>

    <div class="row d-flex justify-content-center align-items-center py-3">
        <div class="custom-nav-container">
            <nav class="nav justify-content-between custom-nav p-2">
                <a href="#" class="nav-link fw-bold category-filter text-dark nav-active" id="show-products">Order Food</a>
                <a href="#" class="nav-link fw-bold category-filter text-dark " id="show-restaurants">Restaurant</a>
            </nav>
        </div>
    </div>
    <!-- Navigation -->
    <div class="row d-flex justify-content-center align-items-center py-4">
        <div class="col-md-8">
            <nav class="nav justify-content-center text-white py-2">
                <a href="#" class="nav-link text-white fw-bold nav-active">All</a>
                @foreach ($category->subcategories as $subcategory)
                <a href="#" class="nav-link text-dark fw-bold">{{ $subcategory->name }}</a>
                @endforeach
            </nav>
        </div>
    </div>
    <!-- Special Offers -->
    <div id="products-section">
        <div class="row g-3">
            @foreach ($category->products as $product)
            <div class="col-md-2 col-6 my-2 product-item">
                <x-restaurant.product-card :product="$product" />
            </div>
            @endforeach
        </div>
    </div>

    <div id="restaurants-section" style="display: none;">
        <div class="row">
            @foreach ($restaurants as $restaurant)
            <x-restaurant-card :restaurant="$restaurant" :distance="$restaurant->distance" :time="$restaurant->time" />
            @endforeach
            {{-- <div class="col-12">
                {{ $restaurants->links() }}
        </div> --}}
    </div>
</div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("show-products").addEventListener("click", function() {
            document.getElementById("products-section").style.display = "block";
            document.getElementById("restaurants-section").style.display = "none";
            this.classList.add("nav-active");
            document.getElementById("show-restaurants").classList.remove("nav-active");
        });

        document.getElementById("show-restaurants").addEventListener("click", function() {
            document.getElementById("products-section").style.display = "none";
            document.getElementById("restaurants-section").style.display = "block";
            this.classList.add("nav-active");
            document.getElementById("show-products").classList.remove("nav-active");
        });
    });

</script>
@endsection

