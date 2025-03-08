@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">stok</li>
         <li class="breadcrumb-item active">stock transfer list</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card border-0 shadow-sm">
            <div class="card-body">
               <h5 class="card-title">Stock transfer list</h5>
               <table class="table datatable" class="table datatable">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <td>Shipped Code</td>
                        <td>Delivered Code</td>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>FromWarehouse</th>
                        <th>To Warehouse</th>
                        <th>Note</th>
                        <th>Transfer Date</th>
                        {{-- <td>Action</td> --}}
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($all_product_stocks as $stock)

                     <tr>
                        <td>{{ $stock->id }}</td>
                        <td>
                            {{ $stock->shipped_confirmation_number }}
                        </td>
                        <td>
                            {{ $stock->delivered_confirmation_number }}
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
                         {{-- <td>
                            <a href="{{ url('admin/invoice-stock-transfer/invoice/'.$stock->id) }}" style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm" ><i class=" ri-printer-fill"></i></a>
                         </td> --}}
                        {{-- <td>
                         <a href="{{ url('admin/delete-stock-transfer-product/'.$stock->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this stock product transfer ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                        </td> --}}
                     </tr>
                     @endforeach

                  </tbody>
               </table>
               <div class=" pagination-sm">
                  {{ $all_product_stocks->links() }}
               </div>

            </div>
         </div>
      </div>
   </div>
 </section>

@endsection
