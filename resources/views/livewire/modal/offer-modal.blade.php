<!-- Insert Modal -->
<div wire:ignore.self class="modal fade" id="SubscriptionModal" tabindex="-1" aria-labelledby="SubscriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="SubscriptionModalLabel">Update Offer Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                ></button>
            </div>
            <form wire:submit.prevent="update_status">
                <div class="modal-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        Status updated successfully!
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select wire:model="status"  class="form-control" name="status" id="status">
                          <option @if($offer->status=="pending") selected @endif value="pending">Pending</option>
                          <option  @if($offer->status=="approved") selected @endif value="approved">Approved</option>
                          <option  @if($offer->status=="declined") selected @endif value="declined">Declined</option>
                        </select>
                      </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
