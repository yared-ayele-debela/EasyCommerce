@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
    <div class="pagetitle bg-light">
        <nav>
            <ol class="breadcrumb p-3 ">
                <li class="breadcrumb-item font-weight-bold"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Edit Cms Page</li>
            </ol>
        </nav>
    </div>
    <section class="section col-md-12" >
        <div class="card" >
            <div class="card-body pt-3">
                <h5 class="card-title">Edit Cms_Page</h5>
                <ul class="nav nav-tabs pb-4 align-items-end card-header-tabs w-100">
                    <li class="nav-item border-none">
                        <a class="nav-link active bg-light" href=""><i class=" fas fa-plus"></i>Edit Cms_Page</a>
                    </li>
                    @if ($user && $user->hasPermissionByRole('view_cmspage'))
                    <li class="nav-item">
                        <a class="nav-link " href="{{ url('admin/cms-pages')}}"><i class="fa fa-list mr-2"></i>All Cms_Pages</a>
                    </li>
                    @endif
                </ul>
                <form class=" g-3" action="{{ route('update_cms_page') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="cms_id" value="{{$cms->id}}">
                    <div class="col-md-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" value="{{$cms->title}}" class="form-control" name="title">
                        @error('title')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                     <div class="col-md-12">
                        <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                          <textarea class="form-control text-left m-0 p-0" name="description" id="description" rows="8">
                          {{ $cms->description }}
                          </textarea>
                        </div>
                        @error('description')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                     <div class="col-md-12">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description"  id="" rows="8">
                       {{ $cms->meta_description }}
                        </textarea>
                        @error('meta_description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <p class=" text-danger"> write url like this (about-us) or aboutus don't use space between words</p>
                          <label for="url" class="form-label">Url</label>

                          <input type="text" class="form-control"  name="url" value="{{$cms->url}}" pattern="^[^\s]+$" title="Please enter text without spaces or use (-) between text" required>
                          @error('url')
                          <small class=" text-danger">{{ $message }}</small>
                          @enderror
                      </div>
                    
                    <div class="col-md-12">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" value="{{$cms->meta_title}}" class="form-control" name="meta_title">
                        @error('meta_title')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="meta_keywords" class="form-label">Meta keywords</label>
                        <input type="text" value="{{$cms->meta_keywords}}" class="form-control" name="meta_keywords">
                        @error('meta_keywords')
                        <small class=" text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group pt-3 ">
                        <input type="submit" class=" btn btn-primary pt-2 pb-2 shadow" value="Update">
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
