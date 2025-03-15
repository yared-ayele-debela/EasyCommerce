<?php use App\Models\Product; ?>

@extends('fontend.layout.layout')
@section('content')

<div class="page-wishlist u-s-p-t-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" id="AppendWishlistItems">
                @include('NewFrontEndPage.products.wishlist_items')
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
       $(document).ready(function() {
        $(document).on('click', '.wishlistItemDelete', function(e) {
          e.preventDefault();
            var wishlistid = $(this).data('wishlistid');

            // Display SweetAlert2 confirmation dialog
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion
                    $.ajax({
                        data: { wishlistid: wishlistid, _token: '{{csrf_token()}}' },
                        url: '/delete-wishlist-item',
                        type: 'post',
                        success: function(resp) {
                            $("#AppendWishlistItems").html(resp.view);
                            $('.totalWishlistItems').html(resp.totalWishlistItems);
                        },
                        error: function() {
                            // Display SweetAlert2 error message for Ajax error
                            swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Error occurred while processing the request.'
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Display cancelled message
                    swalWithBootstrapButtons.fire({
                        title: 'Cancelled',
                        text: 'Your wishlist item is safe :)',
                        icon: 'error'
                    });
                }
            });
        });
    });
    </script>
@endsection

