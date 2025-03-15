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

<div class="container p-3 mt-3 shadow-sm">
    <div class="rounded p-4" style="background-color:#E7F2F1">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="" style="color:#1E665E;">ALL STORES</h3>
                <p  style="color:#1E665E;">Find your desired stores and shop your favorite products</p>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <form action="{{ route('all-vendor') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control border-0" style="border-radius: 0.2rem; height: 40px;" placeholder="Search...">
                    <button type="submit" class="btn text-dark ml-2" style="background-color: #E9F3FF;">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3 shadow-sm p-3 mb-3">
    <div class="row">
        @foreach ($allvendors as $vendor)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card  h-100" style="border:0.3px solid #E7F2F1;">
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
                    <p class="mt-3 text-center">{{ $vendor->name }}</p>
                </div>
                <div class="card-body d-flex mt-3 justify-content-between">
                    <a href='/products/{{ $vendor->id }}' class="btn btn-sm btn-light" style="border-radius:0.2rem; color:#1E665E; background-color:#F3F5F9;">Review(0)</a>
                    <a href='/products/{{ $vendor->id }}' class="btn btn-sm btn-light" style="border-radius:0.2rem; color:#1E665E; background-color:#F3F5F9;">Products(0)</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-md-12 d-flex justify-content-center">
        {{ $allvendors->links() }}
    </div>
</div>
@endsection

