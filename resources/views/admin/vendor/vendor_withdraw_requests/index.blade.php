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
        <li class="breadcrumb-item active" aria-current="page">Withdraw requests</li>
    </ol>
</nav>
  <div class="card">
    <div class="card-header bg-light text-dark">
      <h5 class="mb-0">Withdraw Requests</h5>
    </div>
    <div class="card-body p-2">
      <div class="table-responsive">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>Vendor</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Action</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($requests as $req)
              <tr>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ven{{ $req->id }}">
                     <i class="bi bi-eye-fill"></i>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="ven{{ $req->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-lg">
 <div class="modal-content modal-lg">
                                <div class="modal-header">
                                    <h5 class="modal-title">Vendor Detail informatione</h5>
                                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-md-8">
                                            <h5>{{ $req->vendor->name }}</h5>
                                            <p><strong>Email: </strong> &nbsp; {{ $req->vendor->email }} </p>
                                            <p><strong>Phone: </strong> &nbsp; {{ $req->vendor->mobile }} </p>
                                            <p><strong>Address: </strong> &nbsp;{{ $req->vendor->address }}, {{$req->vendor->city}}, {{ $req->vendor->state }}, {{ $req->vendor->country }}  </p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Account Number:</strong> {{ $req->vendor->vendorBank ? $req->vendor->vendorBank->account_number : 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Bank Name:</strong> {{ $req->vendor->vendorBank ? $req->vendor->vendorBank->bank_name : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                    </div>
                    {{ $req->vendor->name }}</td>
                <td><strong>{{ number_format($req->amount, 2) }} ETB</strong></td>
                <td>
                  <span class="badge
                    @if($req->status === 'approved') bg-success
                    @elseif($req->status === 'rejected') bg-danger
                    @else bg-warning
                    @endif">
                    {{ ucfirst($req->status) }}
                  </span>
                </td>
                <td>
                 <!-- Button trigger modal -->
                 <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#action{{ $req->id }}">
                   Update
                 </button>

                 <!-- Modal -->
                 <div class="modal fade" id="action{{ $req->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                              <form method="POST" action="{{ route('admin.withdraw.update', $req->id) }}" class="form-inline">
                                    @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Update Withdraw Request</h5>
                                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">

                                    <div class="form-group mr-2 mb-2">
                                    <label for="status" class="form-lable">Select Status</label>
                                    <select name="status" id="status" class="form-control form-control-sm">
                                        <option value="approved">Approve</option>
                                        <option value="rejected">Reject</option>
                                    </select>
                                    </div>
                                    <div class="form-group mr-2 mb-2">
                                    <label for="note" class="form-lable">Note</label>
                                    <input type="text" name="note" id="note" class="form-control form-control-sm" placeholder="Optional note">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                          </form>
                        </div>
                    </div>
                 </div>
                </td>
                <td>
                    {{ $req->created_at}}
                    @if($req->status!=="pending")
                    <i class="bi bi-check2-all"></i>
                    @else
                    <i class="bi bi-check"></i>
                    @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
        <div class="d-flex justify-content-left">
            {{ $requests->links() }}
        </div>
    </div>
  </div>

</div>
@endsection

