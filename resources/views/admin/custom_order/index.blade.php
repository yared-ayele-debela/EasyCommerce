<?php use App\Models\CustomOrder;?>

@extends('admindashboard.maindashboard')
@section('dashboard')

@php
$user = Auth::guard('admin')->user();
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
           <div class="card">
              <div class="card-body">
                 <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                      <li class="nav-item">
                      <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All custom orders</a>
                      </li>
                      <li class="nav-item ">
                        <a class="nav-link " href="{{ route('create-custom-order') }}"><i class="fa fa-list mr-2"></i>Create custom orders</a>
                        </li>
                 </ul>
                 <table id="example"  class="table datatable">
                    <thead>
                       <tr>
                          <th scope="col">ID</th>
                          <td scope="col">Product Name</td>
                          <th scope="col">Mobile Number</th>
                          <th scope="col">Order Status</th>
                          <th scope="col">Delivery Status</th>
                          <th scope="col">Actions</th>
                       </tr>
                    </thead>
                    <tbody>
                      @foreach ($custom_order as $k => $order)

                       <tr>
                          <td>{{ $order['id'] }}</td>
                          <td>{{ $order['customer_name'] }}</td>
                          <td>{{ $order['phone_number'] }}</td>
                          <td>
                            @if ($user && $user->hasPermissionByRole('edit custom order'))
                             @if($order['status']=="pending")
                                   <a href="javascript:void(0);"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Pending</span></a>
                             @elseif($order['status']=="approved")
                                   <a href="javascript:void(0);"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Approved</span></a>
                              @endif
                            @endif
                          </td>
                          <td>
                            @if($order['delivery_status'])
                            {{ $order['delivery_status'] }}
                            @else
                             None
                            @endif
                          </td>
                          <td>

                          @if(!empty($order['delivery_boy_id']))
                          @if ($user && $user->hasPermissionByRole('view custom order invoice'))
                          @if($order['delivery_status']==="Delivered")
                          <a href="{{ url('admin/custom-order/invoice/'.$order['id']) }}" target="_blank" style="background-color: rgb(242, 248, 248)" class=" btn btn-sm"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="view delivery note"
                          ><i class="ri-printer-fill"></i>
                           </a>
                           @endif
                          @endif
                          @endif
                          @if ($user && $user->hasPermissionByRole('view custom order detail'))
                           <a href="{{ url('admin/custom-orders/detail/'.$order['id']) }}" style="background-color: rgb(242, 248, 248)" class=" btn btn-sm"><i class="ri-eye-line  "></i></a>
                          @endif

                           @if ($user && $user->hasPermissionByRole('delete custom order'))
                           <a href="{{ url('admin/custom-orders/delete/'.$order['id']) }}" style="background-color: rgb(204, 199, 199); border:none" onclick="return confirm('Are you sure,you want to delete this order ?? ') " class="btn btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
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
