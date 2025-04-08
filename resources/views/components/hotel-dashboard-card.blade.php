@props(['title', 'value', 'icon', 'color'])
<div class="col-md-4 col-lg-3">
    <div class="card border-0 shadow rounded-4 p-3 bg-light">
        <div class="d-flex align-items-center">
            <div class="me-3 text-white bg-{{ $color }} p-3 rounded-3 shadow">
                <i class="bi {{ $icon }} fs-4"></i>
            </div>
            <div>
                <h6 class="mb-0">{{ $title }}</h6>
                <h4 class="fw-bold mb-0">{{ $value }}</h4>
            </div>
        </div>
    </div>
</div>
