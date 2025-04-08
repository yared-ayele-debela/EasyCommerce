@props(['title', 'count', 'icon', 'bg', 'description'])
<div class="col-md-3 mb-4">
    <div class="card shadow h-100">
        <div class="card-body">
            <h5 class="card-title">{{ $title }}</h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-{{ $bg }} text-white" style="width: 50px; height: 50px;">
                    <i class="bi {{ $icon }}" style="font-size: 26px;"></i>
                </div>
                <div class="ps-3">
                    <h6 class="mb-0" style="font-size: 26px;"><b>{{ $count }}</b></h6>
                    <span class="text-muted small fw-bold">{{ $description }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
