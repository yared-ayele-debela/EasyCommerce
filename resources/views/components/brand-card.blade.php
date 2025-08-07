@props(['brand'])


<div class="item mb-2">
    <div class="brand-item text-center">
        <a href="{{ url('ecommerce/brand/' . encrypt($brand['id'])) }}" class="text-decoration-none">
            <img src="{{ asset('storage/' . $brand['image']) }}"
                 class="p-2 shadow"
                 style="border:4px solid #ccc; max-height: 120px; min-height: 120px; min-width: 120px; max-width: 120px;"
                 alt="{{ $brand['name'] }}"
                 loading="lazy">
            <p class="text-dark mt-2">{{ $brand['name'] }}</p>
        </a>
    </div>
</div>
