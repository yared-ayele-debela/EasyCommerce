@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="index.html">Home</a></li>
         <li class="breadcrumb-item">Orders
         </li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
        <p class="d-inline-flex gap-1 align-items-end ">
            <a class="btn btn-light border shadow-sm  mb-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              Filter Orders
            </a>
            <a class="btn btn-light  shadow-sm  mb-3" href="{{ route('order-reports')}}" >
                View vie Chart
              </a><br>
        </p>
          <div class="collapse border-0 shadow-none" id="collapseExample">
            <div class="card card-body border-0 shadow-none">
                <form id="filterForm" action="{{ route('order-filter-reposts') }}" method="post">
                    @csrf
                    <div class="row pt-2" >
                        <div class="col">
                            <div class="form-group">
                                <label for="start_date" class="text-sm ">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="end_date" class="text-sm ">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="order_id" class="text-sm ">Order ID </label>
                                <input type="text" class="form-control" id="order_id" name="order_id">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="product_name" class="text-sm ">Product:</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="phone_number" class=" text-sm">Phone:</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="customer_name" class="text-sm" >Customer:</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="order_status" class="text-sm">Order Status:</label>
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
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            </div>&nbsp;
                            <div class="form-group pt-4">
                                <a href="{{ route('allorders') }}" class="btn btn-danger btn-sm">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
          </div>
         <div class="card">
            <div class="card-body">
               @if(Session::has('success_message'))
                <div class=" col-lg-6 alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1">
                    </i>{{ Session::get('success_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
               @endif
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100 mt-3">
                  <a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-list mr-2"></i>All Orders</a>&nbsp;
                @if ($user && $user->hasPermissionByRole('view order reports'))
                       <a class="btn btn-warning text-white" target="_blank" href="{{url('admin/orders_report')}}">Orders Reports</a>
                @endif
               </ul>
               <table id="example"  class="table table-responsive mt-2">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col"> Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Ordered Products</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach ($orders as $k => $order)
                    @if($order['orders_products'])
                     <tr>
                        <td>{{ $order['id']}}</td>

                        <td>
                            {{ date('Y-m-d h:i:s',strtotime($order['created_at'])) }}
                        </td>
                        <td>{{ $order['name'] }}</td>
                        <td>{{ $order['email'] }}
                            <td>{{ $order['mobile'] }}

                         </td>
                        <td>
                            @foreach ($order['orders_products'] as $product)
                                {{ $product['product_name'] }} ({{ $product['product_qty'] }})
                            @endforeach
                        </td>
                        <td>
                            {{ $order['grand_total'] }}
                        </td>
                        <td>
                            {{ $order['payment_method'] }}
                        </td>
                        <td>
                                 <a href=""><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm disabled" >{{$order['order_status']}}</span></a>
                           </td>
                        <td>
                        <div class="flex">
                              @if ($user && $user->hasPermissionByRole('view_orders_details'))
                              <a href="{{ url('admin/orders/'.$order['id']) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm ml-1"><i class="ri-eye-fill"></i></a>
                              @endif

                              @if ($user && $user->hasPermissionByRole('view_order_invoice'))
                              <a target="_blank" href="{{ url('admin/order/invoice/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm ml-1"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="delivery note"
                              >
                              <i class="ri-printer-cloud-fill"></i></a>
                              @endif

                              @if ($user && $user->hasPermissionByRole('view_order_invoice'))
                              <a target="_blank" href="{{ url('admin/order/invoice/pdf/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm ml-1"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="view good receiving note"
                              >
                              <i class="ri-file-pdf-line ">
                              </i>
                             </a>
                              @endif
                        </div>
                        </td>
                     </tr>
                    @endif
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
