<?php use App\Models\Product;?>

@extends('fontend.layout.layout')
@section('content')
<script src="https://kit.fontawesome.com/e8fa2e31b4.js" crossorigin="anonymous"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<style>
    .card-img-tiles {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        position: relative;
        background-color: #fff;
        z-index: 5
    }

    .card-img-tiles .main-img>img,
    .card-img-tiles .thumblist>img {
        display: block;
        width: 100%
    }

    .card-img-tiles .main-img {
        width: 67%;
        padding-right: .375rem
    }

    .card-img-tiles .thumblist {
        width: 33%;
        padding-left: .375rem
    }

    .card-img-tiles .thumblist>img {
        margin-bottom: .75rem
    }

    .card-img-tiles .thumblist>img:last-child {
        margin-bottom: 0
    }

    .mb-grid-gutter {
        margin-bottom: 30px !important;
    }

    .cont {
    gap: 30px;
    width: 60%;
    border-radius: 5px;
    padding: 30px;
    }
    .counter{
    display: flex;
    gap: 30px;
    margin-top: 30px;
    }


    .box span{
    font-size: 30px;
    }
    .box p{
    margin: 0;
    }
    .name{
    display: flex;
    gap: 40px;
    }

    .store-banner {
    width: 100%;
    height: 60px;
    object-fit: cover;
    }

    .seller-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    position: absolute;
    left: 20px;
    top: 90%;
    border: 5px solid rgb(255, 255, 255);
    transform: translateY(-50%);
    }

/* for flash deal banner */
.position-relative {
    position: relative;
}

.overlay-text {
    position: absolute;
    top: 50%; /* Adjust this value to position the text vertically */
    left: 50%; /* Adjust this value to position the text horizontally */
    transform: translate(-50%, -50%);
    text-align: center; /* Adjust text alignment as needed */
    color: white; /* Text color */
    /* Additional styling */
    background: #1E665E; /* Background color for better readability */
    padding: 10px;
    border-radius: 5px; /* Add border-radius for style */
}
.overlay-category-text{
    position: absolute;
    top: 50%; /* Adjust this value to position the text vertically */
    left: 30%; /* Adjust this value to position the text horizontally */
    transform: translate(-50%, -50%);
    text-align: left; /* Adjust text alignment as needed */
    color: white; /* Text color */
    padding: 2px;
    border-radius: 5px;
}
.category-position {
    position: relative;
}
.cards {
     border:none;
    /* border: 0.5px solid #DCDCDD; */
    margin: 10px 4px;
    transition: .6s ease;
    }

    .cards:hover {
    transform: scale(1.05);
    }

    .scrollcards {
    background-color: #fff;
    overflow: auto;
    white-space: nowrap;
    }

    ::-webkit-scrollbar {
    width: 0px;
    height: 0px;
    background: transparent;
    }

    div.scrollcards .card {
    display: inline-block;
    padding: 7px;
    text-decoration: none;
    height: auto;
    /* width: 300px; */
    }
    .circle-image {
    text-align: center;
    }

    .circle-image img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
    }

    .circle-image p {
    font-weight: bold;
    }
/* new  */
    .scrolling-wrapper{
	overflow-x: auto;
   }


    @media (max-width: 992px) {
      .category-banner {
        margin-top: 20px;

      }
      .category_discount_list{
        padding:none;
      }
      .banners {
            padding:0px 15px;
            margin-top:8px;
        }
    }



    .shop-button:hover{
          background-color: #e1e9e8;
          color:1E665E;
          border:none;
    }
    .shop-button{
        border:0.5px solid #82A9A4;
        border-radius: 0.2rem;
         background:transparent;
         color:white;
    }
    @media (min-width: 992px) {
    .banners {
            padding:0px 45px; /* Adjust the padding value as needed */
            margin-top: 15px;
        }
    }
    .all-product-layout{
        position: relative;
        width: 90%;
        min-height: 1px;
        padding-right: 0px;
        padding-left: 0px;
    }


</style>


