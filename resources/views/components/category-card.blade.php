@props(['category'])

<div class="item mb-2">
    <div class="category-item">
        <a href="{{ url('ecommerce/category/' . encrypt($category->id)) }}">
            <img src="{{ asset('storage/' . $category->image) }}"
                 class="p-2 shadow restaurant-category-image"
                 style="border:4px solid #bcd4ca;"
                 alt="{{ $category->name }}"
                 loading="lazy">
            <p class="text-dark text-center">{{ $category->name }}</p>
        </a>
    </div>
</div>
