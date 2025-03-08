<?php use App\Models\Product;
use App\Models\ProductFilter;
$productFilters = ProductFilter::productFilters();
use App\Models\Wishlist;
?>

@extends('fontend.layout.layout')
@section('content')
<style>
    div#social-links {
        margin: 0 auto;
        max-width: 500px;
    }

    div#social-links ul li {
        display: inline-block;
    }

    div#social-links ul li a {
        padding: 7px;
        margin: 1px;
        font-size: 10px;
        border-radius: 0.1rem;
        color: #ffffff;
        background-color: #1E665E;
    }

    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #deb217;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #c59b08;
    }

    /* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */

</style>

<div class="page-detail u-s-p-t-80">
    <div class="container">
        <div class="modal fade" id="OfferOrderModal" tabindex="-1" role="dialog" aria-labelledby="OfferOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="OfferOrderModalLabel">Order Now</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2>Enter Details</h2>
                        <form action="{{ route('store_offer_product') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                            @if(Auth::check())
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @endif
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="form-group">
                                @if($productDetails['attributes'])
                                <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}"  class="form-control" id="" required="">
                                    <option value="" disabled selected>select</option>
                                    @foreach ($productDetails['attributes'] as $attribute )
                                    <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                                    @endforeach
                                </select>
                                @else
                                <p class="text-danger">This product don't have available size </p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="offer_price">Offer Price</label>
                                <input type="number" class="form-control" id="offer_price" name="offer_price" step="0.01" required>
                            </div>
                            <button type="submit" class="btn button-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product-Detail -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!-- Product-zoom-area -->
                <div class="zoom-area">
                    <img id="zoom-pro" class="img-fluid" src="{{ asset('storage/products/' . $productDetails['product_image']) }}" data-zoom-image="{{ Storage::url($productDetails['product_image']) }}" alt="Zoom Image">
                    <div id="gallery" class="u-s-m-t-10">
                        @foreach ($productDetails['images'] as $image )
                        <a class="" data-image="{{ asset('storage/' . $productDetails['product_image']) }}" data-zoom-image="{{ asset('storage/products/' . $productDetails['product_image']) }}">
                            <img src="{{ asset('storage/products/' . $productDetails['product_image']) }}" alt="Product">
                        </a>
                        @endforeach
                    </div>
                </div>
                <!-- Product-zoom-area /- -->
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!-- Product-details -->
                <div class="all-information-wrapper">
                    <div class="section-1-title-breadcrumb-rating">
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Error!</strong> <?php echo Session::get('error_message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <strong>Success!</strong> <?php echo Session::get('success_message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        <div class="product-title">
                            <h1>
                                <a href="javascript();">{{ $productDetails['product_name'] }}</a>
                            </h1>
                        </div>
                        <ul class="bread-crumb">
                            <li class="has-separator">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="has">
                                <a href="javascript:void();">{{ $productDetails['group']['name'] }}</a>
                            </li>
                        </ul>
                        @if($avgStarRating>0)
                        <div class="product-rating">
                            <p>Product Rating : &nbsp;
                                <?php $star=1;
                                while($star<=$avgStarRating) {?>
                                <span>&#9733;</span>
                                <?php $star++; } ?>({{$avgRating}})
                            </p>
                        </div>
                        @endif

                    </div>
                    <div class="section-2-short-description u-s-p-y-14">
                        <h6 class="information-heading u-s-m-b-8">Description:</h6>
                        <p> {!!$productDetails['description'] !!}</p>
                    </div>
                    @if($productDetails['is_offer_price']==="yes")

                    @else
                    @php
                    $symbol = App\Helper\Helper::final_amount_currency_symbol();
                    @endphp
                    <p id="symbolParagraph" symbol={{ $symbol}} style="display: none;">
                    </p>
                    <?php
                     $getDiscountPrice = Product::getDiscountPrice($productDetails['id']);
                     ?>
                    <div class="getAttributePrice section-3-price-original-discount u-s-p-y-14">
                        @if($getDiscountPrice>0)
                        <div class="price d-md-flex">
                            <span>Discount:</span>&nbsp;<h2><strong>{{ App\Helper\Helper::currency_converter($getDiscountPrice) }}</strong></h2>
                        </div>
                        <div class="original-price">
                            <span>Original Price:</span>
                            <span> {{ App\Helper\Helper::currency_converter($productDetails['product_price']) }}</span>
                        </div>
                        @else
                        <div class="price">
                            <h4> {{ App\Helper\Helper::currency_converter($getDiscountPrice) }}</h4>
                        </div>
                        @endif
                    </div>
                    @endif

                    <div class="section-4-sku-information u-s-p-y-14">
                        <h6 class="information-heading u-s-m-b-8">Sku Information:</h6>
                        <div class="left">
                            <span>Product Code:</span>
                            <span>
                                <bold>&nbsp;{{ $productDetails['product_code'] }}</bold>
                            </span>
                        </div>
                        @if($totalStock>0)
                        <div class="availability">
                            <span>Availability:</span>
                            <span class="text-sucess">In Stock</span>
                            @else
                            <span>Availability:</span>
                            <span class="text-danger">Out Stock</span>
                            @endif
                        </div>
                        <div class="left">
                            @if($totalStock>0)
                            <span>Only:</span>
                            <span>&nbsp;{{ $totalStock }} left</span>
                            @endif
                        </div>

                        @if(isset($productDetails['vendor']) && isset($productDetails['vendor']['vendorbusinessdetails']) && isset($productDetails['vendor']['vendorbusinessdetails']['shop_name']))
                        <div class="availability">
                            <strong>Seller:</strong>
                            <a href="/products/{{ $productDetails['vendor']['id'] }}">{{ $productDetails['vendor']['vendorbusinessdetails']['shop_name'] }}</a>
                        </div>
                        @endif
                        <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                            <form action="{{ url('cart/add') }}" class="post-form addToCart" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">

                                @if($productDetails['is_offer_price']==="yes")
                                    <button type="button" class="button button-primary" style="background-color:#1E665E;" data-toggle="modal" data-target="#OfferOrderModal">Order Now</button>


                                @else
                                <div class="section-5-product-variants u-s-p-y-14">
                                    <h6 class="information-heading u-s-m-b-8">Product Variants:</h6>
                                    <div class="sizes u-s-m-b-11">
                                        <span>Available Size:</span>
                                        <br>
                                        <div class="size-variant select-box-wrapper">
                                            @if($productDetails['attributes'])
                                            <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}" style="width:100px;" class="form-control" id="" required="">
                                                <option value="" disabled selected>select</option>
                                                @foreach ($productDetails['attributes'] as $attribute )
                                                <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            <p class="text-danger">This product don't have available size </p>
                                            @endif
                                            @error('size')
                                            <small class=" text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity-wrapper u-s-m-b-22">
                                    <span>Quantity:</span>
                                    <div class="quantity">
                                        <input type="text" class="quantity-text-field" name="quantity" value="1">
                                        <a class="plus-a" data-max="100">+</a>
                                        <a class="minus-a" data-min="1">-</a>
                                    </div>
                                </div>
                                <div>
                                    <button class="button button-primary" type="submit">Add to cart</button>
                                    @php
                                    $countWishlist=0 @endphp
                                    @if(Auth::check())
                                    @php $countWishlist=Wishlist::countWishlist( $productDetails['id']) @endphp
                                    <button class="updateWishlist button button-outline-secondary u-s-m-l-6" data-productid="{{$productDetails['id']}}" type="button">
                                        <li class="@if($countWishlist>0) fas @else far @endif fa-heart"></li>
                                    </button>
                                    @else
                                    <button class="userlogin button button-outline-secondary u-s-m-l-6 " type="button">
                                        <li class="far fa-heart saved"></li>
                                    </button>
                                @endif

                                @endif

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <!-- Product-details /- -->
            </div>
        </div>
        <!-- Product-Detail /- -->
        <!-- Detail-Tabs -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="detail-tabs-wrapper u-s-p-t-80">
                    <div class="detail-nav-wrapper u-s-m-b-30">
                        <ul class="nav single-product-nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#specification">Specifications</a>
                            </li>
                            <li class="nav-item">
                                @php $getRating= Product::RatingCount($productDetails['id']) @endphp
                                <a class="nav-link" data-toggle="tab" href="#review">Reviews {{$getRating === 0 ? "" : "($getRating)" }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <!-- Description-Tab -->
                        <div class="tab-pane fade active show" id="description">
                            <div class="description-whole-container">
                                <p class="desc-p u-s-m-b-26">
                                    {!! $productDetails['description'] !!}
                                </p>
                                @if($productDetails['product_video'])
                                <video src="{{ asset('/storage/products/video/'.$productDetails['product_video']) }}" style="width:380px; margin-left:15px;  box-shadow:1px 1px 2px gray; height:250px" controls></video>
                                @else
                                <h2>Product Video does not exists</h2>
                                @endif
                            </div>
                        </div>
                        <!-- Description-Tab /- -->
                        <!-- Specifications-Tab -->
                        <div class="tab-pane fade" id="specification">
                            <div class="specification-whole-container">
                                <h4 class="spec-heading">Product Information</h4>
                                <table class="table table-bordered ">
                                    <tbody>
                                        @foreach ($productFilters as $filter)
                                        @if(isset($productDetails['category_id']))
                                        <?php
                                            $filterAvailable = ProductFilter::filterAvailable($filter['id'], $productDetails['category_id'])
                                            ?>
                                        @if($filterAvailable=="Yes")
                                        <tr>
                                            <td>
                                                <b>{{ $filter['filter_name'] }}</b>
                                            </td>
                                            <td>
                                                @foreach ($filter['filter_values'] as $value)
                                                @if(!empty($productDetails[$filter['filter_column']])&& $value['filter_value']==$productDetails[$filter['filter_column']])
                                                {{ ucwords($value['filter_value']) }}
                                                @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endif
                                        @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Specifications-Tab /- -->
                        <!-- Reviews-Tab -->
                        <div class="tab-pane " id="review">
                            <div class="review-whole-container">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6">
                                        <p>Users Reviews</p>
                                        @if(count($ratings)>0)
                                        @foreach($ratings as $rating)
                                        <div>
                                            <?php
                                                    $count=1;
                                                    while ($count<= $rating['rating']){ ?>
                                            <span>&#9733;</span>
                                            <?php $count++; } ?>
                                            <p>{{$rating['review']}}</p>
                                            <p>{{$rating['user']['name']}}</p>
                                            <p>{{date("d-m-Y",strtotime($rating['created_at']))}}</p>
                                            <hr>
                                        </div>
                                        @endforeach
                                        @else
                                        <p><b>Reviews are not available for this product!</b></p>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="your-rating-wrapper">
                                            <h6 class="review-h6">Your Review is matter.</h6>
                                            <h6 class="review-h6">Have you used this product before?</h6>
                                            <form method="POST" action="{{url('/add-rating')}}" name="ratingForm" id="ratingForm">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$productDetails['id']}}">
                                                <div class="rate text-left">
                                                    <input type="radio" id="star5" name="rating" value="5" />
                                                    <label for="star5" title="text">5 stars</label>
                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                    <label for="star4" title="text">4 stars</label>
                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                    <label for="star3" title="text">3 stars</label>
                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                    <label for="star2" title="text">2 stars</label>
                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label for="star1" title="text">1 star</label>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="review" style="width:220px; height:50px;" required>
                                                </textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-outline-secondary" type="submit" name="submit" value="Submit">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reviews-Tab /- -->
                    </div>
                </div>
            </div>
        </div>


        <!-- Different-Product-Section -->
        <div class="detail-different-product-section u-s-p-t-80">
            <!-- Similar-Products -->
            <section class="section-maker">
                <div class="container">
                    <div class="sec-maker-header text-left">
                        <h3 class="sec-maker-h3">Similar Products</h3>
                    </div>
                    <div class="slider-fouc">
                        <div class="products-slider owl-carousel" data-item="6">
                            @foreach ($similarProducts as $product )
                            <div class="border item  ml-2">
                                <div class="image-container">
                                    <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                        @if(isset($product['product_image']) || Storage::exists('products/' . $product['product_image']))
                                        <img class="img-fluid " src="{{ asset('storage/products/' . $product['product_image']) }}" alt="Product">
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
                                            {{ App\Helper\Helper::currency_converter($getDiscountPrice) }}
                                        </div>
                                        <div class="item-old-price">
                                            {{ App\Helper\Helper::currency_converter($product['product_price']) }}
                                        </div>
                                        @else
                                        {{App\Helper\Helper::currency_converter($product['product_price']) }}</s></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </section>
            <!-- Similar-Products /- -->
            <!-- Recently-View-Products  -->
            <section class="section-maker">
                <div class="container">
                    <div class="sec-maker-header text-left">
                        <h3 class="sec-maker-h3">Recently View</h3>
                    </div>
                    <div class="slider-fouc">
                        <div class="products-slider owl-carousel" data-item="6">
                            @foreach ($recentlyViewedProducts as $product)
                            <div class="item border">
                                <div class="image-container">
                                    <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                        @if(isset($product['product_image']) || Storage::exists('products/' . $product['product_image']))
                                            <img class="img-fluid " src="{{ asset('storage/products/' . $product['product_image']) }}" alt="Product">
                                            @else
                                            <img class="img-fluid " src="{{ asset('new_frontend/images/product/product@3x.jpg') }}" alt="Product">
                                            @endif
                                    </a>
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
                                            {{ App\Helper\Helper::currency_converter($getDiscountPrice) }}
                                        </div>
                                        <div class="item-old-price">
                                            {{ App\Helper\Helper::currency_converter($product['product_price']) }}
                                        </div>
                                        @else
                                        {{ App\Helper\Helper::currency_converter($product['product_price']) }}</s></span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <!-- Recently-View-Products /- -->
        </div>
        <!-- Different-Product-Section /- -->
    </div>
