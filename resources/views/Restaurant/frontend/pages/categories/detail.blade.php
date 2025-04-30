@extends('all_frontend_layouts.layouts')
@section('content')
<style>
 .category-filter {
    color: #343a40; /* Bootstrap text-dark default */
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
        <div class="d-flex align-items-center justify-content-center text-center shadow-sm p-2 mx-auto"
             style="border-radius: 100px; min-width: 200px;">
            <img src="{{ asset($category->image) }}" alt="Burger" style="width: 30px; height: 30px; border-radius: 50%;">
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
                <div class="offer-card p-3 h-100">
                    <a href="{{ url('restaurant/product-detail/'.encrypt($product->id)) }}" class="text-decoration-none text-dark d-block">
                        @php
                            $off = $product->price - $product->getFinalPrice();
                        @endphp
                        @if($off > 0)
                            <div class="badge-offer">
                                {{ $off }} ETB OFF
                            </div>
                        @endif
                        @php
                        $imagePath = $product->image
                          ? str_replace(asset('storage') . '/', '', $product->image)
                          : null;
                  @endphp

                  @if($product->image && Storage::disk('public')->exists($imagePath))
                      <img src="{{ $product->image }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                  @else
                      <img src="{{ asset('restaurant_frontend/default-image.png') }}" class="img-fluid mb-2" alt="No Image">
                  @endif                        <h6 class="text-dark">{{ $product->name }}</h6>
                        <p class="mb-0">
                            <span class="price">{{ $product->getFinalPrice() }} ETB</span>
                            <span class="price-old">{{ $product->price }} ETB</span>
                        </p>
                    </a>
                    <div class="hover-buttons">
                        <button onclick="window.location.href='{{ url('restaurant/product-detail/'.encrypt($product->id)) }}'" class="btn-view">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        <button class="btn-cart add-to-cart" data-product="{{ $product->id }}">
                            <i class="bi bi-cart-check-fill"></i>
                        </button>
                        <button class="btn-wishlist add-to-wishlist" data-product="{{ $product->id }}">
                            <i class="bi bi-heart text-white"></i>
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>

    <div id="restaurants-section" style="display: none;">
        <div class="row">
            @foreach ($restaurants as $restaurant)
            <div class="col-md-6">
                <div class="resturant_card card mb-3 p-2">
                    <div class="row g-0">
                        <div class="col-md-6">
                            <a href="{{ url('restaurant/'.$restaurant->id.'/detail') }}">
                            <img src="{{ asset('storage/' . $restaurant->cover) }}" class="img-fluid rounded-start" alt="{{ $restaurant->name }}">
                            </a>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">{{ $restaurant->name }}</h5>
                                <p class="mb-1">{{ $restaurant->description }}</p>

                                <div class="mb-2">
                                    <span class="badge resturant_badge p-2">Around 1.5km</span>
                                    <span class="badge resturant_badge p-2">Around 45 min</span>
                                </div>
                                <p class="mb-1"> <i class="bi bi-pin-map-fill text-primary"></i> {{ $restaurant->address }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="text-warning me-2">★ 4.7</div>
                                    <div><img src="{{ asset('restaurant_frontend/assets/img/scooter-02.png') }}" style="width: 20%;" alt=""> From 60 ETB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- <div class="col-12">
                {{ $restaurants->links() }}
            </div> --}}
        </div>
    </div>
  </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("show-products").addEventListener("click", function () {
        document.getElementById("products-section").style.display = "block";
        document.getElementById("restaurants-section").style.display = "none";
        this.classList.add("nav-active");
        document.getElementById("show-restaurants").classList.remove("nav-active");
    });

    document.getElementById("show-restaurants").addEventListener("click", function () {
        document.getElementById("products-section").style.display = "none";
        document.getElementById("restaurants-section").style.display = "block";
        this.classList.add("nav-active");
        document.getElementById("show-products").classList.remove("nav-active");
    });
});

</script>
@endsection
