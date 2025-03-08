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
                <li class="breadcrumb-item">products</li>
                <li class="breadcrumb-item active">products reports</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <p class="d-inline-flex gap-1 align-items-end ">
                    <a class="btn btn-light border shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter products
                    </a>
                    <a class="btn btn-light  shadow-sm  mb-3" href="{{ route('products-reports')}}" >
                        View vie Chart
                      </a><br>
                </p>
                  <div class="collapse border-0 shadow-none" id="collapseExample">
                    <div class="card card-body border-0 shadow-none">
                        <form id="filterForm" action="{{ route('filter-products') }}" method="post">
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
                                        <label for="product_status"> Category:</label>
                                        <select class="form-control" name="category" id="category">
                                            <option value="" disabled selected>Select one</option>
                                            @foreach ($category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="product_status"> Brand:</label>
                                        <select class="form-control" name="brand" id="brand">
                                            <option value="" disabled selected>Select one</option>
                                            @foreach ($brand as $brand )
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col d-flex">
                                    <div class="form-group pt-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>&nbsp;
                                    <div class="form-group pt-4">
                                        <a href="{{ route('product-reports') }}" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if(!empty($products))
                        <div class="table-responsive" id="products-table">
                        <table id="example"  class="table datatable table-white table-responsive">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Group</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Vendor</th>
                                        <th>Product Name</th>
                                        <th>Color</th>
                                        <th>Code</th>
                                        <th>Price</th>
                                        <th>Tax</th>
                                        <th>Discount</th>
                                        <th>IsFeatured</th>
                                        <td>Status </td>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->group->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>@if($product->vendor_id==0)
                                                  Admin
                                                @else
                                                {{ $product->vendor_id }}
                                                @endif
                                             </td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->product_color }}</td>
                                            <td>{{ $product->product_code }}</td>
                                            <td>{{ $product->product_price }}</td>
                                            <td>{{ $product->product_tax }}</td>
                                            <td>{{ $product->product_discount }}</td>
                                            <td>{{ $product->is_featured }}</td>
                                            <td>
                                                @if($product->status==1)
                                                    Acitve
                                                @else
                                                    InActive
                                                @endif
                                            </td>
                                            <td>{{ $product->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No users found for the selected date range.</p>
                        @endif
                        <div class=" pagination-sm">
                            {{ $products->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
