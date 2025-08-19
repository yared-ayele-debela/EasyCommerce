@foreach ($allvendors as $vendor)
<div class="col-md-3 mb-2 h-100 d-inline-block">
    <x-vendor-card :vendor="$vendor" />
</div>
@endforeach
