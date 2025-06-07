@extends('all_frontend_layouts.layouts')
@section('content')
@section('content')
<div class="container py-4">
     <div class="header">
        <button class="btn btn-link text-dark" onclick="history.back()">
            <i class="bi bi-arrow-left"></i>
        </button>
        <h5 class="my-4 text-dark text-center">My Notifications</h5>
    </div>
     <div class="card">
        <div class="card-body">
        @session('success')
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
          <strong>Deleted!</strong>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endsession
        @if($notifications->isEmpty())
        <div class="alert alert-info">You have no notifications.</div>
        @else
            @foreach($notifications as $note)
                <div class="alert alert-{{ $note->is_read ? 'warning' : 'primary' }}">
                    <strong>{{ $note->title }}</strong>
                    <div>{{ $note->message }}</div>
                    <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                    <a href="{{ url('notifications/delete/'.$note->id) }}"
                    class="btn btn-sm btn-outline-danger float-end"
                    onclick="return confirm('Are you sure you want to delete this notification?');">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            @endforeach
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
        </div>
     </div>
</div>
@endsection
