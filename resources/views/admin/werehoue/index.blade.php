@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Warehouse</li>
         <li class="breadcrumb-item active">All Warehouses</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card shadow-sm border-0">
            <div class="card-header">
                @if ($user && $user->hasPermissionByRole('create_warehouse'))
                  <a class="btn btn-primary" href="{{ route('warehouses.create') }}"><i class=" fas fa-plus"></i>Add Warehouse</a>
                @endif
                &nbsp;
                @if ($user && $user->hasPermissionByRole('assign user to warehouse'))
                <a href="{{ url('admin/assign-warehouse') }}" class="btn-info btn">
                    <i class="bi bi-arrow-right-circle text-white"></i>
                    <span class="text-white">Assign warehouse to User</span>
                </a>
                @endif
            </div>
            <div class="card-body mt-2">
               <table id="example" class="table mt-2">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <td>State</td>
                        <td>Status</td>
                        <td>Action</td>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($allwerehouses as $k => $houses)

                     <tr>
                        <td>{{ $houses->id }}</td>
                        <td>{{ $houses->name }}</td>
                        <td>{{ $houses->address }}</td>
                        <td>{{ $houses->phone }}</td>
                        <td>{{ $houses->email }}</td>
                        <td>{{ $houses->state }}</td>
                        <td>
                            @if ($user && $user->hasPermissionByRole('edit_warehouse'))

                           @if($houses->status==1)
                                 <a href="{{ url('admin/warehouses/inactive/'.$houses->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-success btn-sm">Active</span></a>
                           @elseif ($houses->status==0)
                                 <a href="{{ url('admin/warehouses/active/'.$houses->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class="btn btn-outline-danger btn-sm">Inactive</span></a>
                            @endif
                            @endif
                        <td>

                        @if ($user && $user->hasPermissionByRole('edit_warehouse'))
                         <a href="{{ url('admin/warehouses/'.$houses->id.'/edit') }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                        @endif

                        @if ($user && $user->hasPermissionByRole('delete_warehouse'))
                        @if($houses->id=="1")
                        @else
                        <a href="{{ url('admin/warehouses/'.$houses->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this houses ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                        @endif
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
      {{-- <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="{{ route('warehouses.ssing-to-stock-caper') }}" method="POST">
                    @csrf
                    <h5 class="card-title">Assing Stock caper for Warehouse</h5>

                    <div class="form-group m-3">
                      <label for="">Stock Caper</label>
                      <select class="form-control" name="stock_caper_id" id="">
                        <option value="" selected disabled>select stock caper</option>
                        @foreach ($alladmin as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                      </select>
                      @error('stock_caper_id')
                      <small class=" text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group m-3">
                        <label for="">Warehouse</label>
                        <select class="form-control" name="warehouse_id" id="">
                        <option value="" selected disabled>select warehouse</option>
                        @foreach ($allwerehouses as $house)
                        <option  value="{{ $house->id }}">{{ $house->name }}</option>
                        @endforeach
                        </select>
                        @error('warehouse_id')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                      </div>
                      <div class="form-group m-3">
                        <button type="submit" class="btn btn-primary">Assing</button>
                      </div>
                    </form>
            </div>
        </div>

      </div> --}}
   </div>
 </section>

@endsection
