<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-success{
            background-color: #17BE18 !important;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0" style="max-width: 500px;">
            <div class="card-header bg-success text-white text-center py-4">
                <h2 class="fw-bold">Thank You!</h2>
                <p class="mb-0">Your order has been confirmed</p>
            </div>
            <div class="card-body text-center p-4">
                <h4 class="text-dark">Hello, {{ $order->user->name }}!</h4>
                <p class="fs-5"><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p class="fs-5"><strong>Total Amount:</strong> ${{ $order->total }}</p>
                <p class="text-muted">Your receipt is attached.</p>
                <p class="fw-bold">We appreciate your business!</p>
            </div>
            <div class="card-footer text-center bg-light py-3">
                <a href="{{ url('my-orders') }}" class="btn btn-success px-4">View Order</a>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4">Continue Shopping</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
