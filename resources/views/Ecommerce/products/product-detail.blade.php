<?php use App\Models\Product;
use App\Models\ProductFilter;
$productFilters = ProductFilter::productFilters();
use App\Models\Wishlist;
?>
@extends('all_frontend_layouts.layouts')
@section('content')
<style>
    .color-dot {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 10px;
      cursor: pointer;
    }
    .color-dot.selected {
      outline: 2px solid #000;
    }
    .size-btn {
      border: 1px solid #ccc;
      margin-right: 8px;
      padding: 5px 12px;
      cursor: pointer;
    }
    .size-btn.active {
      background-color: #28a745;
      color: #fff;
      border-color: #28a745;
    }
    .qty-btn {
      width: 40px;
      height: 40px;
    }
</style>
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $product->product_name }}</h5>
    </div>
    <div class="row g-4 py-4">
        <div class="row">
            <div class="col-md-1 d-flex flex-column gap-3">
            @foreach ($product['images'] as $image )
              <img src="{{ asset('/storage/products/'.$image['image']) }}" class="img-fluid border rounded thumbnail-image" style="cursor: pointer;"  alt="{{ $product->product_name }}" />
            @endforeach
            </div>

            <div class="col-md-5">
              <img  id="mainProductImage" src="{{ asset('storage/products/' . $product['product_image']) }}" class="img-fluid border-0 rounded w-100" alt="{{ $product->product_name }}" />
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
              <!-- Rating -->
              <div class="mb-2">
                <span class="text-warning">
                    @if($avgStarRating > 0)
                    <div class="product-rating mb-2">
                        <p>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($avgStarRating))
                                <i class="bi bi-star-fill text-primary"></i>
                                {{-- Filled Star --}}
                                @else
                                <i class="bi bi-star text-primary"></i>
                                @endif
                            @endfor
                            <span class="text-muted">({{ number_format($avgRating, 1) }})</span>
                        </p>
                    </div>
                @endif

                </span>
                <small class="text-muted">({{$ratings->count() }} Reviews)</small>
                @if($totalStock>0)
                <span class="text-success ms-3">In Stock</span>
                @else
                <span class="text-danger ms-3">Out of Stock</span>
                @endif
              </div>

              <h3><strong>{{ $product->product_price }} ETB</strong></h3>
              <p class="text-muted">
                {!!$product['description'] !!}
              </p>
              <hr>
                <p class="text-muted mb-2">Product Code: <strong>{{ $product->product_code }}</strong></p>
                <div class="mb-2">
                    @if($totalStock>0)
                    <span><strong>Only: </strong>{{ $totalStock }} left</span>
                    @endif
                </div>
                @if(isset($productDetails['vendor']) && isset($productDetails['vendor']['vendorbusinessdetails']) && isset($productDetails['vendor']['vendorbusinessdetails']['shop_name']))
                <div class="mb-2">
                    <strong>Seller:</strong>
                    <a href="/products/{{ $productDetails['vendor']['id'] }}">{{ $productDetails['vendor']['vendorbusinessdetails']['shop_name'] }}</a>
                </div>
                @endif

              <!-- Colours -->
              <div class="mb-3">
                <strong>Colours:</strong>
                <span class="color-dot bg-secondary selected"></span>
                <span class="color-dot bg-danger"></span>
              </div>

              <!-- Size -->
              <div class="mb-3">
                <strong>Size:</strong>
                <div class="d-inline-block ms-2">
                  @if($product['attributes'])
                  @foreach ($product['attributes'] as $attribute )
                  <span class="size-btn">{{ $attribute['size'] }}</span>
                  @endforeach
                  @else
                    <p class="text-danger">This product don't have available size </p>
                  @endif
                </div>
              </div>
              
              <!-- Quantity and Buy Buttons -->
              <div class="d-flex align-items-center mb-4">
                <button class="btn btn-danger qty-btn">-</button>
                <div class="mx-2 fw-bold fs-5">2</div>
                <button class="btn btn-success qty-btn">+</button>
                <button class="btn btn-success ms-3 px-4">Buy Now</button>
                <button class="btn btn-outline-secondary ms-2"><i class="far fa-heart"></i></button>
              </div>



              <!-- Delivery Info -->
              <div class="border rounded p-3 mb-2">
                <i class="fas fa-truck me-2"></i><strong>Free Delivery</strong>
                <p class="mb-0 small text-muted">Enter your postal code for Delivery Availability</p>
              </div>

              <div class="border rounded p-3">
                <i class="fas fa-undo me-2"></i><strong>Return Delivery</strong>
                <p class="mb-0 small text-muted">Free 30 Days Delivery Returns. <a href="{{ url('page/delivery_and_return') }}" target="_blank" class="text-primary">Details</a></p>
              </div>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-Description-tab" data-bs-toggle="pill" data-bs-target="#pills-Description" type="button" role="tab" aria-controls="pills-Description" aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-Specifications-tab" data-bs-toggle="pill" data-bs-target="#pills-Specifications" type="button" role="tab" aria-controls="pills-Specifications" aria-selected="false">Specifications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-Reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-Reviews" type="button" role="tab" aria-controls="pills-Reviews" aria-selected="false">Customer Reviews ({{ $ratings->count() }})</button>
                    </li>

                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-Description" role="tabpanel" aria-labelledby="pills-Description-tab" tabindex="0">
                        <p> {!! $product['description'] !!}</p>
                        @if(!empty($product['product_video']))
                        <video src="{{ asset('/storage/products/video/'.$product['product_video']) }}" style="width:380px;  box-shadow:1px 1px 2px gray; height:250px" controls></video>
                        @else
                        <h6 class="text-muted">Product Video does not exists</h6>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="pills-Specifications" role="tabpanel" aria-labelledby="pills-Specifications-tab" tabindex="0">
                        <h6 class="text-muted">Product Additional Information</h6>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            @foreach ($productFilters as $filter)
                                @if(isset($product['category_id']))
                                    @php
                                        $filterAvailable = ProductFilter::filterAvailable($filter['id'], $product['category_id']);
                                    @endphp

                                    @if($filterAvailable == "Yes")
                                        @php
                                            $valueToShow = '';
                                            foreach ($filter['filter_values'] as $value) {
                                                if (!empty($product[$filter['filter_column']]) && $value['filter_value'] == $product[$filter['filter_column']]) {
                                                    $valueToShow = ucwords($value['filter_value']);
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if($valueToShow)
                                        <div class="col">
                                            <div class="border rounded p-3 shadow-sm bg-light d-flex justify-content-between align-items-center">
                                                <span class="fw-semibold text-muted">{{ $filter['filter_name'] }}</span>
                                                <span class="fw-bold">{{ $valueToShow }}</span>
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-Reviews" role="tabpanel" aria-labelledby="pills-Reviews-tab" tabindex="0">
              <div class="overflow-auto" style="white-space: nowrap;">
                <div class="d-flex gap-3" style="overflow-x: auto; scrollbar-width: thin;">
                    @if(count($ratings)>0)
                    @foreach($ratings as $rating)
                    <div class="offer-card shadow p-3 text-left mb-2" style="min-width: 300px; white-space: normal; word-wrap: break-word;">
                        <span class="font-italic">Name: {{ $rating->user->name }}</span>
                        <br>
                        <p class="fst-italic">Comment: {{ $rating->review }}</p>
                        <span>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating['rating'])
                                    <i class="bi bi-star-fill text-primary"></i>
                                @else
                                    <i class="bi bi-star text-primary"></i>
                                @endif
                            @endfor
                        </span>
                        <hr>
                        <span class="text-muted">Date: {{ date("d-m-Y", strtotime($rating->created_at)) }}</span>
                    </div>

                    @endforeach
                    @else
                    <p><b>Reviews are not available for this product!</b></p>
                    @endif
                </div>
            </div>
                    </div>
                  </div>
            </div>
          </div>
    </div>
    <div class="header">
        <h4 class="my-2 text-dark text-left">Recently Viewed Products</h4>
    </div>
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
            @foreach ($recentlyViewedProducts as $product)
            <div class="item mb-2 h-100">
            <div class="offer-card position-relative shadow-sm rounded-4 overflow-hidden h-100" style="z-index: 1100;">
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
                    <img src="{{ asset('storage/products/' . $product['product_image']) }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                </a>
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                    <h6 class="fw-semibold mb-2">
                        <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}" class="text-dark text-decoration-none">
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
    <div class="header">
        <h4 class="my-2 text-dark text-left">Similar Products</h4>
    </div>
    <div class="row g-4">
        <div class="owl-carousel owl-theme ecommerce_products mt-4">
        @foreach ($similarProducts as $product)
        <div class="item mb-2 h-100">
            <div class="offer-card position-relative shadow-sm rounded-4 overflow-hidden h-100" style="z-index: 1100;">
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
                    <img src="{{ asset('storage/products/' . $product['product_image']) }}" class="card-img-top p-3" alt="{{ $product['product_name'] }}">
                </a>
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">{{ $product['product_code'] }} • {{ $product['product_color'] }}</p>
                    <h6 class="fw-semibold mb-2">
                        <a href="{{ url('ecommerce/product/'.encrypt($product['id'])) }}" class="text-dark text-decoration-none">
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
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
      const thumbnails = document.querySelectorAll('.thumbnail-image');
      const mainImage = document.getElementById('mainProductImage');

      thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
          mainImage.src = this.src;
        });
      });
    });
  </script>

@endsection

