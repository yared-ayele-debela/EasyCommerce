<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .logo {
            max-width: 120px;
        }
        .order-info {
            margin-top: 20px;
            padding: 15px;
            background: #f7f7f7;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #17BE18;
            color: #fff;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Company Logo" class="logo">
            <h2>Order Receipt</h2>
        </div>
        <div class="order-info">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
        </div>

        <table>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            @foreach ($order->orderItems as $item)
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $item->product->image) }}" class="product-img" alt="Product">
                </td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
            </tr>
            @endforeach
        </table>
        <p class="total">Total: ${{ number_format($order->total, 2) }}</p>
    </div>
</body>
</html>
