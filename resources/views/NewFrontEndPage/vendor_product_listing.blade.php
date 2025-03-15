
<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@extends('fontend.layout.layout')
@section('content')
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

    .counter {
        display: flex;
        gap: 30px;
        margin-top: 30px;
    }


    .box span {
        font-size: 30px;
    }

    .box p {
        margin: 0;
    }

    .name {
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
        top: 50%;
        /* Adjust this value to position the text vertically */
        left: 50%;
        /* Adjust this value to position the text horizontally */
        transform: translate(-50%, -50%);
        text-align: center;
        /* Adjust text alignment as needed */
        color: white;
        /* Text color */
        /* Additional styling */
        background: #04A777;
        /* Background color for better readability */
        padding: 10px;
        border-radius: 5px;
        /* Add border-radius for style */
    }

    .cards {
        border: none;
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
    .scrolling-wrapper {
        overflow-x: auto;
    }

</style>
<div class="container p-3 mt-3">
    <div class="rounded p-4" style="height: 200px; background-image:
    @if(!empty($vendor->vendorbusinessdetails['shop_image'])) url('{{ asset($allvendor->vendorbusinessdetails['shop_image']) }}'); @else url('{{ asset('admin/no.jpg') }}');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 300px;
    @endif">
        <div class="row align-items-center mb-auto" style="padding-top: 150px;">
            <div class="col-md-12 d-flex align-items-start justify-content-start rounded-md bg-white pl-0">
                <div class="p-1">
                    @if(!empty($allvendor->adminvendor['image']))
                    <img src="{{ asset('storage/admin/image/'.$allvendor->adminvendor['image']) }}" class="img-fluid rounded-md" style="height: 100px; max-width: 100px;" alt="Seller Image">
                    @else
                    <img src="{{ asset('admin/no_image.jpg') }}" class="img-fluid rounded-md" style="height: 100px; max-width: 100px;" alt="Seller Image">
                    @endif
                </div>
                &nbsp;
                <div class="text-white pt-5">
                    <h4 class="" style="color:#1E665E;"><strong>{{ $allvendor->name }}</strong></h4>
                    <p  style="color:#000000;">Address : {{ $allvendor->address }}, {{ $allvendor->city }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-3">
    <div class="row">
    @foreach ($vendorProducts as $product)
        <div class="col-lg-3 col-12">
            <div class="item border ">
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
</div>
    <div class="col-md-12 d-flex justify-content-center">
        {{ $vendorProducts->links() }}
    </div>
</div>
@endsection


