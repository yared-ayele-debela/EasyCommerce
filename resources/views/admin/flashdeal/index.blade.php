@extends('admindashboard.maindashboard')

@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">FlashDeals</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    @if ($user && $user->hasPermissionByRole('add_flashdeal'))
                            <a class="btn btn-sm btn-primary" href="{{ route('flash_deals.create') }}">
                                Add new FlashDeals
                            </a>
                        @endif
                </div>
                <div class="card-body">
                    <table id=""  class="table datatable">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Banner</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Page Link</th>
                             <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($flash_deals as $key => $flash_deal)
                            <tr>
                                <td>{{ ($key+1) + ($flash_deals->currentPage() - 1)*$flash_deals->perPage() }}</td>
                                <td>{{ $flash_deal->title }}</td>
                                <td><img src="{{ $flash_deal['banner'] }}" width="100px;" alt="banner" class="h-50px"></td>
                                <td>{{ $flash_deal->start_date}}</td>
                                <td>{{$flash_deal->end_date }}</td>
                                <td>
                                   @if ($user && $user->hasPermissionByRole('edit_flashdeal'))
                                   @if($flash_deal->status==1)
                                     <a href="{{ url('admin/flash_deals/status/inactive/'.$flash_deal->id) }}" class="btn btn-success btn-sm">Active</a>
                                   @else
                                     <a href="{{ url('admin/flash_deals/status/active/'.$flash_deal->id) }}" class="btn btn-danger btn-sm">inActive</a>
                                   @endif
                                   @endif

                                </td>
                                <td>
                                    @if ($user && $user->hasPermissionByRole('edit_flashdeal'))
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input
                                            onchange="update_flash_deal_feature(this)"
                                            value="{{ $flash_deal->id }}" type="checkbox"
                                            <?php if($flash_deal->featured == 1) echo "checked";?>
                                        >
                                        <span class="slider round"></span>
                                    </label>
                                    @endif
                                </td>
                                <td>{{ url('flash-deal/'.$flash_deal->slug) }}</td>
                                <td class="text-right">
                                @if ($user && $user->hasPermissionByRole('edit_flashdeal'))
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('flash_deals.edited', ['id'=>$flash_deal->id] )}}" title="Edit">
                                        <i class="ri-ball-pen-fill"></i>
                                    </a>
                                @endif

                                @if ($user && $user->hasPermissionByRole('delete_flashdeal'))
                                    <a href="{{route('flash_deals.destroys', $flash_deal->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete broder-1" title="Delete">
                                        <i class="ri-delete-bin-6-fill"></i>
                                    </a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class=" pagination-sm">
                    </div>
                    {{ $flash_deals->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script type="text/javascript">

        function update_flash_deal_feature(el){
            if(el.checked){
                var featured = 1;
            }
            else{
                var featured = 0;
            }
            $.post('{{ route('flash_deals.update_featured') }}', {_token:'{{ csrf_token() }}', id:el.value, featured:featured}, function(data){
                if(data == 1){
                    location.reload();
                }
                else{
                    alert("Something went wrong");
                    // AIZ.plugins.notify('danger', 'Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
