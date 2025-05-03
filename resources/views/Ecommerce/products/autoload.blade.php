@extends('all_frontend_layouts.layouts')

@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()"><i class="bi bi-arrow-left"></i></button>
        <h5 class="my-4 text-dark text-center">All Products</h5>
    </div>
    <div id="product-container" class="row g-4">
        @include('Ecommerce.products._product_card')
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6 text-center">
            <button onclick="loadMoreEcommerceProducts()" class="btn btn-primary my-3 rounded rounded-1 text-center"><i class="bi bi-arrow-counterclockwise"></i> Load More</button>
        </div>
    </div>
    <div class="text-center my-1" id="loading" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<script>
    let page = 1;
    let loading = false;

    function loadMoreEcommerceProducts() {
        if (loading) return;
        loading = true;
        $('#loading').show();
        page++;

        $.ajax({
            url: "{{ route('ecommerce.products.all') }}?page=" + page
            , type: "GET"
            , success: function(data) {
                if (data.trim().length === 0) {
                    $(window).off('scroll');
                    $('#loading').html('<p class="text-muted">No more products.</p>');
                    return;
                }
                $('#product-container').append(data);
                $('#loading').hide();
                loading = false;
            }
            , error: function() {
                $('#loading').html('<p class="text-danger">Something went wrong.</p>');
            }
        });
    }

    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
            loadMoreProducts();
        }
    });

</script>
@endsection
