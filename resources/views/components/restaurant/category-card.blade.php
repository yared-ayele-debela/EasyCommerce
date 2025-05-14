@props(['category'])

@php
    $image = !empty($category->image) ? $category->image : asset('restaurant_frontend/default-image.png');
@endphp
<div class="item mb-2">
    <div class="category-item">
        <a href="{{ url('restaurant/category/' . $category->id) }}">
            <img loading="lazy" src="{{ $image }}" class="p-2 shadow" style="border:4px solid rgb(162, 159, 159);" alt="{{ $category->name ?? 'Category' }}">
            <p class="text-dark">{{ $category->name }}</p>
        </a>
    </div>
</div>
