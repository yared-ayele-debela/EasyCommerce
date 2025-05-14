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
            <li class="breadcrumb-item active" aria-current="page">Tips setting</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Manage Tips Setting</h4>

            <!-- Add Tip Modal Trigger -->
            <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addTipModal">Add Tip</button>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tips as $tip)
                    <tr>
                        <td>{{ $tip->id }}</td>
                        <td>{{ $tip->amount }} ETB</td>
                        <td>
                            <!-- Edit -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $tip->id }}">Edit</button>

                            <!-- Delete -->
                            <form method="POST" action="{{ route('tips.destroy', $tip) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <div class="modal fade" id="editModal{{ $tip->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('tips.update', $tip) }}">
                                        @csrf @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Edit Tip</h5>
                                            </div>
                                            <div class="modal-body">
                                                <input type="number" name="amount" class="form-control" value="{{ $tip->amount }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
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
        <!-- Add Tip Modal -->
        <div class="modal fade" id="addTipModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('tips.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Add Tip</h5>
                        </div>
                        <div class="modal-body">
                            <input type="number" name="amount" class="form-control" placeholder="Enter tip amount" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

