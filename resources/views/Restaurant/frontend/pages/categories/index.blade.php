@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">All Categories</h5>
    </div>
    <div class="row g-3 my-3">
        @foreach ($categories as $category)
        <div class="col-md-2 col-6">
          <x-restaurant.category-card :category="$category" />
        </div>
        @endforeach
        <div class="col-12">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection

