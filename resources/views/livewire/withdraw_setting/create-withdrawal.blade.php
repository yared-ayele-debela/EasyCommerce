<div wire:ignore.self class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $withdrawal_id ? 'Edit Minimum Withdrawal Amount' : 'Create Minimum Withdrawal Amount' }}</h5>
                <button type="button" class="close btn"  wire:click="closeCreateModal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" wire:model="amount">
                        @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="closeCreateModal" class="btn btn-secondary">Close</button>
                <button type="button" wire:click="store" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
