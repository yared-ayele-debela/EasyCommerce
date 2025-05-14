@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
        <i class="bi bi-arrow-left mr-2"></i> &nbsp;
        <span>Back</span>
    </button>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Out of stock products</li>
    </ol>
</nav>

<section class="section">
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
            <h4 class="text-dark"> All Out of Stock Products</h4>
        </div>
        <div class="card-body mt-2">
            <table class="table mt-2">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Product Code</th>
                        <th scope="col">Image</th>
                        <th scope="col">Category</th>
                        <th scope="col">Group</th>
                        <th scope="col">Featured</th>
                        <th scope="col">Added by</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outOfStockProducts as $k => $product)
                    <tr>
                        <td>{{ $product['id'] }}</td>
                        <td>
                            {{ $product['product_name']}}
                            <span class="bg-secondary position-absolute badge bg-danger m-2" style="z-index: 1100;">Out of Stock</span>
                        </td>
                        <td>{{ $product['product_code']}}</td>
                        <td>
                            @if (!empty($product['product_image']))
                            <img src="{{ $product['product_image'] }}" alt="Product Image" style="max-width: 50px;">
                            @else
                            <img class=" rounded-sm border-0" src="{{ asset('/storage/products/no-image.png') }}" style="width: 50px; box-shadow:1px 1px 2px 2px rgb(218, 215, 215); border-radius:3px; border:none; height:50px" alt="">
                            @endif
                        </td>
                        <td>{{ $product['category']['name']}}</td>
                        <td>{{ $product['group']['name']}}</td>
                        <td>
                            <button wire:click="is_featured({{ $product['id'] }})" class="btn btn-sm text-white {{ $product['is_featured']=="Yes" ? 'btn-success' : 'btn-warning' }}">
                                {{ $product['is_featured']=="Yes" ? 'Yes' : 'No' }}
                            </button>
                        </td>
                        <td>
                            @if($product['admin_type']=='vendor')
                            <a href="{{ url('admin/view_vendor_details/'.$product['admin_id']) }}" class=" underline">{{ ucfirst($product['admin_type']) }}</a>
                            @else
                            {{ ucfirst($product['admin_type']) }}
                            @endif
                        </td>
                        @if ($user && $user->hasPermissionByRole('update product status'))

                        <td>
                            <i class="cont">
                                <button id="popoverButton" wire:click="toggleStatus({{ $product['id'] }})" class="btn btn-sm {{ $product['status'] ? 'btn-success' : 'btn-danger' }}">
                                    {{ $product['status'] ? 'Active' : 'Inactive' }}
                                </button>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p><strong>Comment</strong>: {{ $product['status_comment'] }}</p>
                                    </div>
                                </div>
                            </i>
                        </td>
                        @else

                        <td>
                            <i class="cont">
                                <button id="popoverButton" class="btn btn-sm {{ $product['status'] ? 'btn-success' : 'btn-danger' }}">
                                    {{ $product['status'] ? 'Active' : 'Inactive' }}
                                </button>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p><strong>Comment</strong>: {{ $product['status_comment'] }}</p>
                                    </div>
                                </div>
                            </i>
                        </td>
                        @endif
                        <td>
                            @if ($user && $user->hasPermissionByRole('add_attribute'))
                            <i class="cont">
                                <a id="popoverButton" href="{{ url('admin/products/add_attribute/'.$product['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm"> <i class="bx bx-add-to-queue"></i></a>
                                <div id="popover" class="popover">
                                    <div class="popover-content">
                                        <p>Add Produt To Stock</p>
                                    </div>
                                </div>
                            </i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $outOfStockProducts->links() }}
        </div>
    </div>
</section>
@endsection

