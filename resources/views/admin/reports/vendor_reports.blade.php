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
                <li class="breadcrumb-item">Vendors</li>
                <li class="breadcrumb-item active">Vendors reports</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">
                <p class="d-inline-flex gap-1 align-items-end ">
                    <a class="btn btn-light border shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Filter Vendors
                    </a><br>
                </p>
                  <div class="collapse border-0 shadow-none" id="collapseExample">
                    <div class="card card-body border-0 shadow-none">
                        <form action="{{ route('filter-vendors') }}" method="get">
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
                                      <label for="confirm">Verify or No verify</label>
                                      <select class="form-control" name="confirm" id="">
                                        <option value="" disabled selected>select one</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                      </select>
                                    </div>
                                </div>
                            <div class="col d-flex">
                                <div class="form-group pt-4">
                                <button type="submit" class="btn  btn-primary">Filter</button>
                                </div>&nbsp;
                                <div class="form-group pt-4">
                                    <a href="{{ route('vendor-reports') }}" class="btn  btn-danger">Reset</a>
                                    </div>
                            </div>
                        </div>


                        </div>
                        </form>
                    </div>
                  </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if(!empty($vendor))
                        <table id="example"  class="table datatable table-white ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Confirm</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendor as $vendor)
                                        <tr>
                                            <td>{{ $vendor->id }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td>{{ $vendor->address }}</td>
                                            <td>{{ $vendor->city }}</td>
                                            <td>{{ $vendor->state }}</td>
                                            <td>{{ $vendor->country }}</td>
                                            <td>{{ $vendor->mobile }}</td>
                                            <td>{{ $vendor->email }}</td>
                                            <td>@if($vendor->confirm == "Yes")
                                                  Yes
                                                  @else
                                                  No
                                                  @endif
                                            </td>
                                            <td>{{ $vendor->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No users found for the selected date range.</p>
                        @endif
                        <div class=" pagination-sm">
                            {{-- {{ $categories->links() }} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
