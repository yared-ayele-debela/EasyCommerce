<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@extends('fontend.layout.layout')
@section('content')

<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>ALL PRODUCTS</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="javascript:void();">All Products</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<section class="section-maker mt-3">
    <div class="container p-4">

        <div class="wrapper-content">
            <div class="row">
                @foreach ($allproduct as $product )
                <div class="col-3 mb-4">
                    <div class="border-0 item shadow-sm">
                        <div class="image-container">
                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                <img class="img-fluid product-image" src="{{ asset('/storage/products/'.$product['product_image']) }}" alt="Product">
                            </a>
                        </div>
                        <div class="item-content">
                            <div class="what-product-is">
                                <ul class="bread-crumb">
                                    <li class="has-separator">
                                        <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                    </li>
                                    <li class="has-separator">
                                        <a href="shop-v2-sub-category.html">Tops</a>
                                    </li>
                                    <li>
                                        <a href="shop-v3-sub-sub-category.html">Hoodies</a>
                                    </li>
                                </ul>
                                <h6 class="item-title">
                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                </h6>

                            </div>
                            <div class="price-template">
                                <?php $getDiscountPrice=Product::getDiscountPrice($product['id']);?>
                                @if($getDiscountPrice>0)
                                <div class="item-new-price">
                                    ETB {{ $getDiscountPrice}}
                                </div>
                                <div class="item-old-price">
                                    ETB {{ $product['product_price'] }}
                                </div>
                                @else
                                ETB {{ $product['product_price'] }}</s></span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div>{{ $allproduct->links() }}</div>
    </div>
</section>

@endsection

