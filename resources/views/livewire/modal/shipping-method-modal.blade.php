<div wire:ignore.self class="modal fade" id="SubscriptionModal" tabindex="-1" aria-labelledby="SubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="SubscriptionModalLabel">Create Shipping Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
            </div>
            <form wire:submit.prevent="store">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="base_cost" class="form-label">base_cost:</label>
                        <input type="number" id="base_cost" wire:model="base_cost" class="form-control">
                        @error('base_cost') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="per_kg_rate" class="form-label">Per KG Rate:</label>
                        <input type="number" id="per_kg_rate" wire:model="per_kg_rate" class="form-control">
                        @error('per_kg_rate')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label><br>
                        <textarea wire:model="description" class="form-control" id="" cols="30" rows="5"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="zones">Zones
                            </label>
                            <select wire:model='zones' class="form-control" multiple>
                                @foreach ($allZones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Zones</label>
                            <div class="row">
                                @foreach($allZones as $zone)
                                <div class="col-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $zone->name }}</h4>
                                            <p class="card-text">
                                                <input min="1" wire:model.lazy="prices.{{ $zone->id }}" type="number" class="form-control" placeholder="Price">
                                            </p>
                                        </div>
                                    </div>
                                    {{-- <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ $zone->name }}</span>
                                </div>
                                <input wire:model.lazy="prices.{{ $zone->id }}" type="number" class="form-control" placeholder="Price">
                            </div> --}}
                        </div>

                        @endforeach

                    </div>
                </div>
        </div>

    </div>
    <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    </form>
</div>
</div>
</div>


<!-- Update Modal -->
<div wire:ignore.self class="modal fade" id="updateSubscriptionModal" tabindex="-1" aria-labelledby="updateSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="updateSubscriptionModalLabel">Edit Shipping Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="base_cost" class="form-label">base_cost:</label>
                        <input type="number" id="base_cost" wire:model="base_cost" class="form-control">
                        @error('base_cost') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="per_kg_rate" class="form-label">Per KG Rate:</label>
                        <input type="number" id="per_kg_rate" wire:model="per_kg_rate" class="form-control">
                        @error('per_kg_rate')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label><br>
                        <textarea wire:model="description" class="form-control" id="description" cols="30" rows="5"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="zones">Zones
                            </label>
                            <select wire:model='zones' class="form-control" multiple>
                                @foreach ($allZones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Zones</label>
                            <div class="row">
                                @foreach($allZones as $zone)
                                <div class="col-3">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $zone->name }}</h4>
                                            <p class="card-text">
                                                <input min="1" wire:model.lazy="prices.{{ $zone->id }}" type="number" class="form-control" placeholder="Price">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div wire:ignore.self class="modal fade" id="deleteSubscriptionModal" tabindex="-1" aria-labelledby="deleteSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg rounded">
            <form wire:submit.prevent="destroyShippingMethod">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Are you sure you want to delete this shipping method?</h5>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes! Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

