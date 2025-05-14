@if(count($blogs) > 0)
    @foreach ($blogs as $blog)
        <div class="offer-card mb-4 shadow-sm">
            <img src="{{ $blog['image'] }}" class="card-img-top" alt="{{ $blog->title }}">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ url('blogs/details/' . encrypt($blog->id)) }}" class="text-decoration-none text-dark">{{ $blog->title }}</a>
                </h5>
                <div class="mb-2 text-muted">
                    <small>By {{ $blog->added_by }} | {{ $blog->created_at->format('M d, Y') }}</small>
                </div>
                <p class="card-text">
                    {{ Str::words(strip_tags($blog->description), 40, '...') }}
                </p>
                <a href="{{ url('blogs/details/' . encrypt($blog->id)) }}" class="btn btn-outline-primary btn-sm">Read More</a>
            </div>
        </div>
    @endforeach
@else
    <p>No blog posts found.</p>
@endif
