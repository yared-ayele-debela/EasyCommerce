@extends('fontend.layout.layout')
@section('content')

<!-- Page Introduction Wrapper /- -->
<!-- Blog-Page -->
<div class="page-blog u-s-p-t-80">
    <div class="container shadow-sm mb-3">
        <div class="row">
              <div class="col-lg-9 col-md-9">
                <!-- Blog-Posts -->
                @if(count($blogs)>0)
                @foreach ($blogs as $blog)
                <div class="blog-post u-s-m-b-80">
                    <div class="blog-post-wrapper u-s-m-b-26">
                        <a class="blog-post-anchor" href="javascript:void(0);">
                            <img class="img-fluid" src="{{ asset('/storage/blog/'.$blog['image'])}}" alt="Blog post 1">
                        </a>
                    </div>
                    <h1 class="blog-post-heading u-s-m-b-13">
                        <a href="{{ url('blogs/details/'.$blog->id) }}">{{ $blog->title }}</a>
                    </h1>
                    <div class="blog-post-info u-s-m-b-13">
                        <span class="blog-post-preposition">By</span>
                        <a class="blog-post-author-name" href="javascript:void();">{{ $blog->added_by }}</a>
                        <span class="blog-post-info-separator">/</span>

                        <span class="blog-post-published-date">
                           <span>{{ $blog->created_at }}</span>
                        </span>
                    </div>
                    <p class="blog-post-paragraph u-s-m-b-16">
                        <div class="blog-description">
                            <?php
                                $words = str_word_count(strip_tags($blog->description), 2);
                                $first20Words = implode(' ', array_slice($words, 0, 200));
                                echo $first20Words . (count($words) > 20 ? '...' : '');
                            ?>
                        </div>
                    </p>
                    <a href="{{ url('blogs/details/'.$blog->id) }}" class="blog-post-read-more " style="color:#1E665E;">Read More</a>
                </div>
                @endforeach
                <div class="pagination-sm">
                    {{-- {!! $blogs->links() !!} --}}
                </div>
                @else
                <p>Blog not found!</p>
                @endif
                <!-- Blog-Posts-Pagination /- -->
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- Blog-Sidebar-Search -->
                <div class="bl-sidebar-widget u-s-m-b-50">
                    <h3 class="bl-sidebar-title-h3 u-s-m-b-20">Search</h3>
                    <form class="group-text-blog-search" action="{{ route('display-blogs') }}" method="GET">
                        <label class="sr-only" for="blog-search">Search On Blog</label>
                        <input type="text" id="blog-search" name="search" class="text-field" placeholder="Search by title...">
                        <button type="submit" class="button fas fa-search"></button>
                    </form>
                </div>
                <!-- Blog-Sidebar-Search /- -->
                <!-- Blog-Sidebar-Category -->
                <div class="bl-sidebar u-s-m-b-50">
                    <h3 class="bl-sidebar-title-h3 u-s-m-b-20">Categories</h3>
                    <ul class="bl-sidebar-list">
                        @foreach ($blog_category as $category)
                        <li>
                            <a href="javascript:void();">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Blog-Sidebar-Category /- -->
                <!-- Blog-Sidebar-Archive -->
                <div class="bl-sidebar u-s-m-b-50">
                    <h3 class="bl-sidebar-title-h3 u-s-m-b-20">Archives</h3>
                    <ul class="bl-sidebar-list">
                        {{-- <li>
                            <a href="blog.html">March 2017 (1)</a>
                        </li> --}}
                        @foreach($blogCounts as $blogCount)
                        <li>
                            <a href="">
                               {{ \Carbon\Carbon::createFromDate($blogCount->year, $blogCount->month, 1)->format('F Y') }}
                               ({{ $blogCount->post_count }})
                            </a>
                        </li>

                      @endforeach

                    </ul>
                </div>
                <!-- Blog-Sidebar-Archive /- -->
                <!-- Blog-Sidebar-Recent-Post -->
                <div class="bl-sidebar u-s-m-b-50">
                    <h3 class="bl-sidebar-title-h3 u-s-m-b-20">Recent Post</h3>
                    @foreach ($latestFiveBlogs as  $blog)
                    <div class="recent-post u-s-m-b-18">
                        <div class="recent-post-image">
                            <a class="" href="{{ url('blogs/details/'.$blog->id) }}">
                                <img src="{{ asset('/storage/blog/'.$blog['image']) }}" alt="recent post" style="max-width: 100px;">
                            </a>
                        </div>
                        <div class="recent-post-info">
                            <a class="" href="{{ url('blogs/details/'.$blog->id) }}">{{ $blog->title }}</a>
                            <span class="recent-post-date">
                               {{ $blog->created_at }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Blog-Sidebar-Recent-Post /- -->
            </div>
        </div>
    </div>
</div>
<!-- Blog-Page /- -->
@endsection
