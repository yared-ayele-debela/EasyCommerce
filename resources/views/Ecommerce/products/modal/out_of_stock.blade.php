<!-- Modal -->
<div class="modal fade" id="notifyVendorModal" tabindex="-1" aria-labelledby="notifyVendorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('product.request-stock', $product->id) }}">
            @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="notifyVendorLabel">Notify Vendor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="product_id" id="notify-product-id">
            <p class="mb-2">We'll let the vendor know you're interested in this product.</p>
            <div class="mb-3">
              <label for="message" class="form-label">Optional Message</label>
              <textarea class="form-control" name="message" rows="3" placeholder="Any specific request..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Send Notification</button>
          </div>
        </div>
      </form>
    </div>
  </div>
