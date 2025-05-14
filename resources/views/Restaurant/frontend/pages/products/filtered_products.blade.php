@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="header">
            <button class="btn btn-link text-dark" onclick="history.back()">
                <i class="bi bi-arrow-left"></i>
             </button>
            <h5 class="my-4 text-dark text-center">{{ ucfirst(str_replace('_', ' ', $filter)) }} Products</h5>
        </div>
        @forelse ($products as $product)
        <div class="col-md-2 col-6 my-2">
            <x-restaurant.product-card :product="$product" />
        </div>
        @empty
        <p class="text-center text-muted">No products found.</p>
        @endforelse
    </div>
</div>
@endsection

