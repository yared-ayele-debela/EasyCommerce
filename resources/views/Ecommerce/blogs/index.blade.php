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
        <div class="col-lg-9">
            <!-- Blog Posts -->
            @if(count($blogs) > 0)
                @foreach ($blogs as $blog)
                    <div class="offer-card mb-4 shadow-sm">
                        <img src="{{$blog['image'] }}" class="card-img-top" alt="{{ $blog->title }}">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ url('blogs/details/'.encrypt($blog->id)) }}" class="text-decoration-none text-dark">{{ $blog->title }}</a>
                            </h5>
                            <div class="mb-2 text-muted">
                                <small>By {{ $blog->added_by }} | {{ $blog->created_at->format('M d, Y') }}</small>
                            </div>
                            <p class="card-text">
                                <?php
                                    $words = str_word_count(strip_tags($blog->description), 2);
                                    $first20Words = implode(' ', array_slice($words, 0, 200));
                                    echo $first20Words . (count($words) > 20 ? '...' : '');
                                ?>
                            </p>
                            <a href="{{ url('blogs/details/'.encrypt($blog->id)) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{-- {!! $blogs->links() !!} --}}
                </div>
            @else
                <p>No blog posts found.</p>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="offer-card px-3 py-4">
                <!-- Search -->
            <div class="mb-4">
                <h5 class="mb-2">Search</h5>
                <form action="{{ route('display-blogs') }}" method="GET" class="d-flex">
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
                            <a href="#" class="text-decoration-none text-dark">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Archives -->
            <div class="mb-4">
                <h5 class="mb-3">Archives</h5>
                <ul class="list-group">
                    @foreach($blogCounts as $blogCount)
                        <li class="list-group-item">
                            <a href="#" class="text-decoration-none text-dark" class="text-dark">
                                {{ \Carbon\Carbon::createFromDate($blogCount->year, $blogCount->month, 1)->format('F Y') }}
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
@endsection
