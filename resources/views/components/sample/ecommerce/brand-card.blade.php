<div class="brand-item ecom-brand text-center">
        <a href="{{ url('ecommerce/brand/' . encrypt($brand['id'])) }}" class="text-decoration-none">
            <img src="{{ asset('storage/' . $brand['image']) }}"
                 class="p-2 shadow"
                 style="border:4px solid #ccc; max-height: 100px; min-height: 100px; min-width: 100px; max-width: 100px;"
                 alt="{{ $brand['name'] }}"
                 loading="lazy">
            <p class="text-dark mt-2">{{ $brand['name'] }}</p>
        </a>
    </div>
