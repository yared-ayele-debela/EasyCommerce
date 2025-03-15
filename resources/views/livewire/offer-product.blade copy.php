<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">All Shipping Zones</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card shadow-sm">
            <div class="card-header">
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
                    List of offer products
                </button>
            </div>
            <div class="card-body m-2">
                <table id="example" class="table mt-2">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Product</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offer_products as $offer)
                        <tr>
                            <td class="px-4 py-2">{{ $offer->id }}</td>
                            <td class="px-4 py-2">{{ $offer->user->name }}</td>
                            <td class="px-4 py-2">{{ $offer->product->product_name }}</td>
                            <td class="px-4 py-2">{{ $offer->quantity }}</td>
                            <td class="px-4 py-2">{{ $offer->offer_price }}</td>
                            <td class="px-4 py-2">
                                <button class="btn btn-sm btn-success">
                                    {{ $offer->status }}
                                </button>
                            </td>

                            <td class="px-4 py-2">
                                {{-- @if ($user && $user->hasPermissionByRole('edit_subscription')) --}}
                                <a wire:navigate href="{{ route('offer.detail', ['offerId' => $offer->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-ball-pen-fill"></i>
                                </a>

                                {{-- @endif --}}
                                {{-- @if ($user && $user->hasPermissionByRole('delete_subscription')) --}}
                                <button type="button" data-bs-toggle="modal" data-bs-target="#deleteSubscriptionModal" wire:click="deleteoffer({{$offer['id']}})"  class="btn btn-danger btn-sm">
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
