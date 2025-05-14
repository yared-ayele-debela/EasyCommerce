@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid pb-5 pb-md-2">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $category->name }}</h5>
    </div>
    <div class="row g-4">
        @if(!$products->isEmpty())
        @foreach ($products as $product)
            <x-normal-product-card :product="$product" />
        @endforeach
        @else
        <div class="col-md-12 text-center mt-5">
            <img src="{{ asset('no-product-found..png') }}" alt="No Products Found" class="img-fluid mb-3" style="width: 300px; height: 200px;">
        </div>
        @endif
    </div>
    <div class="my-4">
        {{ $products->links() }}
    </div>
</div>
@endsection

