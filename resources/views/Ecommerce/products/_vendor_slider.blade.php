@foreach ($vendors as $vendor)
    <x-vendor-card :vendor="$vendor" :review-count="$vendor->ratings_count ?? 0" />
@endforeach
