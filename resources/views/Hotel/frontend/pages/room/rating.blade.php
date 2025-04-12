<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <form id="ratingForm">
                @csrf
                <div class="modal-body text-left p-4">
                    <p class="fs-5 text-muted mb-1">How was your experience?</p>
                    <div class="rating mb-3 text-left">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>
                    <p class="small text-muted">Tap a star to rate.</p>
                    <div class="form-group">
                        <label for="review" class="form-label text-dark">Write a review:</label>
                        <textarea class="form-control" id="review" name="review" rows="3" placeholder="Write your comment" required></textarea>
                    </div>
                    <input type="hidden" name="room_id" id="room_id" value="{{ $room->id }}" required>
                    <input type="hidden" name="hotel_id" id="hotel_id" value="{{ $room->hotel->id }}" required>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" id="submitRating">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById("ratingForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch("{{ route('hotel.room.rate') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                showAlert('success',"Rating submitted successfully!");
                $('#ratingModal').modal('hide'); // Close the modal
                $('#ratingForm')[0].reset(); // Reset the form fields
                // Optionally, you can refresh the page or update the UI to show the new rating
            } else {
                showAlert('info',"Error: " + data.message);
            }
        })
        .catch(error => {
            showAlert('info',"An error occurred. Please try again later.");
        });
    });
    </script>
