<?php use App\Models\Product; ?>

@extends('fontend.layout.layout')
@section('content')

<div class="page-cart u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" id="appendCartItems">
                @include('NewFrontEndPage.products.cart_item')
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>
    $(document).ready(function() {
        $(document).on('submit', '#ApplyCoupon', function(event){
    event.preventDefault();
            var user=$(this).attr("user");
           if(user==1){

           }else{
            alert("Please login to apply Coupon!");
            return false;
           }
           var code=$("#code").val();
           $.ajax({
            type:'post',
            data:{code:code,_token: '{{csrf_token()}}'},
            url:'/apply-coupon',
            success:function(resp){
                // alert(resp.couponAmount);
                if(resp.message!=""){
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
                if(resp.couponAmount>0){
                    $(".couponAmount").text("" +resp.couponAmount);
                }else{
                    $(".couponAmount").text("0");
                }
                if(resp.grand_total>0){
                    $(".grand_total").text(""+resp.grand_total);
                }
            },error:function(){
                alert("Error");
            }

           })
        });
     });

</script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.updateCartItem', function() {
            if ($(this).hasClass('plus-a')) {
                var quantity = $(this).data('qty');
                new_qty = parseInt(quantity) + 1;
            }
            if ($(this).hasClass('minus-a')) {
                var quantity = $(this).data('qty');
                if (quantity <= 1) {
                    Swal.fire({
                      icon: 'error'
                    , title: 'Oops...'
                    , text: 'Item quantity must be 1 or greater!'
                });

                    return false;
                }
                new_qty = parseInt(quantity) - 1;
                // alert(new_qty);
            }
            var cartid = $(this).data('cartid');
            // alert(cartid);
            $.ajax({
                data: {
                    cartid: cartid
                    , qty: new_qty
                    , _token: '{{csrf_token()}}'
                }
                , url: '/cart/update/'
                , type: 'post'
                , success: function(resp) {
                    $(".totalCartItems").html(resp.totalCartItems);

                    if (resp.status == false) {
                        alert(resp.message);
                    }
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);

                }
                , error: function() {
                    alert("Error");
                }
            })
        });


        $(document).on('click', '.deleteCarts', function(e) {
            e.preventDefault();

            var cartid = $(this).data('cartid');

            // Display SweetAlert2 confirmation dialog
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success"
                    , cancelButton: "btn btn-danger"
                }
                , buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?"
                , text: "You won't be able to revert this!"
                , icon: "warning"
                , showCancelButton: true
                , confirmButtonText: "Yes, delete it!"
                , cancelButtonText: "No, cancel!"
                , reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion
                    $.ajax({
                        data: {
                            cartid: cartid
                            , _token: '{{csrf_token()}}'
                        }
                        , url: 'cart/delete'
                        , type: 'post'
                        , success: function(resp) {
                            $(".totalCartItems").html(resp.totalCartItems);
                            $("#appendCartItems").html(resp.view);
                            $("#appendHeaderCartItems").html(resp.headerview);

                            // Display success message
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!"
                                , text: "Your product in cart has been deleted."
                                , icon: "success"
                            });
                        }
                        , error: function() {
                            // Display SweetAlert2 error message for Ajax error
                            swalWithBootstrapButtons.fire({
                                icon: 'error'
                                , title: 'Oops...'
                                , text: 'Error occurred while processing the request.'
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled"
                        , text: "Your imaginary file is safe :)"
                        , icon: "error"
                    });
                }
            });
        });
        //Apply Coupon
    });

</script>
@endsection
