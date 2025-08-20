
<div class="ecom-category">
 <a href="{{ url('ecommerce/category/' . encrypt($category->id)) }}" class="text-dark">
    @if($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy">
    @else
        <img src="{{ asset('images/default-category.jpg') }}" alt="{{ $category->name }}" loading="lazy">
    @endif
    <span class="text-center">{{ $category->name }}</span>
    </a>
</div>


