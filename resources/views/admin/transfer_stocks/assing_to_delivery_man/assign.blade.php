@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3 ">
            <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Transfer stock products</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="card border-0 shadow-sm">
        <form action="{{ route('store-assign-to-deliveryman') }}" method="POST">
            @csrf
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <h5 class="card-title">Select delviery man</h5>
                                    <select class="form-control" id="delivery_man" name="delivery_man">
                                        <option value="" selected disabled required>select</option>
                                        @foreach($deliverymans as $man)
                                        <option value="{{ $man->id }}"> <strong>{{ $man->first_name }} {{ $man->last_name }} </strong> | Phone : {{ $man->phone }} | Vehicle type : {{ $man->vehicle_type }} | Delivery Zone : {{ $man->delivery_zone }}</option>
                                        @endforeach
                                    </select>
                                    @error('delivery_man')
                                    <small class=" text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title">Select transfered product list</h5>
                        <table class="table " class="table datatable">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Is final Destination</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>FromWarehouse</th>
                                    <th>To Warehouse</th>
                                    <th>Note</th>
                                    <th>Transfer Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stock_transfer_product as $stock)
                                <tr>

                                    <td><input type="checkbox" name="product_in_stock[]" value="{{ $stock->id }}" style="width: 20px; height:20px; " class="shadow-sm border-0"></td>
                                    <td>
                                        <div class="form-group">
                                          <select class="form-control" name="is_final_destination" id="">
                                            <option value="" disabled selected>select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                          </select>
                                          @error('is_final_destination')
                                            <small class=" text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </td>

                                    <td>
                                        {{ $stock->product->product_name }}
                                    </td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>
                                        {{ $stock->fromWarehouse->name }}
                                    </td>
                                    <td>
                                        {{ $stock->toWarehouse->name }}
                                    </td>
                                    <td>{{ $stock->notes }}</td>

                                    <td>{{ $stock->transfer_date }}</td>
                                </tr>
                                @endforeach
                                @error('product_in_stock')
                                <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </tbody>
                        </table>
                        <div class=" pagination-sm">
                            {{-- {{ $stock_transfer_product->links() }} --}}
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group p-3 ">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>

@endsection

{{-- @section('script') --}}
<!-- Add this jQuery section below your existing HTML -->



{{-- @endsection --}}

