@extends('admindashboard.maindashboard')
@section('dashboard')
  <div class="pagetitle  bg-light">
     <nav>
        <ol class="breadcrumb p-3 ">
           <li class="breadcrumb-item font-weight-bold"><a href="{{ url('admin/dashboard') }}">Home</a></li>
           <li class="breadcrumb-item">Add Section</li>
        </ol>
     </nav>
  </div>
  <section class="section">
     <div class="row">
        <div class="col-lg-6">
           <div class="card rounded">
              <div class="card-body">
                 <h5 class="card-title" style="font-weight: bold; font-size:27px;"> Add Section</h5>
                 <ul class="nav pb-5 nav-tabs align-items-end card-header-tabs w-100">
                  <li class="nav-item">
                    <a class="nav-link active" href=""><i class="fa fa-list mr-2"></i>Add Section</a>
                  </li>
                    <li class="nav-item border-none">
                    <a class="nav-link bg-light " href="{{ route('all_sections') }}"><i class=" fas fa-plus"></i>All Sections</a>
                  </li>
                 </ul>
                 {{-- @if($errors->any())
                 {{-- <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                       <div>{{ $error }}</div>
                    @endforeach
                 </div> --}}

                 {{-- @endif --}}
                 <form method="POST" action="{{ url('admin/store') }}" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-8 ">
                       <label for="name" class="form-label">Section Name</label>
                        <input type="text" name="name" class="form-control" >
                        @error('name')
                            <small class=" text-danger">{{ $message }}</small><br>
                        @enderror
                    </div>
                    <div class=" pb-3 col-md-6  custom-control custom-checkbox pt-2">
                    <label class="custom-control-label" for="status">Status</label><br>
                    <input type="checkbox" class="custom-control-input form-control" id="status" style="width:25px; height:25px" name="status">
                    </div>
                    <div class="col-md-8 pb-3 pr-3 ">
                    <button type="submit" class=" col-md-4 btn btn-primary pr-5 pt-2 shadow pb-2">Save</button>
                    </div>
                   </form>
              </div>
           </div>
  </section>
@endsection