</div>
<script>
    $(document).ready(function() {

        $(".userlogin").click(function() {
            Swal.fire({
                icon: 'error'
                , title: 'Oops...'
                , text: 'Please login to apply Coupon!'
            });
        })

        $(".updateWishlist").click(function() {
            var product_id = $(this).data('productid');
            $.ajax({
                type: "post"
                , url: "/update-wishlist"
                , data: {
                    "product_id": product_id
                    , "_token": '{{csrf_token()}}'
                }
                , success: function(resp) {
                    if (resp.action == "add") {
                        $('button[data-productid=' + product_id + ']').html('<i class="fas fa-heart saved"></i>');
                        Swal.fire({
                            icon: 'success'
                            , title: 'Added'
                            , text: 'Product added to your wishlist'
                        });
                    } else if (resp.action == "remove") {
                        $('button[data-productid=' + product_id + ']').html('<i class="far fa-heart saved"></i>');
                        Swal.fire({
                            icon: 'error'
                            , title: 'Deleted'
                            , text: 'Product removed from wishlist'
                        });
                    }
                }
                , error: function() {
                    alert("Error");
                }
            });
        });

        // alert("test");
        $("#getPrice").change(function() {
            var size = $(this).val();
            var product_id = $(this).attr("product-id");
            // alert(product_id);
            $.ajax({
                type: "post"
                , url: '/get-product-price'
                , data: {
                    size: size
                    , product_id: product_id
                    , _token: '{{csrf_token()}}'
                }
                , success: function(resp) {
                    var symbolParagraph = document.getElementById("symbolParagraph");

                    // Get the value of the 'symbol' attribute
                    var symbolValue = symbolParagraph.getAttribute("symbol");

                    if (resp['discount_product_detail'] > 0) {
                        $(".getAttributePrice").html("<div class='price d-flex'> <span>Discount:</span><h2><strong> " + resp['final_price_product_detail'] + " " + symbolValue + " </strong>&nbsp;</div><span class='original-price'>Orginal Price &nbsp;<del>" + resp['product_detail_price'] + " " + symbolValue + "</del>&nbsp;</span>");
                    } else {
                        $(".getAttributePrice").html("<div class='price'><h4>  " + resp['final_price_product_detail'] + " " + symbolValue + "</h4></div>");
                    }
                }
                , error: function() {
                    alert("Error");
                }
            });
        });
    });

</script>
@endsection
@section('script')


@endsection

