<div class="item mb-2">
    <div class="category-item">
        <a href="{{ url('hotel/categories/' . $category->id) }}">
            <img src="{{ asset('storage/' . ($category->image ?? 'restaurant_frontend/default-image.png')) }}"
                 class="p-2 shadow restaurant-category-image"
                 style="border:4px solid rgb(162, 159, 159);"
                 alt="{{ $category->name ?? '' }}"
                 loading="lazy">
            <p class="text-dark text-center">{{ $category->name ?? '' }}</p>
        </a>
    </div>
</div>
