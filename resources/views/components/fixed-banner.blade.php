@if(!empty($image) && filter_var($image, FILTER_VALIDATE_URL))
    <div class="my-3">
        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-block">
            <div class="fix-banner-box rounded-3 overflow-hidden position-relative"
                 style="background: url('{{ $image }}') center center / cover no-repeat; min-height: 200px;">
                <span class="visually-hidden">Promotional Banner</span>
            </div>
        </a>
    </div>
@endif