<div class="container-fluid banners ">
    <div class="row">
      <div class="col-lg-8">
        <div id="imageSlider" class="carousel slide "  data-ride="carousel">
          <ol class="carousel-indicators">
           @foreach ($banners as $index => $banner)
            <li data-target="#imageSlider" class="text-dark" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
           @endforeach
          </ol>
          <div class="carousel-inner">
            @foreach ($banners as $index => $banner)
            <div class="carousel-item  {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('/storage/banner/'.$banner['image']) }}" alt="Slider Image {{ $index + 1 }}" style="border-radius: 0.2rem;" class="d-block w-100">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="" style="font-size: 30px; text-weight:bold; ">{{ $banner['title'] }}</h1>
                    <p class="text-dark">{{ $banner['alt'] }}</p>
                </div>
             </div>
             @endforeach
          </div>
          <a class="carousel-control-prev" href="#imageSlider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#imageSlider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="category-banner">
            <div class="row">
          @foreach ($categoriesWithHighDiscount as $category)
          <div class="col-md-6 mb-4 ">
            <div class="category-position d-flex flex-column">
                @php
                $imagePath = public_path('storage/category/' . $category['banner_image']);
                @endphp

                @if (File::exists($imagePath))
                @if ($category['banner_image'])
                    <img src="{{ asset('storage/category/' . $category['banner_image']) }}" alt="Category Image">
                @else
                <img src="{{ asset('default/1noimage.jpg') }}" class="img-fluid h-100 shadow-sm" style="border-radius: 0.2rem;" alt="Category Image">
                @endif

                @else
                <img src="{{ asset('default/1noimage.jpg') }}" class="img-fluid h-100 shadow-sm" style="border-radius: 0.2rem;" alt="Category Image">
                @endif


                <div class="mt-3 overlay-category-text pl-4">
                <h5 class="text-white ">{{ $category->name }}</h5>
                <p class="text-white text-bold d-flex" style="font-size: 20px;">{{ $category->discount }}% OFF</p>

                <a href="{{ url('category/'.$category['id']) }}" class="shop-button shadow-sm button text-md mt-2" >SHOP NOW</a>
              </div>
            </div>
          </div>
          @endforeach
            </div>
        </div>
      </div>
    </div>
  </div>



<section class="section-maker pb-3 pt-3">
    <div class="container   banners shadow-sm p-3">
        <div class="d-flex justify-content-between pb-2">
            <div class="text-left">
                <h3 class="sec-maker-h4 text-left text-dark " ><b>SELLER</b></h3>
            </div>
            <div class="text-right">
                <h3 class="sec-maker-h4 text-left"><a href="{{ url('vendors') }}"><b>All</b></a></h3>
            </div>
        </div>
    <div class="sellercontainer">
        <div class="scrolling-wrapper row flex-row flex-nowrap">
            @foreach ($allvendor as $vendor )
            <div class="col-lg-3 col-12 col-md-4 mb-4" style="border: none;">
                <div class="card d-flex flex-column h-100" style="border:0.3px solid #e7f2f1;">
                    <div class="position-relative">

                        @if(!empty($vendor->adminvendor['image']))
                        <img src="{{ asset('storage/admin/image/'.$vendor->adminvendor['image']) }}" class="seller-image shadow-sm" alt="Seller Image">
                        @else
                        <img src="{{ asset('no_vendor.png') }}" class="seller-image shadow-sm" alt="Seller Image">
                        @endif

                        @if(!empty($vendor->vendorbusinessdetails['shop_image']))
                        <img src="{{ asset('storage/admin/image/'.$vendor->vendorbusinessdetails['shop_image']) }}" class="card-img-top store-banner" alt="Seller Banner">
                        @else
                        <img src="{{ asset('banner.png') }}" class="card-img-top store-banner" alt="Seller Banner">
                        @endif
                        <p style="padding-left: 105px;" style="color:#1E665E;">{{ $vendor->name }}</p>
                    </div>
                    <div class="card-body mt-3 d-flex flex-row pt-4 justify-between  flex-fill">
                        @php
                        $id = $vendor->id;
                        $ratingCount = $vendorRatingsCount[$id] ?? 0; // Get the count for the current vendor ID or default to 0
                    @endphp
                            <a href='/products/{{ $vendor->id }}' class="pull-right pt-1 pl-3 pr-3 pb-1" style="border-radius:0.2rem; color:#1E665E; background-color:#F3F5F9;">Review({{ $ratingCount }})</a>
                            &nbsp;
                            <a href='/products/{{ $vendor->id }}' class="pull-right pt-1 pl-3 pr-3 pb-1" style="border-radius:0.2rem; color:#1E665E; background-color:#F3F5F9;">Products({{ $vendor->products_count }})</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</section>


