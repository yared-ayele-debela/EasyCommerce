@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('deliverymen')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
       <ol class="breadcrumb p-3 ">
          <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
          <li class="breadcrumb-item">Custom orders</li>
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
                      <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All custom orders</a>
                      </li>
                 </ul>
                 <table  class="table table-white datatable">
                    <thead>
                       <tr>
                          <th scope="col">ID</th>
                          <td scope="col">Customer Name</td>
                          <th>Mobile number</th>
                          <th scope="col">Status</th>
                          <td scope="col">Delivery Status</td>
                          <th scope="col">Actions</th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($custom_orders as $k => $order)

                       <tr>
                          <td>{{ $order['id'] }}</td>
                          <td>{{ $order['customer_name'] }}</td>
                          <td>{{ $order['phone_number'] }}</td>
                          <td>
                             @if($order['status']=="pending")
                                   <a href="javascript:void(0);"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Pending</span></a>
                             @elseif($order['status']=="approved")
                                   <a href="javascript:void(0);"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Approved</span></a>
                              @endif
                             </td>
                          <td>
                           <a href="javascript:void(0);"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">{{ $order['delivery_status'] }}</span></a>
                          <td>

                            @if ($user && $user->hasPermissionByRole('view custom order invoice'))
                            @if($order['delivery_status']==="Delivered")
                            <a href="{{ url('delivery-boy/stock-transfer/invoice/'.$order['id']) }}" target="_blank" style="background-color: rgb(242, 248, 248)" class=" btn btn-sm"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="view delivery note"
                                ><i class="ri-printer-fill "></i>
                            </a>
                            @endif
                            @endif
                            @if ($user && $user->hasPermissionByRole('view custom order detail'))
                            <a href="{{ url('delivery-boy/custom-orders/detail/'.$order['id']) }}" style="background-color: rgb(242, 248, 248)" class=" btn btn-sm"><i class="ri-eye-line  "></i></a>
                           @endif
                           @if ($user && $user->hasPermissionByRole('delete custom order'))
                           <a href="{{ url('delivery-boy/custom-orders/delete/'.$order['id']) }}" style="background-color: rgb(204, 199, 199); border:none" onclick="return confirm('Are you sure,you want to delete this order ?? ') " class="btn btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
                           @endif
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
