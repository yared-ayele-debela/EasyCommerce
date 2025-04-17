@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">{{ $hotel->name }}</h5>
    </div>
    <div class="row d-flex justify-content-center align-items-center">
        @forelse($hotel->photos as $index => $photo)
            @php
                // Example layout rules
                $colClass = match($index) {
                    0, 1 => 'col-md-6',        // First two images larger
                    2, 3, 4 => 'col-md-4',     // Next three medium
                    default => 'col-md-6',     // Rest normal
                };
            @endphp
            <div class="{{ $colClass }} mb-4">
                <img
                    loading="lazy"
                    src="{{ asset('storage/' . $photo->photo_url) }}"
                    alt="{{ $hotel->name }}"
                    class="p-1 border border-2 card-img-top custom-border-radius w-100"
                >
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted
                text-center
                my-5">
                    No images available for this hotel
                </p>
            </div>
        @endforelse
    </div>

</div>
@endsection
