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
                <li class="breadcrumb-item">Orders</li>
                <li class="breadcrumb-item active">Orders reports</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <p class="d-inline-flex gap-1 align-items-end ">
                    <a class="btn btn-light border shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter Orders
                    </a>
                    <a class="btn btn-light  shadow-sm  mb-3" href="{{ route('order-reports')}}" >
                        View vie Chart
                    </a>
                <br>
                </p>
                <div class="collapse border-0 shadow-none" id="collapseExample">
                    <div class="card card-body border-0 shadow-none">
                        <form id="filterForm" action="{{ route('filter-orders') }}" method="post">
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
                                        <select class="form-control" name="order_status" id="order_status">
                                            <option value="" disabled selected>Select one</option>
                                            @foreach ($order_status as $order)
                                                <option value="{{ $order->name }}">{{ $order->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col d-flex">
                                    <div class="form-group pt-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>&nbsp;
                                    <div class="form-group pt-4">
                                        <a href="{{ route('orders-reports') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if(!empty($orders))
                        <div class="table-responsive" id="orders-table">
                        <table id="example"  class="table datatable table-white table-responsive">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer name</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Shipping Charges</th>
                                        <th>Tax</th>
                                        <th>Status</th>
                                        <td>Payment Method</td>
                                        <td>Grand Total</td>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>{{ $order->city }}</td>
                                            <td>{{ $order->state }}</td>
                                            <td>{{ $order->country }}</td>
                                            <td>{{ $order->mobile }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->shipping_charges }}</td>
                                            <td>{{ $order->tax_charge }}</td>
                                            <td>{{ $order->order_status }}</td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>{{ $order->grand_total }}</td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No users found for the selected date range.</p>
                        @endif
                        <div class=" pagination-sm">
                            {{ $orders->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
