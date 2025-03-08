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
                <li class="breadcrumb-item">Custom Orders</li>
                <li class="breadcrumb-item active">Custom Orders</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <p class="d-inline-flex gap-1 align-items-end ">
                    <a class="btn btn-light border shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter Custom Orders
                    </a><br>
                </p>
                  <div class="collapse border-0 shadow-none" id="collapseExample">
                    <div class="card card-body border-0 shadow-none">
                        <form id="filterForm" action="{{ route('filter-custom-orders') }}" method="post">
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
                                        <label for="order_status">Order Status:</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="" disabled selected>Select one</option>
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col d-flex">
                                    <div class="form-group pt-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>&nbsp;
                                    <div class="form-group pt-4">
                                        <a href="{{ route('custom-order-reports') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if(!empty($custom))
                        <div class="table-responsive" id="orders-table">
                        <table id="example"  class="table datatable table-white table-responsive">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer name</th>
                                        <th>Mobile Number</th>
                                        <td>Product Name</td>
                                        <td>Qty</td>
                                        <td>Description</td>
                                        <td>Delivery Address</td>
                                        <td>Delivery Status</td>
                                        <th>Order Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($custom as $order)
                                    @foreach($order->custom_order_product as $product)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->phone_number }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->delivery_address }}</td>
                                            <td>{{ $order->delivery_status }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No users found for the selected date range.</p>
                        @endif
                        <div class=" pagination-sm">
                            {{ $custom->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
