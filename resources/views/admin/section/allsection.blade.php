@extends('admindashboard.maindashboard')
@section('dashboard')
<div class="pagetitle bg-light">
   <nav>
      <ol class="breadcrumb p-3">
         <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
         <li class="breadcrumb-item">Section</li>
         <li class="breadcrumb-item active">All Sections</li>
      </ol>
   </nav>
 </div>
 <section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Section Data</h5>
               <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                <li class="nav-item">
                  <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>All Sections</a>
                </li>
                  <li class="nav-item border-none">
                  <a class="nav-link bg-light" href="{{ route('add_section')}}"><i class=" fas fa-plus"></i>Add Section</a>
                </li>
               </ul>

               <table id="example" class="table datatable">
                  <thead>
                     <tr>
                        <th scope="col">Section ID</th>
                        <th scope="col">Name</th>

                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($allsection as $k => $section)
                     <tr>

                        <td>{{ $section->id }}</td>
                        <td>{{ $section->name }}</td>
                        <td>
                        @if($section->status==1)
                              <a href="{{ url('admin/inactive/section/'.$section->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class=" bg-danger text-white    active-btn">Inactive</span></a>
                        @elseif ($section->status==0)
                              <a href="{{ url('admin/active/section/'.$section->id) }}"><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px"  class=" bg-success  text-white    active-btn">Active</span></a>
                         @endif
                        </td>
                        <td>
                         <a href="{{ url('admin/section/'.$section->id.'/edit')}}" class=" btn btn-warning btn-sm">Edit</a>
                         <a href="{{ url('admin/section/delete/'.$section->id) }}" onclick="return confirm('Are you sure,you want to delete this Slider ?? ') " class="btn btn-danger btn-sm" >Delete</a>
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
