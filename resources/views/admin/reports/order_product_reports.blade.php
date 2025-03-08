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
                <li class="breadcrumb-item">Order Products</li>
                <li class="breadcrumb-item active">Order Products reports</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <p class="d-inline-flex gap-1 align-items-end ">
                    <a class="btn btn-light  shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter Order Products
                    </a>
                    <a class="btn btn-light  shadow-sm  mb-3" href="{{ route('order-products-reports')}}" >
                        View vie Chart
                      </a><br>
                </p>
                  <div class="collapse border-0 shadow-none" id="collapseExample">
                    <div class="card card-body border-0 shadow-none">
                        <form id="filterForm" action="{{ route('filter-order-products') }}" method="post">
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
                                        <a href="{{ route('order-product-reports') }}" class="btn btn-danger">Reset</a>
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
                                        <td>Order Id</td>
                                        <th>Customer name</th>
                                        <th>Product code</th>
                                        <th>Product name</th>
                                        <th>Product color</th>
                                        <th>Product size</th>
                                        <th>Product price</th>
                                        <th>Qty</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->product_code }}</td>
                                            <td>{{ $order->product_name }}</td>
                                            <td>{{ $order->product_color }}</td>
                                            <td>{{ $order->product_size }}</td>
                                            <td>{{ $order->product_price }}</td>
                                            <td>{{ $order->product_qty }}</td>
                                            <td>{{ $order->item_status }}</td>
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
