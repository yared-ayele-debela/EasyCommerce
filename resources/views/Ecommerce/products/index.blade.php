@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $name }}</h5>
    </div>
    <div class="row g-4">
        @foreach ($products as $product)
                <x-normal-product-card :product="$product" />
        @endforeach
    </div>
</div>
@endsection

