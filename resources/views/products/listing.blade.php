<?php use App\Models\Product;?>
<?php use App\Models\ProductFilter;
$productFilters=ProductFilter::productFilters();

?>
{{-- @extends('fontend.layout.layout')
@section('content') --}}
@extends('all_frontend_layouts.layouts')
@section('content')
<div class="page-shop my-4" style="padding-bottom: 6rem important;">
    <div class="container">
        <div class="row">
            @include('products.filters')
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="d-flex offer-card p-2 flex-wrap justify-content-between align-items-center mb-4">

                    @if (!isset($_REQUEST['search']))
                    <form id="sortProducts" name="sortProducts" method="GET" class="d-flex align-items-center gap-3">
                        <input type="hidden" name="url" id="url" value="{{ $url }}">
                        <div class="form-group mb-0">
                            <label for="sortproo" class="form-label visually-hidden">Sort By</label>
                            <select name="sort" id="sortproo" class="form-select form-select-sm">
                                <option value="">Sort By</option>
                                <option value="product_latest" {{ request('sort') == 'product_latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_lowest" {{ request('sort') == 'price_lowest' ? 'selected' : '' }}>Lowest Price</option>
                                <option value="price_heighst" {{ request('sort') == 'price_heighst' ? 'selected' : '' }}>Highest Price</option>
                                <option value="sort_a_z" {{ request('sort') == 'sort_a_z' ? 'selected' : '' }}>Name A-Z</option>
                                <option value="sort_z_a" {{ request('sort') == 'sort_z_a' ? 'selected' : '' }}>Name Z-A</option>
                            </select>
                        </div>
                    </form>
                    @endif
                    <div class="form-group mb-0">
                        <label for="show-records" class="visually-hidden">Show Records</label>
                        <select id="show-records" class="form-select form-select-sm">
                            <option selected>Show: {{ count($categoryProducts) }}</option>
                            <option value="">Showing All</option>
                        </select>
                    </div>
                </div>
                <div class="row product-container list-style filter_products" id="filter_products">
                    @include('products.ajax_products_listing')
                </div>
                @if (!isset($_REQUEST['search']))
                    <div class="mt-4">
                        @if (request()->has('sort'))
                            {{ $categoryProducts->appends(['sort' => request('sort')])->links() }}
                        @else
                            {{ $categoryProducts->links() }}
                        @endif
                    </div>
                @endif

                <!-- Category Description -->
                @if (!empty($categoryDetails['categoryDetails']['description']))
                <div class="mt-4">
                    {!! $categoryDetails['categoryDetails']['description'] !!}
                </div>
                @endif
            </div>
            <!-- Shop Right Wrapper /- -->
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleFilterBtn');
        const toggleIcon = document.querySelector("#toggleFilterBtn i");

        const filterSidebar = document.getElementById('filterSidebar');

        toggleBtn.addEventListener('click', function () {
            filterSidebar.classList.toggle('d-none');
            toggleIcon.classList.toggle("bi-toggle-on");
            toggleIcon.classList.toggle("bi-toggle-off");
        });
    });
</script>
<script>
 $(document).ready(function(){
    //sort by brand
    $(".brand").on("change", function() {

            var price=get_filter('price');
            var brand=get_filter('brand');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });
    //sort by price
     $(".price").on("change", function() {

            var brand=get_filter('brand');
            var price=get_filter('price');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });

    //Sort by color
    $(".color").on("change", function() {
            // $(".myDiv").load(".myDiv")
            //  this.form.submit();
         // alert("hello");
            var brand=get_filter('brand');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo").val();
            var price=get_filter('price');
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });

          //Sort by Size
         $(".size").on("change", function() {
            // $(".myDiv").load(".myDiv")
            //  this.form.submit();
           // alert("hello");
            var price=get_filter('price');
            var color=get_filter('color');
            var size=get_filter('size');
            var brand=get_filter('brand');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });


        //Sort by Filter
        $("#sortproo").on("change", function() {
            // $(".myDiv").load(".myDiv")
            //  this.form.submit();
         // alert("hello");
            var brand=get_filter('brand');
            var price=get_filter('price');
            var sort=$("#sortproo").val();
            var url=$("#url").val();
            var color=get_filter('color');
            var size=get_filter('size');
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach

            // alert(url);
            $.ajax({
                url:url,
                method:'Post',
                data:{
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                      $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }

            });
        });


        //dynamic filters
        @foreach ($productFilters as $filter)
         $('.{{ $filter['filter_column'] }}').on('click',function(){
            var url=$("#url").val();
            var price=get_filter('price');
            var brand=get_filter('brand');
            var color=get_filter('color');
            var size=get_filter('size');
            var sort=$("#sortproo option:selected").val();
            @foreach ($productFilters as $filters)
                var {{ $filters['filter_column'] }} =get_filter('{{ $filters['filter_column'] }}');
            @endforeach
            $.ajax({

                url:url,
                method:'Post',
                data:
                {
                 @foreach ($productFilters as $filters)
                  {{ $filters['filter_column'] }}:{{ $filters['filter_column'] }},
                 @endforeach

                sort:sort,size:size,color:color,price:price,brand:brand,
                url:url,_token: '{{csrf_token()}}'
                },
                success:function(data){
                    $('#filter_products').html(data);
                },error:function(){
                    alert("Error");
                }
            });
         });
         @endforeach

         function get_filter(class_name){
            var filter=[];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
            return filter;

         }
});
</script>

@endsection
