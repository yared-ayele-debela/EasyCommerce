@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">All Vendors</h5>
    </div>
    <div class="row g-4">
        @foreach ($allvendors as $vendor)
        <div class="col-md-3 mb-2 h-100">
            <x-vendor-card :vendor="$vendor" />
        </div>
        @endforeach
        <div class="col-12">
                {{ $allvendors->links() }}
        </div>
    </div>
</div>
@endsection

