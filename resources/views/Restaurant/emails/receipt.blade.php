@php
use App\Models\AppSetting;
$setting = AppSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .header {
            /* text-align: center; */
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 18px;
            margin: 20px 0 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .info-box {
            flex: 1 1 300px;
            background: #f7f7f7;
            padding: 15px;
            border-radius: 6px;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info-box strong {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 14px;
            text-align: center;
        }

        th {
            background-color: #055935;
            color: #fff;
        }

        .product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .total {
            text-align: left;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
        }

        .date {
            text-align: right !important;
        }

        @media(max-width: 600px) {
            .info-grid {
                flex-direction: column;
            }

            .logo {
                max-width: 100px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header d-flex justify-content-between align-items-center">
            <div>
                <div class="text-center p-4 pb-2 border-bottom">
                    <img src="{{ $setting->logo }}" alt="Company Logo" style="max-height: 60px;">
                    <h4 class="mt-2">{{ $setting->application_title }}</h4>
                </div>
            </div>
            <div>
                <h2>Order Receipt</h2>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h4 class="section-title">Order Info</h4>
                <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                <p><strong>Order Status:</strong> {{ $order->status }}</p>
                <p><strong>Delivery Status:</strong> {{ $order->delivery_status }}</p>
                <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
            </div>

            <div class="info-box">
                <h4 class="section-title">📬 Delivery Address</h4>
                <p><strong>Address:</strong> {{ $order->address ?? '-' }}</p>
                <p><strong>City:</strong> {{ $order->city ?? '-' }}</p>
                <p><strong>Sub City:</strong> {{ $order->sub_city ?? '-' }}</p>
                <p><strong>Street:</strong> {{ $order->street ?? '-' }}</p>
                <p><strong>State:</strong> {{ $order->state ?? '-' }}</p>
                <p><strong>Country:</strong> {{ $order->country ?? '-' }}</p>
                <p><strong>Pincode:</strong> {{ $order->pincode ?? '-' }}</p>
            </div>
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                <tr>
                    <td>
                        <img src="{{$item->product->image }}" class="product-img" alt="Product">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Subtotal: </strong>{{ number_format($order->subtotal, 2) }} ETB</p>
        <p><strong>Discount: </strong>{{ number_format($order->discount, 2) }} ETB</p>
        <p><strong>Delivery Fee: </strong>{{ number_format($order->delivery_fee, 2) }} ETB</p>
        <hr>
        <p class="total">Total: {{ number_format($order->total, 2) }} ETB</p>
        <p class="date"><small class="font-italic float-right">Date : {{ $order->created_at->format('F d, Y')  }}</small></p>
    </div>
</body>
</html>

