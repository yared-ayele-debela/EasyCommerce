<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@foreach ($allproduct as $product )
<div class="col-lg-2 col-6  mb-4">
    <div class="border item">
        <div class="image-container">
            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                @if($product['product_image'])
                <img class="img-fluid " src="{{ asset('/storage/products/'.$product['product_image']) }}" alt="Product">
                @else
                <img class="img-fluid " src="{{ asset('new_frontend/images/product/product@3x.jpg') }}" alt="Product">
                @endif
            </a>
        </div>
        <div class="item-content">
            <div class="what-product-is">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="javascript:void();">{{ $product['product_code'] }}</a>
                    </li>
                    <li class="has-">
                        <a href="javascript:void();">{{ $product['product_color'] }}</a>
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
                    {{  App\Helper\Helper::currency_converter($getDiscountPrice) }}
                </div>
                <div class="item-old-price">
                    {{  App\Helper\Helper::currency_converter($product['product_price']) }}
                </div>
                @else
                {{  App\Helper\Helper::currency_converter($product['product_price']) }}</s></span>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