@if(!empty($featured_flash_deal))
 @foreach ($featured_flash_deal as $flash_deal)
 @php
    $endDate = Carbon\Carbon::parse($flash_deal->end_date)->format('Y-m-d') ;
@endphp
<div class="container shadow-sm p-3" style="background-color: #e7f2f1;">
    <div class=" text-left ">
        <h3 class="sec-maker-h3">Flash Deal</h3>
    </div>
    <div class="row">
        <div class="col-md-3 position-relative">
            <img src="{{ asset('/storage/banners/'.$flash_deal['banner']) }}" style="border-radius: 0.3rem; " class="img-fluid w-100 h-100 px-2" alt="Banner Image">
            <div class="overlay-text">
                {{-- <h2 class="mt-3 text-white">{{ $flash_deal->title }}</h2> --}}
                <div class="section-timing-wrapper">
                    <div class="section-box-wrapper box-days">
                        <div class="section-box text-white">
                            <span class="section-key"><span id="days"></span></span>
                            <span class="section-value">Days</span>
                        </div>
                    </div>
                    <div class="section-box-wrapper box-hrs">
                        <div class="section-box text-white">
                            <span class="section-key"> <span id="hours"></span></span>
                            <span class="section-value">HRS</span>
                        </div>
                    </div>
                    <div class="section-box-wrapper box-mins">
                        <div class="section-box text-white">
                            <span class="section-key"><span id="minutes"></span></span>
                            <span class="section-value">MINS</span>
                        </div>
                    </div>
                    <div class="section-box-wrapper box-secs">
                        <div class="section-box text-white">
                            <span class="section-key"><span id="seconds"></span></span>
                            <span class="section-value">SEC</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="wrapper-content">
                <div class="outer-area-tab">
                    <div class="tab-content">
                        <div class="tab-pane active show fade" id="men-latest-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="5">
                                    @foreach ($flash_deal_products as $flash_deal_product )
                                    <div class="border item ml-2">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$flash_deal_product->product['id']) }}">
                                                @if($flash_deal_product->product['product_image'])
                                                <img class="img-fluid " src="{{ asset('/storage/products/'.$flash_deal_product->product['product_image']) }}" alt="Product">
                                                @else
                                                <img class="img-fluid " src="{{ asset('new_frontend/images/product/product@3x.jpg') }}" alt="Product">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li class="has-separator">
                                                        <a href="javascript:void();">{{ $flash_deal_product->product['product_code'] }}</a>
                                                    </li>
                                                    <li class="has-">
                                                        <a href="javascript:void();">{{ $flash_deal_product->product['product_color'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$flash_deal_product->product['id']) }}">{{ $flash_deal_product->product['product_name'] }}</a>
                                                </h6>

                                            </div>

                                            <div class="price-template">
                                                <?php
                                                    $getDiscountPrice=Product::getDiscountPrice($flash_deal_product->product['id']);
                                                    $orginal_price=$flash_deal_product->product['product_price'];

                                                ?>
                                                @if($getDiscountPrice>0)
                                                <div class="item-new-price">
                                                    {{  App\Helper\Helper::currency_converter($getDiscountPrice) }}
                                                </div>
                                                <div class="item-old-price">
                                                    {{  App\Helper\Helper::currency_converter($orginal_price) }}
                                                </div>
                                                @else
                                                {{  App\Helper\Helper::currency_converter($orginal_price) }}</s></span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <!-- Product Not Found /- -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</section>
<br>
 @endforeach
@endif



