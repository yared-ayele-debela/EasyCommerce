@extends('admindashboard.maindashboard')
@section('dashboard')
@php
$user = Auth::guard('admin')->user();
@endphp
<div class="pagetitle bg-light">
    <nav>
        <ol class="breadcrumb p-3">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Orders
            </li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                     <div class="d-flex justify-content-between align-items-center">
                        <h4>List of Old Orders</h4>
                       <a class="btn btn-primary" href="{{ url('admin/orders') }}">Back to Orders</a>&nbsp;
                    </div>

                </div>
                <div class="card-body">
                    @if(Session::has('success_message'))
                    <div class=" col-lg-6 alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1">
                        </i>{{ Session::get('success_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                    @endif

                    <table id="example" class="table table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col"> Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Ordered Products</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $k => $order)
                            @if($order['orders_products'])
                            <tr>
                                <td>{{ $order['id']}}</td>

                                <td>
                                    {{ date('Y-m-d h:i:s',strtotime($order['created_at'])) }}
                                </td>
                                <td>{{ $order['name'] }}</td>
                                <td>{{ $order['email'] }}
                                <td>{{ $order['mobile'] }}

                                </td>
                                <td>
                                    @foreach ($order['orders_products'] as $product)
                                    {{ $product['product_name'] }} ({{ $product['product_qty'] }})
                                    @endforeach
                                </td>
                                <td>
                                    {{ $order['grand_total'] }}
                                </td>
                                <td>
                                    {{ $order['payment_method'] }}
                                </td>
                                <td>
                                    <a href=""><span style="border-radius: 0.2rem;padding-left:3px;padding-right:3px" class="btn btn-outline-success btn-sm disabled">{{$order['order_status']}}</span></a>
                                </td>
                                <td>
                                    <div class="flex">
                                        @if ($user && $user->hasPermissionByRole('view_orders_details'))
                                        <a href="{{ url('admin/orders/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn  btn-sm ml-1"><i class="ri-eye-fill"></i></a>
                                        @endif

                                        @if ($user && $user->hasPermissionByRole('view_order_invoice'))
                                        <a target="_blank" href="{{ url('admin/order/invoice/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm ml-1" data-bs-toggle="tooltip" data-bs-placement="top" title="delivery note">
                                            <i class="ri-printer-cloud-fill"></i></a>
                                        @endif

                                        @if ($user && $user->hasPermissionByRole('view_order_invoice'))
                                        <a target="_blank" href="{{ url('admin/order/invoice/pdf/'.$order['id']) }}" style="background-color:rgb(239, 239, 239) " class=" btn btn-sm ml-1" data-bs-toggle="tooltip" data-bs-placement="top" title="view good receiving note">
                                            <i class="ri-file-pdf-line ">
                                            </i>
                                        </a>
                                        @endif
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{ $order['id']}}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <div class=" pagination-sm">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        let button = $(event.relatedTarget);
        let orderId = button.data('id');
        let form = $('#deleteForm');
        form.attr('action', `/admin/orders/${orderId}`);
    });

</script>
@endsection

