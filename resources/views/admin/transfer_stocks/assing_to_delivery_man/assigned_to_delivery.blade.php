@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Assigned</li>
         <li class="breadcrumb-item active">stock product list</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card border-0 shadow-sm">
            <div class="card-body">
               <h5 class="card-title">Assigned stock product to delivery man</h5>
               <table class="table datatable" class="table datatable">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <td>Delivery Man</td>
                        <th>FromWarehouse</th>
                        <th>To Warehouse</th>
                        <td>Quantity</td>
                        <th>Note</th>
                        <td>Delivery Status</td>
                        <th>Transfer Date</th>
                        <td>Action</td>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($transfered_stock_product as $stock)

                     <tr>
                        <td>{{ $stock->id }}</td>
                        <td>
                            {{ $stock->transfer_stock_product->product->product_name }}
                        </td>
                        <td>
                            {{ $stock->deliveryMan->first_name  }}   {{ $stock->deliveryMan->last_name  }}

                        </td>
                        <td>
                            {{ $stock->transfer_stock_product->fromWarehouse->name }}
                        </td>
                        <td>
                            {{ $stock->transfer_stock_product->toWarehouse->name }}
                        </td>
                        <td>
                            {{ $stock->transfer_stock_product->quantity }}
                        </td>
                        <td>
                            {{ $stock->transfer_stock_product->notes }}
                        </td>
                        <td>
                            @if($stock->transfer_stock_product->delivery_status)
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">
                                {{ $stock->transfer_stock_product->delivery_status }}
                            </a>
                            @endif
                        </td>
                        <td>
                            {{ $stock->transfer_stock_product->transfer_date }}
                        </td>
                        <td>
                            @if($stock->transfer_stock_product->delivery_status==="shipped" ||  $stock->transfer_stock_product->delivery_status=="delivered")
                            <a href="{{ url('admin/product/stock-transfer/invoice/'.$stock->id) }}"  target="_blank"  style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="view dispatch note"
                                 ><i class=" ri-printer-fill"></i></a>
                            @endif

                            @if($stock->transfer_stock_product->delivery_status=="delivered")
                            <a href="{{ url('admin/good-receiving-note/invoice/'.$stock->id) }}" target="_blank"  style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="view good receiving note"
                                 ><i class=" ri-printer-cloud-fill "></i></a>
                            @endif
                            <a href="{{ url('admin/delete-stock-transfer-product/'.$stock->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this assigned stock transfered product ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                        </td>
                     </tr>
                     @endforeach

                  </tbody>
               </table>
               <div class=" pagination-sm">
                  {{-- {{ $all_product_stocks->links() }} --}}
               </div>
            </div>
         </div>
      </div>
   </div>
 </section>

@endsection