<section class="section-maker pb-3">
    <div class="container shadow-sm p-4" >
        <div class="d-flex justify-content-between pb-2">
            <div class="text-left">
                <h3 class="sec-maker-h4 text-left text-dark " ><b>FEATURED PRODUCTS</b></h3>
            </div>
            <div class="text-right">
                <h3 class="sec-maker-h4 text-left"><a href="{{ url('all-products') }}"><b>All Products</b></a></h3>
            </div>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="6">
                                @foreach ($isfeatured as $product )
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
                                             @if($product['is_offer_price']==="yes")
                                               <a href="{{ url('product/'.$product['id']) }}" class="btn btn-sm"style="background-color: #1E665E;color:white;">Offer Prices</a>
                                             @else
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
                                             @endif


                                        </div>
                                    </div>
                                    <div class="tag " style="background-color: #1E665E; font-size:7px;">
                                        <span>featured</span>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-maker pb-3">
    <div class="container p-2">
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                    @foreach ($groups as $group)
                                    <div class="card border-0 shadow-sm mb-3  ml-2">
                                            <div class="card-header bg-white border-0 sec-maker-h3">
                                                {{ $group->name }}
                                            </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if($group->categories->isNotEmpty())
                                                @foreach($group->categories as $category)
                                                <div class="col-6" >
                                                    <a href="{{ url('category/'.$category['id']) }}">
                                                    @if (Storage::exists('public/category/'.$category['image']))
                                                    <img src="{{ asset('/storage/category/'.$category['image']) }}" class="img-fluid">
                                                    @else
                                                    <img src="{{ asset('default/default_category.png') }}" class="img-fluid">
                                                    @endif
                                                    <p class=" text-center">{{ $category['name'] }}</p>
                                                    </a>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-maker pb-3">
    <div class="container shadow-sm p-4 ">
        <div class="d-flex justify-between mb-2">
            <h3 class="sec-maker-h3 text-left">LATEST PRODUCTS</h3>
            {{-- <a href="{{ url('allproducts') }}" class="sec-maker-h3 text-left ">ALL PRODUCTS</a> --}}
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="6">
                                @foreach ($new_products as $product )
                                <div class="border item ml-2">
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
                                    <div class="tag new">
                                        <span class="" >New</span>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
    @if(isset($fixbanners[0]['image']))
      <div class="col-md-6">
        <div class="banner mb-4">
            <a href="{{ $fixbanners[0]['link']}}"  target="_blank"  class="mx-auto banner-hover effect-dark-opacity">
            <img title="" class="img-fluid" src="{{ asset('/storage/banner/'.$fixbanners[0]['image']) }}" alt="Winter Season Banner">
          <!-- You can add additional content or remove the alt text -->
            </a>
        </div>
      </div>
    @endif
    @if(isset($fixbanners[1]['image']))
      <div class="col-md-6">
        <div class="banner mb-4">
            <a href="{{ $fixbanners[1]['link']}}"  target="_blank"  class="mx-auto banner-hover effect-dark-opacity">
          <img title="" class="img-fluid" src="{{ asset('/storage/banner/'.$fixbanners[1]['image']) }}" alt="Winter Season Banner">
            </a>
        </div>
      </div>
      @endif

    </div>
  </div>

<section class="section-maker pb-3">
    <div class="container shadow-sm p-4">
        <div class=" text-left ">
            <h3 class="sec-maker-h3">DISCOUNT PRODUCTS</h3>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="6">
                                @foreach ($discountedproduct as $product )
                                <div class="border item ml-2">
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
                                    <div class="tag discount">
                                        <span class="" style="font-size:7px;">discount</span>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>


