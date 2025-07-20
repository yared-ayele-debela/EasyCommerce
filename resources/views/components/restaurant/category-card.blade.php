@props(['category'])

@php
    $image = !empty($category->image) ? $category->image : asset('restaurant_frontend/default-image.png');
@endphp
<div class="item mb-2">
    <div class="category-item">
        <a href="{{ url('restaurant/category/' . $category->id) }}">
            <img loading="lazy" src="{{ $image }}" class="p-0 shadow restaurant-category-image" style="border:4px solid #bcd4ca;"  alt="{{ $category->name ?? 'Category' }}">
            <p class="text-dark text-center">{{ $category->name }}</p>
        </a>
    </div>
</div>
