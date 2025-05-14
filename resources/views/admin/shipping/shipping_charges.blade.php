@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp

 <section class="container">
        <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('admin/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Lists of Shipping Charges</li>
        </ol>
    </nav>
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>All Shipping Charge Lists</h5>
                  @if ($user && $user->hasPermissionByRole('create_shipping_charge'))
                  <a class="btn btn-primary" href="{{ url('admin/shipping_create') }}">Add Shipping</a>
                @endif
            </div>
            <div class="card-body">
               @if(Session::has('success_message'))
                <div class=" col-lg-6 alert alert-success alert-dismissible fade show" role="alert">
                 <i class="bi bi-check-circle me-1">
                 </i>{{ Session::get('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
             </div>
             @endif
               <table id="example" class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Zone</th>
                        <th scope="col">Rate (0g to 500g)</th>
                        <th scope="col">Rate (501g to 1000g)</th>
                        <th scope="col">Rate (1001g to 2000g)</th>
                        <th scope="col">Rate (2001g to 5000g)</th>
                        <th scope="col">Rate (Above 5000g)</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach ($shippingCharges as $k => $shipping)

                     <tr>
                        <td>{{ $shipping['id']}}</td>
                        <td>
                            {{ $shipping['zone']}}
                        </td>
                        <td>{{ $shipping['0_500g'] }}</td>
                        <td>{{ $shipping['501_1000g'] }}</td>
                        <td>{{ $shipping['1001_2000g'] }}</td>
                        <td>{{ $shipping['2001_5000g'] }}</td>
                        <td>{{ $shipping['above_5000g'] }}</td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_shipping_charge'))
                            @if($shipping['status']==1)
                                <a href="{{ url('admin/shipping-charges/inactive/'.$shipping['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                            @elseif($shipping['status']==0)
                                <a href="{{ url('admin/shipping-charges/active/'.$shipping['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">InActive</span></a>
                            @endif
                            @endif

                        </td>
                        </td>
                        <td>
                        <div class="flex">
                            @if ($user && $user->hasPermissionByRole('edit_shipping_charge'))
                              <a target="" href="{{ url('admin/shipping-charges/'.$shipping['id']) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a> &nbsp;
                            @endif
                            @if ($user && $user->hasPermissionByRole('delete_shipping_charge'))
                              <a target="" href="{{ url('admin/shipping-charges/delete/'.$shipping['id']) }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Shipping ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                            @endif
                        </div>
                        </td>
                     </tr>
                  @endforeach
                  </tbody>
               </table>
               <div class=" pagination-sm">
                  {{ $shippingCharges->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
 </section>

@endsection
