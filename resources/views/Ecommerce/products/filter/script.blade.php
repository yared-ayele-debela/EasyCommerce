<script>
function fetchProducts(url = "{{ route('products.filter') }}") {
    $('#loader').show();

    $.ajax({
        url: url,
        type: 'GET',
        data: {
            group_ids: getCheckedValues('.filter-group'),
            category_ids: getCheckedValues('.filter-category'),
            brand_ids: getCheckedValues('.filter-brand'),
            vendor_ids: getCheckedValues('.filter-vendor'),
            discount_only: $('#discountOnly').is(':checked') ? 1 : 0,
            min_price: $('#minPrice').val(),
            max_price: $('#maxPrice').val(),
        },
        success: function (data) {
            $('#productContainer').html(data);
            $('#loader').hide();
        },
        error: function (err) {
            console.error(err);
            $('#loader').hide();
        }
    });
}

function getCheckedValues(selector) {
    return $(selector + ':checked').map(function () {
        return $(this).val();
    }).get();
}

// Trigger filters
$(document).on('change', '.form-check-input, #minPrice, #maxPrice', function () {
    fetchProducts();
});

// Pagination
$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    if (url) {
        fetchProducts(url);
    }
});
</script>
