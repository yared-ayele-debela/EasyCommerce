<div wire:ignore.self class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Withdrawal</h5>
                <button type="button" class="close btn" wire:click="closeDeleteModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this withdrawal?</p>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="closeDeleteModal" class="btn btn-secondary">Cancel</button>
                <button type="button" wire:click="delete" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
