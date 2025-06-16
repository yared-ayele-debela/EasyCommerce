@extends('delivery_man.admin_dashboard.maindashboard')
@section('delivery_man_dashboard')
@php
$user = Auth::guard('deliverymen')->user();
use App\Models\DeliveryNotification;
$notifications_histories=DeliveryNotification::where('delivery_man_id',Auth::guard('deliverymen')->user()->id)->latest()->paginate(5);
@endphp
<div class="container">
    <nav class="breadcrumb bg-white shadow-sm py-3 px-4 rounded d-flex justify-content-between align-items-center">
        <button class="btn btn-outline-primary btn-sm d-flex align-items-center" onclick="history.back()">
            <i class="bi bi-arrow-left mr-2"></i> &nbsp;
            <span>Back</span>
        </button>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('delivery-boy/dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-custom-primary text-white">
            <h5 class="mb-0">🔔 New Notifications ({{ $notifications->count() }})</h5>
        </div>
        <div class="card-body">
            @forelse($notifications as $note)
            <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                <div>New order <strong>#{{ $note->order->id }}</strong> assigned to you</div>
                <form action="{{ route('delivery.markNotificationSeen', $note->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-success btn-sm">Mark as Seen</button>
                </form>
            </div>
            @empty
            <div class="alert alert-info my-2">No new notifications.</div>
            @endforelse
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
            <h5>📦 Assigned Orders</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-2">
                <table class="table table-responsive table-striped table-hover align-middle">
                    <thead class="table-dark sticky-top">
                        <tr>
                            <th>#</th>
                            <th>Order Info</th>
                            <th>Customer Info</th>
                            <th>Status</th>
                            <th>Order Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>Order #{{ $order->id }}</strong><br>
                                {{ $order->payment_method }} | <span class="text-muted">{{ $order->total }} ETB</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modelId{{ $order->id }}">
                                    <i class="bi bi-eye-fill"></i> View Detail
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="modelId{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Customer information</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                                                <p><strong>Phone Number:</strong> {{ $order->user->mobile }}</p>
                                                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                                <p><strong>Address:</strong> {{ $order->address??'' }}</p>
                                                <p><strong>City:</strong> {{ $order->city??'' }}</p>
                                                <p><strong>Sub City:</strong> {{ $order->sub_city??'' }}</p>
                                                <p><strong>Street:</strong> {{ $order->street??'' }}</p>
                                                <p><strong>State:</strong> {{ $order->state??'' }}</p>
                                                <p><strong>Country:</strong> {{ $order->country??'' }}</p>
                                                <p><strong>Pincode:</strong> {{ $order->pincode??'' }}</p>
                                                 <a href="{{ url('delivery-boy/get-customer-location/'.$order->id) }}" class="btn btn-primary">Get Customer Location</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                               Order Status: <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span><br>
                               Delivery Status: <span class="badge bg-info">{{ ucfirst($order->delivery_status) }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#orderDetail{{ $order->id }}">
                                    <i class="bi bi-eye-fill"></i> View Detail
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Item and Restaurant Detail</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-4">
                                                    @foreach ($order->orderItems as $item)
                                                    <div class="col-md-6">
                                                        <div class="card h-100 shadow-sm border border-1">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img src="{{ $item->product->image }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                                    <div>
                                                                        <h5 class="card-title mb-0">{{ $item->product->name }}</h5>
                                                                        <small class="text-muted">{{ $item->quantity }} x {{ number_format($item->product->price, 2) }} ETB</small>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <h6 class="text-dark">Restaurant Info</h6>
                                                                <p class="mb-1"><strong>{{ $item->product->restaurant->name }}</strong></p>
                                                                <p class="mb-1 text-muted">{{ $item->product->restaurant->email }} | {{ $item->product->restaurant->phone }}</p>
                                                                <p class="mb-1">Address: {{ $item->product->restaurant->address }}</p>
                                                                <div class="d-flex gap-2 mt-2">
                                                                    <img src="{{ $item->product->restaurant->logo }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                                    <img src="{{ $item->product->restaurant->cover }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                                                </div>
                                                                <hr>
                                                                <a href="{{ url('delivery-boy/pickup-order/'.$order->id.'/'.$item->product->restaurant->id) }}" class="btn btn-primary">Get Restaurant Location</a>
                                                                <p class="mt-3">
                                                                   <strong>Pickup Status: </strong> <div class="btn btn-sm btn-primary">
                                                                    {{ $item->picked_status }}
                                                                   </div>
                                                                </p>
                                                                @if($item->picked_status!=="picked")
                                                                <form action="{{ route('delivery.pickup.confirm') }}" method="POST" class="">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="picked_code" class="form-label">Enter or Scan Pickup Code</label>
                                                                        <input type="text" name="picked_code" id="picked_code" class="form-control" placeholder="e.g. ABC123" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary w-100"> <i class="bi bi-fingerprint"></i> Confirm Pickup</button>
                                                                    <hr>
                                                                     <h6 class="mb-3">Or Scan Vendor QR Code</h6>
                                                                    <div class="border rounded p-2 mb-3">
                                                                        <div id="vendor-reader-{{ $order->id }}" style="width: 100%; max-width: 300px;"></div>
                                                                    </div>
                                                                    <form method="POST" action="{{ route('delivery.markDelivered', $order->id) }}" id="vendor-confirm-form-{{ $order->id }}">
                                                                        @csrf
                                                                        <input type="hidden" name="code" id="vendor-scanned_code_{{ $order->id }}">
                                                                    </form>
                                                                </form>
                                                                @endif
                                                                <hr>
                                                                 <p class="text-muted">Delivery Zone <b>{{  $item->product->restaurant->zone }}</b></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($order->delivery_status === "delivering")
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#orderModal{{ $order->id }}">
                                    <i class="bi bi-qr-code-scan"></i> Confirm Delivery
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $order->id }}">Confirm Delivery</h5>
                                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Confirm Delivery</h5>
                                                        <p class="text-muted">Enter the unique code provided by the customer to mark the order as delivered.</p>

                                                        <form action="{{ route('delivery.markDelivered', $order->id) }}" method="POST" class="mb-4">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="code" class="form-label">Customer Delivery Code</label>
                                                                <input type="text" class="form-control" name="code" id="code" placeholder="e.g. AB12CD" required>
                                                            </div>
                                                            <button class="btn btn-success">Confirm Delivery</button>
                                                        </form>

                                                        <hr class="my-4">

                                                        <h6 class="mb-3">Or Scan Customer's QR Code</h6>
                                                        <div class="border rounded p-2 mb-3">
                                                            <div id="reader-{{ $order->id }}" style="width: 100%; max-width: 300px;"></div>
                                                        </div>
                                                        <form method="POST" action="{{ route('delivery.markDelivered', $order->id) }}" id="confirm-form-{{ $order->id }}">
                                                            @csrf
                                                            <input type="hidden" name="code" id="scanned_code_{{ $order->id }}">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-success" role="alert">
                                    This order has already been <strong>marked as {{ $order->delivery_status }}</strong>.
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
               <div>
                {{ $orders->links() }}
            </div>
            <h5 class="text-muted mt-4">📜 Notification History</h5>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications_histories as $notification)
                    <tr>
                        <td>#{{ $notification->order->id }}</td>
                        <td>
                            {{ $notification->order->total }} ETB
                            <br>
                            {{ $notification->order->delivery_fee }} ETB (Delivery)
                        </td>
                        <td>
                            <span class="badge bg-{{ $notification->status == 'accepted' ? 'success' : ($notification->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($notification->status) }}
                            </span>
                        </td>
                        <td>{{ $notification->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          <div>
            {{ $notifications_histories->links() }}
          </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        let scanners = {};
        $('.modal').on('shown.bs.modal', function() {
            const modalId = $(this).attr('id'); // e.g., orderModal123
            const orderId = modalId.replace("orderModal", "");
            const readerId = "reader-" + orderId;
            const formId = "confirm-form-" + orderId;
            const inputId = "scanned_code_" + orderId;

            if (!scanners[readerId]) {
                const html5QrCode = new Html5Qrcode(readerId);
                scanners[readerId] = html5QrCode;

                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10
                        , qrbox: 250
                    }
                    , function(decodedText, decodedResult) {
                        document.getElementById(inputId).value = decodedText;
                        document.getElementById(formId).submit();
                    }
                    , function(errorMessage) {
                        console.warn(errorMessage);
                    }
                );
            }
        });

        $('.modal').on('hidden.bs.modal', function() {
            const modalId = $(this).attr('id');
            const orderId = modalId.replace("orderModal", "");
            const readerId = "reader-" + orderId;

            if (scanners[readerId]) {
                scanners[readerId].stop().then(() => {
                    scanners[readerId].clear();
                    delete scanners[readerId];
                }).catch(err => {
                    console.error("Failed to stop scanner:", err);
                });
            }
        });
    });

</script>


@endsection

