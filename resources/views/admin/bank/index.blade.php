@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
        <i class="bi bi-arrow-left mr-2"></i> &nbsp;
        <span>Back</span>
    </button>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Out of stock products</li>
    </ol>
</nav>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-3">Bank Information</h4>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Bank</button>
        </div>

        <div class="card-body my-2">
              @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banks as $bank)
                    <tr>
                        <td>{{ $bank->bank_name }}</td>
                        <td>{{ $bank->account_number }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $bank->id }}">Edit</button>
                            <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this bank info?')" class="btn btn-danger btn-sm">Delete</button>
                            </form>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $bank->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('banks.update', $bank->id) }}" method="POST" class="modal-content">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Bank Info</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Bank Name</label>
                                                <input type="text" name="bank_name" class="form-control" value="{{ $bank->bank_name }}">
                                            </div>
                                            <div class="mb-3">
                                                <label>Account Number</label>
                                                <input type="number" name="account_number" class="form-control" value="{{ $bank->account_number }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('banks.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Bank Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Account Number</label>
                    <input type="number" name="account_number" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

