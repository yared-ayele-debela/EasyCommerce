<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="customOrder" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Custom Order
                </h5>
                <div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form name="fast_orders" id="fast_orders" method="POST">
                    @csrf
                <div class="field_wrapper mb-1">
                    <div class="row mb-2">
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control" name="customer_name" placeholder=" Name" id="">
                            <span id="customer_name_error" class="text-danger"></span>

                        </div>
                        <div class="col-md-4 mb-1">
                            <input type="number" class="form-control w-100" name="phone_number" placeholder="Mobile Number" id="">
                            <span id="phone_number_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control mb-2" name="productname[]" placeholder="Product Name">
                            <p id="productname_error" class="text-danger"></p>
                            <input type="text" class="form-control" placeholder="Quantity" name="quantity[]">
                            <span id="quantity_error[]" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-1">
                            <textarea name="description[]" class="form-control" rows="3" placeholder="Product description"></textarea>
                            <p id="description_error[]" class="text-danger"></p>
                        </div>
                        <div class="col-md-3">
                            <textarea name="delivery_address[]" class="form-control" placeholder="Delivery address" rows="3"></textarea>
                            <p id="delivery_address_error[]" class="text-danger"></p>
                        </div>
                    </div>
                    <hr class="my-2">
                </div>
                <div>
                <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm add_button btn">
                    <i class="bi bi-plus"></i>
                </a>
                </div>
                <div class="form-group pt-3">
                    <input type="submit" class="btn btn-primary submitbutton btn pt-2 pb-2 shadow" value="Submit">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    // Form submission
    $('#fast_orders').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        $(".text-danger").text("");
        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('store_custom_order') }}", // Your route here
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.error) {
                    for (var i = 0; i < response.error.length; i++) {
                        var errorMessage = response.error[i];
                        showAlert('info',errorMessage);
                    }
                } else {
                    showAlert('success',"Custom order placed successfully!");
                    $('#fast_orders')[0].reset();
                    $('#customOrder').modal('hide'); // Close the modal

                }
            },
            error: function (xhr, status, error) {
                // Display general error
                showAlert('error',"An error occurred. Please try again.");
            }
        });
    });
});

</script>
<!-- Optional: Place to the bottom of scripts -->
<script>
    const myModal = new bootstrap.Modal(
        document.getElementById("modalId")
        , options
    , );

</script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div><div class="row"><div class="col-md-3"><input type="text" class="form-control mb-2" name="productname[]" placeholder="Product Name" ><input type="text" class="form-control mb-1" placeholder="Quantity" name="quantity[]" > </div> <div class="col-md-4 mb-1"> <textarea name="description[]" class="form-control" cols="20" rows="3" placeholder="Product description" ></textarea></div><div class="col-md-3 mb-1"><textarea name="delivery_address[]" class="form-control mb-1" cols="20" placeholder="Delivery address" rows="3" ></textarea></div><a  href="javascript:void(0);"  class="remove_button ion ion-md-trash"></a></div></div></div>'; //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

</script>
