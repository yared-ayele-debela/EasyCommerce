@props(['category'])

@php
    $image = !empty($category->image) ? $category->image : asset('restaurant_frontend/default-image.png');
@endphp

<div class="item mb-2">
    <div class="category-item">
        <a href="{{ url('ecommerce/category/' . encrypt($category->id)) }}">
            <img src="{{ $image }}"
                 class="p-2 shadow"
                 style="border:4px solid #bcd4ca; min-width: 140px; min-height: 140px; max-width: 140px; max-height: 140px;" 
                 alt="{{ $category->name }}"
                 loading="lazy">
            <p class="text-dark text-center">{{ $category->name }}</p>
        </a>
    </div>
</div>
