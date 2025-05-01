<div>
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">All offered products</li>
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
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Product Code</th>
                            <th class="px-4 py-2">Image</th>
                            <th class="px-4 py-2">Product Price</th>
                            <th class="px-4 py-2">Product Discount</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-2">{{ $product->id }}</td>
                            <td class="px-4 py-2">{{ $product->product_name }}</td>
                            <td class="px-4 py-2">{{ $product->product_code }}</td>
                            <td class="px-4 py-2">
                                <img src="{{ $product['product_image'] }}" alt="Product Image" style="max-width: 50px;">
                            </td>
                            <td class="px-4 py-2">{{ $product->product_price }}</td>
                            <td class="px-4 py-2">{{ $product->product_discount }}</td>
                            <td class="px-4 py-2">
                                {{-- @if ($user && $user->hasPermissionByRole('edit_subscription')) --}}
                                <button wire:click="redirectToOffers({{ $product->id }})" class="btn btn-primary btn-sm">View Offers</button>
                                {{-- @endif --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
