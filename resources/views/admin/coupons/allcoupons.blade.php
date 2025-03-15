@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Coupon</li>
         <li class="breadcrumb-item active">All Coupons</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card shadow-sm border-0">
            <div class="card-body">
               @if(Session::has('success_message'))
                <div class=" col-lg-6 alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1">
                    </i>{{ Session::get('success_message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
               @endif
                @if ($user && $user->hasPermissionByRole('create_coupon'))
                  <a class="btn btn-primary mt-3 mb-3" href="{{ url('admin/coupons/add-edit') }}"><i class=" fas fa-plus"></i>Add Coupon</a>
                @endif
               <table id="example"  class="table mt-2">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Coupon Code</th>
                        <th scope="col">Coupon Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($coupons as $k => $coupon)

                     <tr>
                        <td>{{ $coupon['id']}}</td>
                        <td>{{ $coupon['coupon_code'] }}</td>
                        <td>{{ $coupon['coupon_type'] }}</td>
                        <td>{{ $coupon['amount'] }}
                            @if($coupon['amount']=='Percentage')
                            %
                            @else
                            Birr
                            @endif
                        </td>
                        <td>{{ $coupon['expiry_date'] }}</td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_coupon'))
                            @if($coupon['status']==1)
                                    <a href="{{ url('admin/coupons/inactive/'.$coupon['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                            @elseif ($coupon['status']==0)
                                    <a href="{{ url('admin/coupons/active/'.$coupon['id']) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                            @endif
                           </td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_coupon'))
                            <a href="{{ url('admin/coupons/add-edit/'.$coupon['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                            @endif

                            @if ($user && $user->hasPermissionByRole('delete_coupon'))
                            <a href="{{ url('admin/coupons/'.$coupon['id'].'/delete') }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete this Coupons ?? ') " class="btn  btn-sm" ><i class="ri-delete-bin-6-fill"></i></a>
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
