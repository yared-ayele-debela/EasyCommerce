@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Stock transfered products</li>
       </ol>
    </nav>
 </div>
 <section class="section">
    <div class="row">
        <div class="col-lg-12">
           <div class="card border-0">
              <div class="card-body">
                 <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                      <li class="nav-item">
                      <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Stock transfered products</a>
                      </li>
                 </ul>
                 <table class="table datatable" class="table datatable">
                    <thead>
                       <tr>
                          <th>ID</th>
                          <th>Product</th>
                          <th>FromWarehouse</th>
                          <th>To Warehouse</th>
                          <th>Note</th>
                          <th>Transfer Date</th>
                          <td>Action</td>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($stock_products as $stock)

                       <tr>
                          <td>{{ $stock->id }}</td>
                          <td>
                              {{ $stock->transfer_stock_product->product->product_name }}
                          </td>

                          <td>
                              {{ $stock->transfer_stock_product->fromWarehouse->name }}
                          </td>
                          <td>
                              {{ $stock->transfer_stock_product->toWarehouse->name }}
                          </td>
                          <td>
                              {{ $stock->transfer_stock_product->notes }}
                          </td>
                          <td>
                              {{ $stock->transfer_stock_product->transfer_date }}
                          </td>
                          <td>

                            @if($stock->transfer_stock_product->delivery_status=="delivered" || $stock->transfer_stock_product->delivery_status=="shipped")
                            <a href="{{ url('delivery-boy/product/stock-transfer/invoice/'.$stock->id) }}"  target="_blank"  style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="view dispatch note"
                                 ><i class=" ri-printer-fill"></i></a>
                            @endif

                            @if($stock->transfer_stock_product->delivery_status=="delivered")
                            <a href="{{ url('delivery-boy/good-receiving-note/invoice/'.$stock->id) }}" target="_blank"  style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="view good receiving note"
                                 ><i class=" ri-printer-cloud-fill "></i></a>
                            @endif
                              <a href="{{ url('delivery-boy/stock-product/detail/'.$stock->id) }}" style="background-color:hsl(0, 0%, 94%) " class="btn  btn-sm" ><i class=" ri-eye-fill "></i></a>
                          </td>
                       </tr>
                       @endforeach

                    </tbody>
                 </table>
                 <div class=" pagination-sm">
                    {{-- {{ $categories->links() }} --}}
                 </div>

              </div>
           </div>
        </div>
     </div>
 </section>
@endsection
