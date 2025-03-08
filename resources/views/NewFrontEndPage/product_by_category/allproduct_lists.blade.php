<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();
?>
@extends('fontend.layout.layout')
@section('content')
<div class="container p-3 mt-3 shadow-sm">
    <div class="rounded p-4" style="background-color:#E7F2F1">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="" style="color:#1E665E; font-size:20px;"><b>All Products</b></h1>
                <p  style="color:#1E665E;">

                ({{ $countproducts }}) Items found</p>
            </div>

        </div>
    </div>
</div>

{{-- <section class="section-maker mt-3"> --}}
    <div class="container shadow-sm p-4 mb-3">
        <div class="wrapper-content">
            <div class="row" id="data-container">
                @include('NewFrontEndPage.product_by_category.data')
            </div>
        </div>
       
    </div>
{{-- </section> --}}
@endsection
@section('script')

<script>
    var pages = 2;
  
      $(document).ready(function(){
          // Initial load
          loadMoreData();
          // Auto-scroll detection
          $(window).scroll(function() {
              if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                  loadMoreData();
              }
          });
      });
  
      function loadMoreData() {
          $.ajax({
              url: '/fetch-data?page=' + pages,
              type: 'get',
              dataType: 'html',
              success: function(response){
                  $('#data-container').append(response);
                  pages++;
              }
          });
      }
  </script>
@endsection