<div class="container pt-3">
    <div class="d-flex justify-content-between pb-2">
        <div class="text-left">
            <h3 class="sec-maker-h4 text-left text-dark " ><b>CATEGORIES</b></h3>
        </div>
        <div class="text-right">
            <h3 class="sec-maker-h4 text-left"><a href="{{ url('vendors') }}"><b>All</b></a></h3>
        </div>
    </div>
    <div class="row">
        <div class="scrollcards">
            @foreach ($getCategory as $category)
            <div class="card cards shadow-sm ">
                <div class="circle-image">
                <div class="">
                     <a href="{{ url('category/'.$category['id']) }}">
                    @if($category['image'])
                    <img src="{{ asset('/storage/category/'.$category['image']) }}" class="img-fluid">
                    @else
                    <img src="{{ asset('new_frontend/images/banners/b1.png') }}" class="img-fluid">
                    @endif
                </a>
                    <p>{{ $category['name'] }}</p>
                </div>
                </div>
            </div>
            @endforeach
         </div>
    </div>
</div>

@if($producthome)
<section class="section-maker pb-3 pt-3">
    <div class="container shadow-sm p-4">
        <div class=" text-left ">
            <h3 class="sec-maker-h3">HOME SUPPLIES</h3>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="6">
                                @foreach ($producthome as $product )
                                <div class="border item ml-2">
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
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if(isset($fixbanners[2]['image']))
{{-- <div class="banner-layer"> --}}
    <div class="container">
        <div class="image-banner">
            <a href="{{ $fixbanners[2]['link']}}"  target="_blank"  class="mx-auto banner-hover effect-dark-opacity">
                <img title="" class="img-fluid" src="{{ asset('/storage/banner/'.$fixbanners[2]['image']) }}" alt="Winter Season Banner">
            </a>
        </div>
    </div>
{{-- </div> --}}
@endif

@if($productsmartphones)
<section class="section-maker pb-3 pt-3">
    <div class="container shadow-sm p-4">
        <div class=" text-left ">
            <h3 class="sec-maker-h3">SMART PHONES</h3>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="6">
                                @foreach ($productsmartphones as $product )
                                <div class="border item ml-2">
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
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(isset($fixbanners[3]['image']))
{{-- <div class="banner-layer"> --}}
    <div class="container">
        <div class="image-banner">
            <a href="{{ $fixbanners[3]['image'] }}" target="_blank" class="mx-auto banner-hover effect-dark-opacity">
                <img title="" class="img-fluid" src="{{ asset('/storage/banner/'.$fixbanners[3]['image']) }}" alt="Winter Season Banner">
            </a>
        </div>
    </div>
{{-- </div> --}}
@endif
@if($productbooks)
<section class="section-maker pb-3 pt-3">
    <div class="container shadow-sm p-4">
        <div class=" text-left ">
            <h3 class="sec-maker-h3">BOOKS</h3>
        </div>
        <div class="wrapper-content">
            <div class="outer-area-tab">
                <div class="tab-content">
                    <div class="tab-pane active show fade" id="men-latest-products">
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="6">
                                @foreach ($productbooks as $product )
                                <div class="border item ml-2">
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
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Product Not Found /- -->
                </div>
            </div>
        </div>
    </div>
</section>
@endif


<div class="container pt-3">
    <div class=" text-left ">
        <h3 class="sec-maker-h3">BRANDS</h3>
    </div>
    <div class="row">
      <div class="scrollcards">
        @foreach ($allbrands as $brand)
        <div class="card cards shadow-sm ">
            <div class="circle-image">
                <a href="{{ url('product/brand/'.$brand['id'])}}">
                    @if($brand['image'])
                    <img src="{{ asset('/storage/brand/'.$brand['image']) }}" class="img-fluid">
                    @else
                    <img src="{{ asset('new_frontend/images/banners/b1.png') }}" class="img-fluid">
                    @endif
                </a>
              {{-- <p>{{ $category['name'] }}</p> --}}
            </div>
          </div>
        @endforeach
      </div>
    </div>
</div>

    {{-- <div class="page-deal u-s-p-t-80"> --}}
        <div class="container">
            <div class="row" id="data-containers">
                    @include('fontend.layout.autoloadproduct.data')
            </div>
        </div>
        {{-- <div class="text-center">
            <button class="button button-primary" id="load-mores">Load More</button>
        </div> --}}
    {{-- </div> --}}


