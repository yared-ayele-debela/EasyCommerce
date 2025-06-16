@extends('all_frontend_layouts.layouts')
@section('content')

<div class="container pb-5">
    <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">Blog detail</h5>
    </div>
    <div class="blog-detail-wrapper">
        <h1 class="h2 mb-3 text-dark fw-bold">{{ $blogs->title }}</h1>
        <div class="mb-3 text-muted small">
            <span>Comments ({{ $count_blog_comment }})</span>
            <span class="mx-2">|</span>
            <span>{{ $blogs->created_at->format('F j, Y') }}</span>
        </div>
        <div class="mb-4">
            <img class="img-fluid rounded shadow-sm" src="{{ $blogs['image'] }}" alt="Blog Image">
        </div>

        <!-- Blog Content -->
        <div class="mb-5 fs-5 lh-lg text-dark">
            {!! $blogs->description !!}
        </div>

        <!-- Comments Section -->
        <div class="mb-5">
            <h4 class="mb-4">{{ $count_blog_comment }} Comments</h4>
            <ul class="list-unstyled">
                @foreach ($blog_comment as $comment)
                    <li class="mb-4 border-bottom pb-3">
                        <h6 class="fw-bold mb-1">{{ $comment->fullname }}</h6>
                        <small class="text-muted">{{ $comment->created_at->format('F j, Y h:i A') }}</small>
                        <p class="mt-2">{{ $comment->comment }}</p>
                    </li>
                @endforeach
            </ul>
            <div class="pagination-sm">
                {!! $blog_comment->links() !!}
            </div>
        </div>

        <div class="mb-2">
             @if(Auth::check())
             <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#leaveCommentModal">
                 Leave a Comment
             </button>
            @endif

             <div class="modal fade" id="leaveCommentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered " role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="modalTitleId">
                                 Leave a Comment
                             </h5>
                             <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                            <form method="POST" action="{{ route('store-blogs') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $blogs->id }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fullname" class="form-label">Full Name *</label>
                                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="comment" class="form-label">Comment *</label>
                                        <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Post Comment</button>
                                </div>
                            </form>
                         </div>

                     </div>
                 </div>
             </div>

             <!-- Optional: Place to the bottom of scripts -->
             <script>
                 const myModal = new bootstrap.Modal(
                     document.getElementById("modalId")
                     , options
                 , );

             </script>

        </div>
    </div>
</div>
@endsection
