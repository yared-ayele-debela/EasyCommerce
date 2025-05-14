@props(['brand'])

@php
    $image = !empty($brand['image']) ? $brand['image'] : asset('restaurant_frontend/default-image.png');
@endphp

<div class="item mb-2">
    <div class="brand-item text-center">
        <a href="{{ url('ecommerce/brand/' . encrypt($brand['id'])) }}" class="text-decoration-none">
            <img src="{{ $image }}"
                 class="p-2 shadow"
                 style="border:4px solid #ccc; max-height: 100px;"
                 alt="{{ $brand['name'] }}"
                 loading="lazy">
            <p class="text-dark mt-2">{{ $brand['name'] }}</p>
        </a>
    </div>
</div>
