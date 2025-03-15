<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    @include('livewire.modal.price-plan-modal')
    <div class="col-lg-12 mt-3">
        <div class="card shadow-sm">
            <div class="card-header mt-3">
                @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <button type="button" class="btn btn-primary float-start" data-bs-toggle="modal" data-bs-target="#SubscriptionModal">
                    Add Subscription
                </button>
            </div>
            <div class="card-body">
                <table id="example" class="table datatable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Duration</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pricePlans as $pricePlan)
                        <tr>
                            <td class="px-4 py-2">{{ $pricePlan->name }}</td>
                            <td class="px-4 py-2">{{ $pricePlan->description }}</td>
                            <td class="px-4 py-2">{{ $pricePlan->price }}</td>

                            <td class="px-4 py-2">{{ $pricePlan->duration }}</td>
                            <td class="px-4 py-2">
                                {{-- @if ($user && $user->hasPermissionByRole('edit_subscription')) --}}
                                <button wire:click="update_status({{ $pricePlan['id'] }})" class="btn btn-sm {{ $pricePlan['status'] ? 'btn-success' : 'btn-danger' }}">
                                    {{ $pricePlan['status'] ? 'Active' : 'Inactive' }}
                                </button>
                                {{-- @endif --}}
                            </td>
                            <td class="px-4 py-2">
                                {{-- @if ($user && $user->hasPermissionByRole('edit_subscription')) --}}
                                <button type="button"  data-bs-toggle="modal" data-bs-target="#updateSubscriptionModal" wire:click="edit({{$pricePlan['id']}})" class="btn btn-primary btn-sm">
                                    <i class="ri-ball-pen-fill"></i>
                                </button>
                                {{-- @endif --}}
                                {{-- @if ($user && $user->hasPermissionByRole('delete_subscription')) --}}
                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteSubscriptionModal" wire:click="deletePricePlan({{$pricePlan['id']}})"  class="btn btn-danger btn-sm">
                                    <i class="ri-delete-bin-6-fill"></i>
                                </button>
                                {{-- @endif --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class=" pagination-sm">
                </div>
            </div>
        </div>
    </div>
</div>
