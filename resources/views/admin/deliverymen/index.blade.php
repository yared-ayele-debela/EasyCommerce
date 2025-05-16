@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Delivery Boy</li>
         <li class="breadcrumb-item active">All All Delivery Boy</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body pt-3" >
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                @if ($user && $user->hasPermissionByRole('create_delivery_boy'))
                  <a class="btn btn-primary" href="{{ url('admin/delivery_boy/create')}}"><i class=" fas fa-plus"></i>Add Delivery Boys</a>
                @endif
               </ul>

               <table id=""  class="table datatable">
                <thead>
                    <tr>
                        <td>Image</td>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone</th>
                        <th>Identity Type</th>
                        <th>Identity Number</th>
                        <th>Email</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliverymen as $deliveryman)
                        <tr>
                            <td><img src="{{ $deliveryman->delivery_man_image }}" style="width: 50px; height:50px" alt=""></td>
                            <td>{{ $deliveryman->first_name }}</td>
                            <td>{{ $deliveryman->last_name }}</td>
                            <td>{{ $deliveryman->phone }}</td>
                            <td>{{ $deliveryman->identity_type }}</td>
                            <td>{{ $deliveryman->identity_number }}</td>
                            <td>{{ $deliveryman->email }}</td>
                            <td>{{ $deliveryman->salary }} ETB</td>
                            <td class=" btn-group-sm">
                                @if ($user && $user->hasPermissionByRole('edit_delivery_boy'))
                                <a href="{{ route('delivery_boy.edit', $deliveryman->id) }}" style="background-color:rgb(239, 239, 239) " class="btn btn-white btn-sm "><i class="ri-ball-pen-fill"></i></a>
                                @endif
                                @if ($user && $user->hasPermissionByRole('delete_delivery_boy'))
                                <form action="{{ route('delivery_boy.destroy', $deliveryman->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input name="_method" type="hidden" value="DELETE">

                                    <button type="submit" style="background-color:rgb(239, 239, 239) "  class="btn btn-sm confirm-button"><i class="ri-delete-bin-6-fill"></i></button>
                                </form>
                                @endif
                                @if($user && $user->hasPermissionByRole('edit_delivery_boy'))
                                <div class="popover-container">
                                     <a href="{{ url('admin/view-withdraw-detail', $deliveryman->id) }}" class="btn btn-primary btn-sm "><i class="bi bi-wallet-fill"></i></a>
                                    <div class="popover-content">
                                     View withdraw histories
                                    </div>
                                </div>

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

