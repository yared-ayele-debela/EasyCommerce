@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light shadow-sm">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Currencies</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-header">
                @if ($user && $user->hasPermissionByRole('add currency'))
                    <a class="btn btn-primary" href="{{ route('add-currency') }}">Add Currency</a>
                @endif
            </div>
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table class="table mt-2" id="example">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Symbol</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Code</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_currency as $k => $currency)
                            <tr>
                                <td>{{ $currency->id }}</td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>{{ $currency->exchange_rate }}</td>
                                <td>{{ $currency->code }}</td>
                                <td>
                                 @if ($user && $user->hasPermissionByRole('edit currency'))
                                  <a href="{{ url('admin/currency/edit/'.$currency->id) }}"  style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm"><i class="ri-ball-pen-fill"></i></a>
                                 @endif
                                 @if ($user && $user->hasPermissionByRole('delete currency'))
                                  <a href="{{ url('admin/currency/delete/'.$currency->id) }}" style="background-color:hsl(0, 0%, 94%) " onclick="return confirm('Are you sure,you want to delete this currency ?? ') " class="btn  btn-sm" ><i class=" ri-delete-bin-6-fill"></i></a>
                                 @endif
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                 <div class="pagination-sm">
                    {!! $all_currency->links() !!}
                </div>
            </div>
        </div>
    </div>

</section>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {

    function updateExchangeRate() {

        $.ajax({
            url: '/admin/auto-update-exchange-rate',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response.message);
                // Update the UI or perform other actions if needed
            },
            error: function (xhr, status, error) {
                console.error('Error updating exchange rates:', error);
            }
        });
    }
    // Set interval for auto-updating every 24 hours (86400000 milliseconds)
    setInterval(updateExchangeRate, 86400000);
});
</script>
@endsection

