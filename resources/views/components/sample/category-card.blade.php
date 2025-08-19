<div class="ecom-category">
    @if($category->hasImage)
        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}">
    @else
        <img src="{{ asset('images/default-category.jpg') }}" alt="{{ $category->name }}">
    @endif
    <span>{{ $category->name }}</span>
</div>