<section class="app-priority">
    <div class="container">
        <div class="priority-wrapper u-s-p-b-80">
            <div class="row  mt-3 mb-3 pb-2 ">
                <div class=" col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-md-star"></i>
                        </div>
                        <h2>
                            Great Value
                        </h2>
                        <p>We offer competitive prices on our 100 million plus product range</p>
                    </div>
                </div>
                <div class="  col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-md-cash"></i>
                        </div>
                        <h2>
                            Shop with Confidence
                        </h2>
                        <p>Our Protection covers your purchase from click to delivery</p>
                    </div>
                </div>
                <div class="  col-lg-3 col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-ios-card"></i>
                        </div>
                        <h2>
                            Safe Payment
                        </h2>
                        <p>Pay with the world’s most popular and secure payment methods</p>
                    </div>
                </div>
                <div class="col-lg-3   col-md-3 col-sm-3">
                    <div class="single-item-wrapper">
                        <div class="single-item-icon">
                            <i class="ion ion-md-contacts"></i>
                        </div>
                        <h2>
                            24/7 Help Center
                        </h2>
                        <p>Round-the-clock assistance for a smooth shopping experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script>
    var pages = 2;

    $(document).ready(function(){
        loadMoreData();
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadMoreData();
            }
        });
    });

    function loadMoreData() {
        $.ajax({
            url: '/fetch-product-data?page=' + pages,
            type: 'get',
            dataType: 'html',
            success: function(response){
                $('#data-containers').append(response);
                pages++;
            }
        });
    }
</script>
@if ($featured_flash_deal->isNotEmpty())

<script>

    var timer;
    var endDate = new Date("{{ $endDate }}"); // Use the fetched end_date

    timer = setInterval(function () {
        timeBetweenDates(endDate);
    }, 1000);

    function timeBetweenDates(toDate) {
        var now = new Date();
        var difference = toDate.getTime() - now.getTime();

        if (difference <= 0) {
            clearInterval(timer);
        } else {
            var seconds = Math.floor(difference / 1000);
            var minutes = Math.floor(seconds / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours / 24);

            hours %= 24;
            minutes %= 60;
            seconds %= 60;

            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("minutes").innerHTML = minutes;
            document.getElementById("seconds").innerHTML = seconds;
        }
    }
</script>
<script>
    "use strict";

productScroll();

function productScroll() {
  let slider = document.getElementById("slider");
  let next = document.getElementsByClassName("pro-next");
  let prev = document.getElementsByClassName("pro-prev");
  let slide = document.getElementById("slide");
  let item = document.getElementById("slide");

  for (let i = 0; i < next.length; i++) {
    //refer elements by class name

    let position = 0; //slider postion

    prev[i].addEventListener("click", function() {
      //click previos button
      if (position > 0) {
        //avoid slide left beyond the first item
        position -= 1;
        translateX(position); //translate items
      }
    });

    next[i].addEventListener("click", function() {
      if (position >= 0 && position < hiddenItems()) {
        //avoid slide right beyond the last item
        position += 1;
        translateX(position); //translate items
      }
    });
  }

  function hiddenItems() {
    //get hidden items
    let items = getCount(item, false);
    let visibleItems = slider.offsetWidth / 210;
    return items - Math.ceil(visibleItems);
  }
}

function translateX(position) {
  //translate items
  slide.style.left = position * -210 + "px";
}

function getCount(parent, getChildrensChildren) {
  //count no of items
  let relevantChildren = 0;
  let children = parent.childNodes.length;
  for (let i = 0; i < children; i++) {
    if (parent.childNodes[i].nodeType != 3) {
      if (getChildrensChildren)
        relevantChildren += getCount(parent.childNodes[i], true);
      relevantChildren++;
    }
  }
  return relevantChildren;
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
  const sliderContainer = document.querySelector('.slider-container');
  let slideIndex = 0;

  function showSlides() {
    const slides = sliderContainer.children;
    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = 'none';
    }
    slideIndex++;
    if (slideIndex > slides.length) {
      slideIndex = 1;
    }
    slides[slideIndex - 1].style.display = 'block';
    setTimeout(showSlides, 3000); // Change slide every 3 seconds (3000 milliseconds)
  }

  showSlides(); // Start the slideshow
});

</script>
@endsection
@endif
