@foreach ($categories as $category)
    <x-category-card :category="$category" />
@endforeach
