<!-- admin/reports/user_reports.blade.php -->

@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Transfer stock products</li>
                <li class="breadcrumb-item active">Transfer stock products reports</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <p class="d-inline-flex gap-1 align-items-end ">
                    <a class="btn btn-light  shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter transfer stock products
                    </a>
                    <a class="btn btn-light  shadow-sm  mb-3" href="{{ route('transfer-stock-product-reports')}}" >
                        View vie Chart
                      </a><br>
                </p>
                  <div class="collapse border-0 shadow-none" id="collapseExample">
                    <div class="card card-body border-0 shadow-none">
                        <form id="filterForm" action="{{ route('filter-transfer-stocks') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="order_status">From :</label>
                                        <select class="form-control" name="from_warehouse" id="from_warehouse">
                                            <option value="" disabled selected>Select one</option>
                                            @foreach ($warehouse as $house)
                                                <option value="{{ $house->id }}">{{ $house->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="order_status">To :</label>
                                        <select class="form-control" name="to_warehouse" id="from_warehouse">
                                            <option value="" disabled selected>Select one</option>
                                            @foreach ($warehouse as $house)
                                                <option value="{{ $house->id }}">{{ $house->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col d-flex">
                                    <div class="form-group pt-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>&nbsp;
                                    <div class="form-group pt-4">
                                        <a href="{{ route('transfer-stock-reports') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if(!empty($transfer_stock_product))
                        <div class="table-responsive" id="orders-table">
                        <table id="example"  class="table datatable table-white table-responsive">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>From </th>
                                        <th>To</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Notes</th>
                                        <th>Transfer Date</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($transfer_stock_product as $stock)
                                        <tr>
                                            <td>{{ $stock->id }}</td>
                                            <td>{{ $stock->fromWarehouse->name }}</td>
                                            <td>{{ $stock->toWarehouse->name }}</td>
                                            <td>{{ $stock->product->product_name }}</td>
                                            <td>{{ $stock->quantity }}</td>
                                            <td>{{ $stock->notes }}</td>
                                            <td>{{ $stock->transfer_date }}</td>
                                            <td>{{ $stock->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No users found for the selected date range.</p>
                        @endif
                        <div class=" pagination-sm">
                            {{ $transfer_stock_product->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
