<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@extends('fontend.layout.layout')
@section('content')

<div class="page-deal u-s-p-t-80">
    <div class="container">
        <div class="row product-container grid-style">
            <div class="product-item col-lg-3 col-md-6 col-sm-6">
                   @include('NewFrontEndPage.vendor_product_listing')
            </div>
        </div>
        <div>{{ $vendorProducts->links() }}</div>

    </div>
</div>
@endsection
