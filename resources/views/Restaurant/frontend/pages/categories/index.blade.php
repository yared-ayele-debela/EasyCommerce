@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container-fluid">
    <h3 class="my-4 text-dark text-center">All Categories</h4>
    <div class="row g-3 my-3">
        @foreach ($categories as $category)
        <div class="col-md-2 col-6">
            <div class="category-item">
                <a href="{{ url('restaurant/category/'.$category->id) }}">
                    <img src="{{ asset('storage/' . $category->image) }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="American">
                    <p class="text-dark">{{ $category->name }}</p>
                </a>
            </div>
        </div>
        @endforeach
        <div class="col-12">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
