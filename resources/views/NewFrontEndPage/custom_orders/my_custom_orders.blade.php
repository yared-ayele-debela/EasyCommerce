@extends('fontend.layout.layout')
@section('content')
<style>
    /* Custom CSS to hide horizontal scrollbar */
    @media (max-width: 576px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE 10+ */
        }

        .table-responsive::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }
    }

</style>

<!-- About-Page -->
<div class="page-about u-s-p-t-80">

    <div class="container">

        <h1 class="text-xl mb-2 ">My Custom Orders</h1>

        <div class="row">
            {{-- @if(isset($custom_order) && count($custom_order) > 0) --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header border-0">

                               <strong>User Code : {{ $custom_order->user_code }}</strong>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Order ID: {{ $custom_order->id }}</h5>
                                <p class="card-text">Status:
                                    @if($custom_order->status=="pending")
                                        <span class="btn btn-sm button-primary text-white">{{ $custom_order->status }}</span>
                                    @endif
                                    @if($custom_order->status=="approved")
                                        <span class="btn btn-sm button-primary text-white">{{ $custom_order->status }}</span>
                                    @endif
                                </p>
                                <p class="card-text">Customer Name: {{ $custom_order->customer_name }}</p>
                                <p class="card-text">Phone Number: {{ $custom_order->phone_number }}</p>
                                <h6 class="mt-4 mb-2">Order Products</h6>
                                @foreach ($custom_order->custom_order_product as $product)
                                    <div class="border-top  mb-2 pb-3">
                                        <p class="card-text mt-2">Product: {{ $product['product_name'] }}</p>
                                        <p class="card-text">Quantity: {{ $product['quantity'] }}</p>
                                        <p class="card-text">Description: {{ $product['description'] }}</p>
                                        <p class="card-text">Delivery Address: {{ $product['delivery_address'] }}</p>
                                        <p class="text-sm text-right"><i>Date: {{ $product['created_at']->format('d/m/Y') }}</i></p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
        </div>
    </div>

</div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        $('.buttons').click(function () {
            // Get the file input value
            var fileInput = $('#Payment Reciept');
            var file = fileInput[0].files[0];

            // Get the order ID from the modal title
            var orderId = $(this).closest('.modal-content').find('.modal-title').text().replace('upload payment receipt for ', '');

            // Prepare form data
            var formData = new FormData();
            formData.append('payment_receipt', file);

            // Make an AJAX request to upload the payment receipt
            $.ajax({
                url: '/orders/' + orderId + '/upload-payment-receipt',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Handle success, e.g., display a success message
                    console.log(response);
                },
                error: function (error) {
                    // Handle errors, e.g., display an error message
                    console.log(error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        let row_number = 1;
        $("#add_row").click(function(e) {
            e.preventDefault();
            let new_row_number = row_number - 1;
            $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
            $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
            row_number++;
        });

        $("#delete_row").click(function(e) {
            e.preventDefault();
            if (row_number > 1) {
                $("#product" + (row_number - 1)).html('');
                row_number--;
            }
        });
    });

</script>

