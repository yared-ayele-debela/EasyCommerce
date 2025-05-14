@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container pb-2">

<div class="header">
    <button class="btn btn-link text-dark" onclick="history.back()">
        <i class="bi bi-arrow-left"></i>
    </button>
    <h5 class="my-4 text-dark text-center">All Blogs</h5>
</div>
    <div class="row g-4">
            <div class="col-lg-9" id="blog-list">
                @include('Ecommerce.blogs.partials.blog-list', ['blogs' => $blogs])
            </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="offer-card px-3 py-4">
                <!-- Search -->
            <div class="mb-4">
                <h5 class="mb-2">Search</h5>
                <form id="blog-search-form" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by title...">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </form>


            </div>

            <!-- Categories -->
            <div class="mb-4">
                <h5 class="mb-3">Categories</h5>
                <ul class="list-group">
                    @foreach ($blog_category as $category)
                        <li class="list-group-item border border-0">
                            <a href="#" class="category-filter text-decoration-none text-dark" data-id="{{ $category->id }}">{{ $category->name }}</a>
                        </li>
                    @endforeach


                </ul>
            </div>

            <!-- Archives -->
            <div class="mb-4">
                <h5 class="mb-3">Archives</h5>
                <ul class="list-group">
                    @foreach($blogCounts as $blogCount)
                        @php
                            $archiveKey = $blogCount->year . '-' . str_pad($blogCount->month, 2, '0', STR_PAD_LEFT);
                        @endphp
                        <li class="list-group-item">
                            <a href="#" class="archive-filter text-decoration-none text-dark" data-archive="{{ $archiveKey }}">
                                {{ \Carbon\Carbon::createFromDate($blogCount->year, $blogCount->month)->format('F Y') }}
                                ({{ $blogCount->post_count }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Recent Posts -->
            <div class="mb-4">
                <h5 class="mb-3">Recent Posts</h5>
                @foreach ($latestFiveBlogs as $blog)
                    <div class="d-flex mb-3">
                        <img src="{{ $blog['image'] }}" class="me-3 rounded" alt="Recent Post" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <a href="{{ url('blogs/details/'.encrypt($blog->id)) }}" class="text-decoration-none d-block text-dark">{{ $blog->title }}</a>
                            <small class="text-muted">{{ $blog->created_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</div>
<script>
    function fetchBlogs(params = {}) {
        $.ajax({
            url: "{{ route('display-blogs') }}",
            data: params,
            success: function(response) {
                $('#blog-list').html(response);
            },
            error: function() {
                alert('Failed to load blogs.');
            }
        });
    }

    // Search
    $('form#blog-search-form').on('submit', function(e) {
        e.preventDefault();
        const search = $(this).find('input[name="search"]').val();
        fetchBlogs({ search });
    });

    // Category filter
    $('.category-filter').on('click', function(e) {
        e.preventDefault();
        const categoryId = $(this).data('id');
        fetchBlogs({ category_id: categoryId });
    });

    // Archive filter
    $('.archive-filter').on('click', function(e) {
        e.preventDefault();
        const archive = $(this).data('archive'); // Format: "2024-03"
        fetchBlogs({ archive });
    });
</script>

@endsection
