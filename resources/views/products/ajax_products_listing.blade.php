<?php use App\Models\Product;?>

    @foreach ($categoryProducts as $product)
    <div class="product-item  col-lg-3 col-6  mb-4 list-images">
        <div class="item border">
            <div class="image-container">
                <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                    @if($product['product_image'])
                    <img class="img-fluid " src="{{ asset('/storage/products/'.$product['product_image']) }}" alt="Product">
                    @else
                    <img class="img-fluid " src="{{ asset('new_frontend/images/product/product@3x.jpg') }}" alt="Product">
                    @endif                       </a>
            </div>
            <div class="item-content">
                <div class="what-product-is">
                    <ul class="bread-crumb">
                        <li class="has-separator">
                            <a href="javascript:void();">{{ $product['product_code'] }}</a>
                        </li>
                        <li class="has-separator">
                            <a href="javascript:void();">{{ $product['brand']['name'] }}</a>
                        </li>
                        <li class="has">
                            <a href="javascript:void();">{{ $product['product_color'] }}</a>
                        </li>
                    </ul>
                    <h6 class="item-title">
                        <a href="javascript:void();">{{ $product['product_name'] }}</a>
                    </h6>
                    <div class="item-description">
                        <p>{!! $product['description'] !!}</p>
                    </div>
                    {{-- <div class="item-stars">
                        <div class="star" title="4.5 out of 5 - based on 23 Reviews">
                            <span style="width:67px"></span>
                        </div>
                        <span>(23)</span>
                    </div> --}}
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
             <?php $isProductNew = Product::isProductNew($product['id']); ?>
             @if($isProductNew=="Yes")
            <div class="tag new bg-sucess ">
                 <span >New</span></>
            </div>
            @endif
        </div>
    </div>
    @endforeach

