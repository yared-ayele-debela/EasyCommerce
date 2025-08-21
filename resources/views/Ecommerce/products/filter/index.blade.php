@extends('all_frontend_layouts.layouts')
@section('content')
<style>
.loader {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: inline-block;
  border-top: 4px solid #FFF;
  border-right: 4px solid transparent;
  box-sizing: border-box;
  animation: rotation 1s linear infinite;
}
.loader::after {
  content: '';
  box-sizing: border-box;
  position: absolute;
  left: 0;
  top: 0;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border-left: 4px solid #3ebb49;
  border-bottom: 4px solid transparent;
  animation: rotation 0.5s linear infinite reverse;
}
@keyframes rotation {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div class="container-fluid p-4 my-4">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Filter Products</h5>
    </div>
    <div class="row">
        <div class="col-md-3">
            @include('Ecommerce.products.filter.filters')
        </div>
        <!-- Product Display -->
         <div class="col-md-9">
            <div id="loader" class="text-center my-5" style="display:none;">
                <div class="loader mx-auto position-relative"></div>
            </div>
            <div id="productContainer">
                @include('Ecommerce.products.filter.product-list', ['products' => \App\Models\Product::paginate(20)])
            </div>
        </div>
    </div>
</div>
@include('Ecommerce.products.filter.script')


@endsection

