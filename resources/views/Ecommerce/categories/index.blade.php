@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid pb-5 pb-md-2">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Categories</h5>
    </div>
    <div class="row text-center mt-3">
        <div class="row">
            @foreach ($categories as $category)
            <div class="col-md-2 col-6 mb-2">
                <x-category-card :category="$category" />
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

