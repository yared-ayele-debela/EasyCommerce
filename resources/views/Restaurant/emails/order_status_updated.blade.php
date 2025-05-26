@php
   use App\Models\AppSetting;
   $setting = AppSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Updated</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
        }
        .card-header {
            background-color: #055935;
            color: white;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #055935;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0" style="max-width: 600px;">
            <div class="text-center p-4 pb-2 border-bottom">
                <img src="{{ $setting->logo }}" alt="Company Logo" style="max-height: 60px;">
                <h4 class="mt-2">{{ $setting->application_title }}</h4>
            </div>
            <div class="card-header">
                <h4 class="pt-3">Order Status Updated</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-4">Your order #{{ $order->id }} has been updated!</h5>
                <p><strong>Status:</strong> <span class="badge bg-info">{{ $order->status }}</span></p>
                <p class="mt-3">Your order is now <strong>{{ $order->status }}</strong>. You can track your order or contact us for more information.</p>
                <p class="mt-3">Your order Delivery status <strong>{{ $order->delivery_status }}</strong>. You can track your order or contact us for more information.</p>
                <p class="mt-4">Thank you for your order!</p>
                <p>If you have any questions, please don't hesitate to reach out.</p>
                <div class="mt-4">
                    <a href="{{ url('restaurant/order/'.$order->id.'/track') }}" class="btn btn-custom px-4 py-2 mb-2">Track Your Order</a>
                    <a href="{{ url('/contact') }}" class="btn btn-outline-secondary px-4 py-2 ms-2 mb-2">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
