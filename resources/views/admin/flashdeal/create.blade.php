@extends('admindashboard.maindashboard')

@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                @if ($user && $user->hasPermissionByRole('view_flash_deal'))
                   <a class="btn btn-primary" href="{{ route('flash_deals.index') }}">All Flashdeals</a>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('flash_deals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="name">Title</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Title" id="name" name="title" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">Banner</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="file" name="banner" class="selected-files form-control">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <span class="small text-muted">This image is shown as cover banner in flash deal details page.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group  mb-3">
                                <label class="col-sm-3 control-label" for="start_date">Start Date</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control aiz-date-range" name="start_date" id="start_date" placeholder="Select Start Date" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group  mb-3">
                                <label class="col-sm-3 control-label" for="end_date">End Date</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control aiz-date-range" name="end_date" id="end_date" placeholder="Select End Date" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group  mb-3">
                                <label class="col-sm-3 control-label" for="products">Products</label>
                                <div class="col-sm-9">
                                    <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple required data-placeholder="Choose Products" data-live-search="true" data-selected-text-format="count">
                                        @foreach(\App\Models\Product::where('status',1)->orderBy('created_at', 'desc')->get() as $product)
                                            <option class="text-black" value="{{$product->id}}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select><br>
                                    <div class="alert alert-danger">
                                        If any product has discount or exists in another flash deal, the discount will be replaced by this discount & time limit.
                                      </div>
                                </div>
                            </div>

                            <br>

                            <div class="form-group" id="discount_table">

                            </div>

                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#products').on('change', function(){
            var product_ids = $('#products').val();
            if(product_ids.length > 0){
                $.post('{{ route('flash_deals.product_discount') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                    $('#discount_table').html(data);
                   AIZ.plugins.fooTable();
                });
            }
            else{
                $('#discount_table').html(null);
            }
        });
    });
</script>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#start_date", {
            enableTime: true,
            dateFormat: "d-m-Y H:i:S",
        });

        flatpickr("#end_date", {
            enableTime: true,
            dateFormat: "d-m-Y H:i:S",
        });
    });
</script>
<script>
    var AIZ = AIZ || {};
    AIZ.local = {
        nothing_selected: 'Nothing selected',
        nothing_found: 'Nothing found',
        choose_file: 'Choose file',
        file_selected: 'File selected',
        files_selected: 'Files selected',
        add_more_files: 'Add more files',
        adding_more_files: 'Adding more files',
        drop_files_here_paste_or: 'Drop files here, paste or',
        browse: 'Browse',
        upload_complete: 'Upload complete',
        upload_paused: 'Upload paused',
        resume_upload: 'Resume upload',
        pause_upload: 'Pause upload',
        retry_upload: 'Retry upload',
        cancel_upload: 'Cancel upload',
        uploading: 'Uploading',
        processing: 'Processing',
        complete: 'Complete',
        file: 'File',
        files: 'Files',
    }
</script>
