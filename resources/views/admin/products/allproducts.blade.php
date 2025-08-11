@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

    <div class="pagetitle bg-light shadow-sm">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">All Products</li>
            </ol>
        </nav>
    </div>
    <section class="section" >
        <div class="card">
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
                @if ($user && $user->hasPermissionByRole('add_product'))
                <a href="{{ url('admin/products/add-product') }}" class="btn btn-primary"> Add Product</a>
                @endif
            </div>
            <div class="card-body mt-2">
                <table class="table mt-2" id="example">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Image</th>
                            <th scope="col">Category</th>
                            <th scope="col">Group</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Added by</th>
                            <th scope="col">Status</th>
                            <th scope="col">Is Seasonal</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $k => $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['product_name']}}
                                   @php
                                    $outOfStock = $product['quantity'] <= 0;
                                    @endphp
                                    @if($outOfStock)
                                    <span class="bg-secondary position-absolute badge bg-danger m-2" style="z-index: 1100;">Out of Stock</span>
                                    @endif

                            </td>
                            <td>{{ $product['product_code']}}</td>
                            <td>{{ $product['product_price']}} ETB |  Qty: <span class="p-1 rounded rounded-2 text-white bg-secondary">{{ $product['quantity'] }}</span></td>
                            <td>{{ $product['product_discount']}} % </td>
                            <td>
                                @if (!empty($product['product_image']))
                                <img src="{{ asset('storage/' . $product['product_image']) }}" alt="Product Image" style="max-width: 50px;">
                                @else
                                <img class=" rounded-sm border-0" src="{{ asset('/storage/products/no-image.png') }}" style="width: 50px; box-shadow:1px 1px 2px 2px rgb(218, 215, 215); border-radius:3px; border:none; height:50px" alt="">
                                @endif
                            </td>
                            <td>{{ $product['category']['name']}}</td>
                            <td>{{ $product['group']['name']}}</td>
                            <td>
                                <form method="POST" action="{{ route('product.toggleFeatured', $product->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm  {{ $product->is_featured === 'Yes' ? 'btn-success' : 'btn-danger' }}" >
                                    {{ $product->is_featured === 'Yes' ? 'Featured' : 'Not Featured' }}
                                </button>
                            </form>
                            </td>
                            <td>
                                @if($product['admin_type']=='vendor')
                                <a href="{{ url('admin/view_vendor_details/'.$product['admin_id']) }}" class=" underline">{{ ucfirst($product['admin_type']) }}</a>
                                @else
                                {{ ucfirst($product['admin_type']) }}
                                @endif
                            </td>

                            <td>
                                <i class="cont">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn  {{ $product->status ? 'btn-success' : 'btn-danger' }} btn-sm" data-toggle="modal" data-target="#modelId{{ $product['id'] }}">
                                       {{ $product->status ? 'Active' : 'Inactive' }}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modelId{{ $product['id'] }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Status</h5>
                                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                   <form method="POST" action="{{ route('product.updateStatus', $product->id) }}">
                                                        @csrf
                                                        <input type="text" name="status_comment" class="form-control" placeholder="Comment" value="{{ old('status_comment', $product->status_comment) }}">
                                                        <button type="submit"  class="btn btn-primary mt-3">Update Status</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p><strong>Comment</strong>: {{ $product['status_comment'] }}</p>
                                    </div>
                                </div>
                                </i>
                            </td>


                            <td>
                                <div class="d-flex">
                                @if ($user && $user->hasPermissionByRole('view seasonal'))
                                 @if ($user && $user->hasPermissionByRole('add seasonal'))
                                    <form method="POST" action="{{ route('product.toggleSeasonal', $product->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm  {{ $product->is_seasonal ? 'btn-success' : 'btn-danger' }}">
                                            {{ $product->is_seasonal ? 'Seasonal' : 'Not Seasonal' }}
                                        </button>
                                    </form>
                                    &nbsp;
                                    @if($product['is_seasonal']=="1")
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal">+</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Select Season</h5>
                                                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Select Season when product does'nt available</h5>
                                                    <form action="{{ route('add_season') }}" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                            <div class="col mb-2 gird gird-row">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        @foreach($months->chunk(ceil($months->count() / 2))[0] as $month)
                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="season_end_months[]" value="{{ $month->id }}" class="form-check-input" {{ collect($product['months'])->pluck('id')->contains($month->id) ? 'checked' : '' }}>
                                                                            <label class="form-check-label">{{ $month->name }}</label>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        @foreach($months->chunk(ceil($months->count() / 2))[1] as $month)
                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="season_end_months[]" value="{{ $month->id }}" class="form-check-input" {{ collect($product['months'])->pluck('id')->contains($month->id) ? 'checked' : '' }}>
                                                                            <label class="form-check-label">{{ $month->name }}</label>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                     <button class="btn btn-sm {{ $product['is_seasonal'] ? 'btn-success' : 'btn-danger' }}">
                                        {{ $product['is_seasonal'] ? 'Seasonal' : 'Not Seasonal' }}
                                    </button>
                                    @endif
                                @endif
                                </div>
                            </td>
                            <td>
                                @if ($user && $user->hasPermissionByRole('edit_product'))
                                <i class="cont">
                                    <a id="popoverButton" href="{{ url('admin/edit/product/'.$product['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm"> <i class="ri-ball-pen-fill"></i></a>
                                    <div id="popover" class="popover">
                                        <div class="popover-content">
                                            <p>Update Produt</p>
                                        </div>
                                    </div>
                                </i>
                                @endif

                                @if ($user && $user->hasPermissionByRole('add_attribute'))
                                <i class="cont">
                                 <a id="popoverButton" href="{{ url('admin/products/add_attribute/'.$product['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm"> <i class="bx bx-add-to-queue"></i></a>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p>Add Produt Size</p>
                                    </div>
                                </div>
                                </i>
                                @endif
                                @if ($user && $user->hasPermissionByRole('add_image_to_product'))
                                <i class="cont">
                                <a id="popoverButton" href="{{ url('admin/products/images/'.$product['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm mt-1"> <i class="ri-camera-fill "></i></a>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p>Add Produt Image</p>
                                    </div>
                                </div>
                                </i>
                                @endif
                                @if ($user && $user->hasPermissionByRole('delete_product'))
                                <i class="cont">
                                <form method="POST" action="{{ route('product.destroy', $product->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this product?')"><i class="bi bi-trash-fill"></i></button>
                                </form>

                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p>Delete Product</p>
                                    </div>
                                </div>
                                </i>
                                @endif
                                <i class="cont">
                                <button id="popoverButton"  data-bs-toggle="modal" data-bs-target="#addDiscountModal" wire:click="create_discount_package({{ $product['id'] }})" class="btn btn-sm btn-secondary cont">
                                    <i class="ri-price-tag-line"></i>
                                </button>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p>Add discount package</p>
                                    </div>
                                </div>
                                </i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
        {{-- @if ($isModalOpen) --}}
        {{-- <div class="modal fade show d-block" style="background-color: rgba(0, 0, 0, 0.5);" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status</h5>
                        <button type="button" class="close btn" wire:click="closeModal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateStatus">
                            <div class="form-group mb-2">
                                <label for="comment">Comment:</label>
                                <textarea id="comment" class="form-control" wire:model="status_comment" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    {{-- @endif --}}

    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <form wire:submit.prevent="destroyProduct" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="$set('productId', null)"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>


    </section>


@endsection

