@extends('fontend.layout.layout')
@section('content')
<style>
    div#social-links {
        margin: 0 auto;
        max-width: 500px;
    }
    div#social-links ul li {
        display: inline-block;
    }
    div#social-links ul li a {
        padding: 7px;
        margin: 1px;
        font-size: 10px;
        border-radius: 0.1rem;
        color: #ffffff;
        background-color: #1E665E;
    }
</style>

    <div class="page-blog-detail u-s-p-t-80">
        <div class="blog-detail-wrapper">
            <h1 class="blog-post-heading u-s-m-b-13">
                <a href="javascript:void(0);">{{ $blogs->title }}</a>
            </h1>
            <div class="blog-post-info u-s-m-b-13">
                <span class="blog-post-preposition">By</span>
                <a class="blog-post-author-name" href="javascript:void();">{{ $blogs->added_by }}</a>
                <span class="blog-post-info-separator">/</span>
                <a class="blog-post-comment" href="javascript:void(0);">Comments ({{ $count_blog_comment }})</a>
                <span class="blog-post-info-separator">/</span>
                <span class="blog-post-published-date">
                   <span>{{ $blogs->created_at }}</span>
                </span>
            </div>
            <div class="post-content">
                <img class="img-fluid" src="{{ asset('/storage/blog/'.$blogs['image']) }}" alt="Blog Post 1">
                <p>
                    {!! $blogs->description !!}
                </p>
            </div>
            <!-- Post-Social-Media -->
            <div class="post-share-wrapper u-s-m-b-25">
                <ul class="social-media-list">
                        <li>
                            {!! $shareComponent !!}
                        </li>
                </ul>
            </div>


            <div class="blog-detail-comment u-s-m-b-50">
                <h3 class="comment-title u-s-m-b-30">{{ $count_blog_comment }} Comments on “Your Life is an extraordinary Adventure”</h3>
                <ol class="comment-list">
                    @foreach ($blog_comment as $comment )
                    <li>
                        <div class="comment-body">
                            {{-- <div class="comment-author-image">
                                <img src="images/blog/avatar.jpg" alt="avatar image">
                            </div> --}}
                            <div class="comment-content">
                                <h3>{{ $comment->fullname }}</h3>
                                <h6>{{ $comment->created_at }}</h6>
                                <p>{{ $comment->comment }}</p>
                                {{-- <a href="#">Reply</a> --}}
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ol>
                <div class="pagination-sm">
                    {!! $blog_comment->links() !!}
                </div>
            </div>
            <!-- Post-Comments /- -->
            <!-- Post-Comment-Form -->
            <div class="blog-detail-post-comment u-s-m-b-25">
                <h3>Type Your Comment</h3>
                <span>Your email address will not be published. Required fields are marked *</span>
                <form method="post" action="{{ route('store-blogs') }}">
                    @csrf
                    <div class="u-s-m-b-30">
                        <label for="your-comment">Comment</label>
                        <input type="hidden" name="id" value="{{ $blogs->id }}">
                        <textarea class="text-area" name="comment" id="your-comment"></textarea>
                    </div>
                    <div class="u-s-m-b-30">
                        <label for="comment-name">Full Name
                            <span class="astk">*</span>
                        </label>
                        <input type="text" id="fullname" name="fullname" class="text-field">
                    </div>
                    <div class="u-s-m-b-30">
                        <label for="comment-email">Email
                            <span class="astk">*</span>
                        </label>
                        <input type="text" id="email" name="email" class="text-field">
                    </div>

                    <div class="u-s-m-b-30">
                        <button type="submit" class="button button-primary w-100">Post Comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
