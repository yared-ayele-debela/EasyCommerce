@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="javascript:void(0);">Warehouse</a></li>
                <li class="breadcrumb-item">assign warehouse</li>
            </ol>
        </nav>
    </div>
    <section class="row">
      <div class="col-md-12">
        <div class="card border-0 shadow-sm" >
            <div class="card-body mt-3">
                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#basicModal"> Assign User to Warehouse </button>
                    <div class="modal fade" id="basicModal" tabindex="-1">
                       <div class="modal-dialog">
                          <div class="modal-content">
                             <div class="modal-header">
                                <h5 class="modal-title">Assign User To Warehouse ?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                <form   action="{{ route('assign.store') }}" method="POST"  enctype="multipart/form-data" >
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pt-3">
                                                <div class="form-group">
                                                  <label for="user">User</label>
                                                  <select class="form-control" name="user_id" id="">
                                                    <option value="" selected>select one</option>
                                                    @foreach ($users as $user )
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                  </select>
                                                  @error('user_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                   @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="pt-3">
                                                <div class="form-group">
                                                  <label for="user">Warehouse</label>
                                                  <select class="form-control" name="warehouse_id" id="">
                                                    <option value="" selected>select one</option>
                                                    @foreach ($warehouses as $warehouse )
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                    @endforeach
                                                  </select>
                                                  @error('warehouse_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                   @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                             </div>
                             <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class=" btn lightblue btn-primary pt-2 pb-2 shadow" value="Assign">
                            </div>
                        </form>
                          </div>
                       </div>
                    </div>
                {{-- </h5> --}}

                   <table id="example"  class="table mt-2">
                    <thead>
                       <tr>
                          <th scope="col"> Name</th>
                          <th scope="col">Mobile </th>
                          <th scope="col">Email</th>
                          <th scope="col">Image</th>
                          <th scope="col">Warehouse Name</th>
                          <th scope="col">Address</th>
                          <th scope="col">Actions</th>
                       </tr>
                    </thead>
                    <tbody>
                        @foreach ($assigned as $as)
                        <tr>
                            <td>{{ $as->admin->name }}</td>
                            <td>{{ $as->admin->mobile }}</td>
                            <td>{{ $as->admin->email }}</td>
                            <td>
                                 @if(!empty($as->admin->image))
                                <img src="{{ asset('storage/admin/image/'.$as->admin->image) }}" style=" box-shadow:1px 1px 3px gray; border-radius:2rem;width: 40px; height:40px;" class="" alt="">
                                @else
                                <img  src="{{ asset('/storage/products/noimagefile.png') }}" style="box-shadow:1px 1px 3px gray;  border-radius:2rem; width: 40px; height:40px;" class="" alt="">
                                @endif</td>
                            <td>{{ $as->warehouse->name }}</td>
                            <td>{{ $as->warehouse->address }}</td>
                            <td>
                                <a href="{{ url('admin/delete-assigned-warehouse/'.$as['id']) }}" style="background-color:rgb(239, 239, 239) " onclick="return confirm('Are you sure,you want to delete ?') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                 </table>
            </div>
        </div>
      </div>
    </section>

@endsection
