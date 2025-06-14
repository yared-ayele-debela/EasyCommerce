<div class="p-3 bg-light rounded">
    <h5 class="mb-3">Filters</h5>

    @foreach (['Group' => $groups, 'Category' => $categories, 'Brand' => $brands, 'Vendor' => $vendors] as $label => $items)
        <div class="mb-3">
            <label class="form-label fw-bold">{{ $label }}</label>
            @foreach ($items as $item)
                <div class="form-check">
                    <input class="form-check-input filter-{{ strtolower($label) }}" type="checkbox" value="{{ $item->id }}" id="{{ strtolower($label) }}_{{ $item->id }}">
                    <label class="form-check-label" for="{{ strtolower($label) }}_{{ $item->id }}">
                        {{ $item->name }}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach

    <!-- Discount and Price -->
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="discountOnly">
        <label class="form-check-label">Discounted Only</label>
    </div>

    <div class="mb-3">
        <label class="form-label">Price Range</label>
        <div class="d-flex gap-2">
            <input type="number" id="minPrice" class="form-control w-50" placeholder="Min">
            <input type="number" id="maxPrice" class="form-control w-50" placeholder="Max">
        </div>
    </div>
</div>
