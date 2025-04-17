@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
         </button>
        <h5 class="my-4 text-dark text-center">Categories</h5>
    </div>
    <div class="row text-center mt-3">
            @foreach ($categories as $category)
            <div class="col-md-1 mb-2">
                <div class="category-item">
                    <a href="{{ url('category/'.$category['id']) }}">
                        <img src="{{ asset('storage/category/' . $category['image']) }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="{{ $category->name }}">
                        <p class="text-dark">{{ $category->name }}</p>
                    </a>
                </div>
            </div>
            @endforeach
    </div>
</div>
@endsection
