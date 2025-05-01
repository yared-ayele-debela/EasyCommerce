@php
use App\Models\AppSetting;
$settings = AppSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }

        .header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 120px;
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

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
            text-align: center;
        }

        th {
            background-color: #17BE18;
            color: #fff;
        }

        .total {
            font-size: 0.7rem;
            font-weight: bold;
            text-align: right;
            margin-top: 8px;
        }

        .date {
            text-align: right;
        }

        .custom-btn {
            background-color: #17BE18;
            color: white;
        }

        @media(max-width: 600px) {
            .info-grid {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div id="receipt">
            <div class="header d-flex justify-content-between align-items-center">
                <div>
                    <img src="{{ $settings->logo }}" alt="Logo" class="logo">
                    <h6 class="text-dark">{{ $settings->application_title }}</h6>
                </div>
                <div>
                    <h4>Order Receipt <button class="btn custom-btn btn-sm" onclick="printReceipt()"><i class="bi bi-printer-fill"></i></button></h4>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <h4 class="section-title"><i class="bi bi-cart-fill"></i> Order Info</h4>
                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                </div>

                <div class="info-box">
                    <h4 class="section-title"><i class="bi bi-person-fill"></i> Customer Info</h4>
                    <p><strong>Name:</strong> {{ $order ->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->mobile}}</p>
                    <p><strong>Address:</strong> {{ $order->address }}</p>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orders_products as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->product_qty }}</td>
                        <td>{{ number_format($item->product_price, 2) }} ETB</td>
                        <td>{{ number_format($item->product_price * $item->product_qty, 2) }} ETB</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <p class="total">Discount: {{ number_format($order->coupon_amount, 2) }} ETB</p>
            <p class="total">Shipping: {{ number_format($order->shipping_charges, 2) }} ETB</p>
            <hr>
            <h4 class="total">Total: {{ number_format($order->grand_total, 2) }} ETB</h4>
            <p class="date"><small>Date: {{ $order->created_at->format('F d, Y') }}</small></p>
            <div class="mt-4">
                <p>If you have any questions, please contact us at <a href="mailto:{{ $settings->email_address }}" class="text-primary">{{ $settings->email_address }}</a>.</p>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            var printContents = document.getElementById("receipt").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

    </script>

</body>
</html>

