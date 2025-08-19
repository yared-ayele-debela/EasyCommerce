@extends('all_frontend_layouts.layouts')
@section('content')
<div class="container-fluid">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">All Vendors</h5>
    </div>
    <div class="row g-4" id="vendor-list">
        @foreach ($allvendors as $vendor)
        <div class="col-md-3 mb-2 h-100">
            <x-vendor-card :vendor="$vendor" />
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12 text-center my-3">
            @if ($allvendors->hasMorePages())
            <button id="load-more-vendors" class="btn btn-outline-primary">Load More</button>
            @endif
        </div>
    </div>
</div>

<script>
let nextPage = {{ $allvendors->currentPage() + 1 }};
let lastPage = {{ $allvendors->lastPage() }};
let loading = false;

document.getElementById('load-more-vendors')?.addEventListener('click', function() {
    if (loading) return;
    loading = true;
    this.textContent = 'Loading...';
    fetch("{{ route('ecommerce.vendors.paginate') }}?page=" + nextPage)
        .then(res => res.json())
        .then(res => {
            res.data.forEach(function(vendorHtml) {
                let div = document.createElement('div');
                div.className = "col-md-3 mb-2 h-100";
                div.innerHTML = vendorHtml;
                document.getElementById('vendor-list').appendChild(div);
            });
            nextPage++;
            if (nextPage > lastPage || !res.has_more) {
                document.getElementById('load-more-vendors').style.display = 'none';
            } else {
                document.getElementById('load-more-vendors').textContent = 'Load More';
            }
            loading = false;
        })
        .catch(function() {
            document.getElementById('load-more-vendors').textContent = 'Load More';
            loading = false;
        });
});

// Optional: auto-load on scroll near bottom
window.addEventListener('scroll', function() {
    let btn = document.getElementById('load-more-vendors');
    if (!btn || loading || btn.style.display === 'none') return;
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 300) {
        btn.click();
    }
});
</script>
@endsection
