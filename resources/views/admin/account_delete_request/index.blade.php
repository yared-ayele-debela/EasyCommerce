@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="container">
     <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item active">List of account deletion requests</li>
      </ol>
   </nav>
 </div>
    <h2>Account Deletion Requests</h2>

    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-info">{{ session('error') }}</div>
    @endif

    @forelse($requests as $request)
        <div class="card my-3">
            <div class="card-body pt-3">
                <p><strong>User:</strong> {{ $request->user_email }} | Phone Number: <strong>{{ $request->user_phone }}</strong> </p>
                <p><strong>Reason:</strong> {{ $request->reason ?? 'No reason provided' }}</p>

                  <button
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal{{ $request->id }}">
                    Delete Account
                </button>


                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="confirmDeleteModal{{ $request->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="confirmDeleteLabel">Confirm Account Deletion</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <strong>permanently delete</strong> the account of <span id="userName"></span>?</p>
                                <p>This action cannot be undone!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form method="POST" action="{{ route('admin.account.delete', $request->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Account</button>
                                </form>
                            </div>
                        </div>
                </div>
                </div>

                <form method="POST" action="{{ route('admin.account.reject', $request->id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-secondary btn-sm">Reject</button>
                </form>
            </div>
        </div>
    @empty
        <p>No pending requests.</p>
    @endforelse
    <hr>
    <div class="card">
        <div class="card-header">
            <h3>Request History</h3>

        </div>
        <div class="card-body">
    @if($request_history->count())
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>User Email</th>
                <th>Phone Number</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($request_history as $index => $history)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $history->user_email }}</td>
                    <td>{{ $history->user_phone }}</td>
                    <td>{{ $history->reason ?? 'No reason provided' }}</td>
                    <td>
                        <span class="badge {{ $history->is_reviewed ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $history->is_reviewed ? 'Completed' : 'Pending' }}
                        </span>
                    </td>
                    <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No request history available.</p>
    @endif
        </div>
    </div>
</div>


@endsection
