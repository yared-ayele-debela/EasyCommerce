<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
</head>
<body>
    <table style="width:700px;">
        <tr>
            <td style="text-align: center;">
                <h1><strong>BYT Developers</strong></h1>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <!-- You can include your company logo here -->
        <!-- <tr><td><img src="your_logo_url" alt="Company Logo"></td></tr> -->
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>Hello {{ $name }}</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>Your order has been received and is being processed. Please find the details of your order below:</td>
        </tr>
        <tr><td>Your Order #{{ $order_id }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table style="width:95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                        <tr bgcolor="#cccccc">
                            <td>User Code</td>
                            <td>Mobile Number</td>
                            <td>Product Name</td>
                            <td>Quantity </td>
                            <td>Description</td>
                            <td>Status</td>
                        </tr>
                        <tr bgcolor="#f9f9f9">
                            <td><b>{{ $orderDetails['user_code'] }}</b></td>
                            <td>{{ $orderDetails['phone_number'] }}</td>
                            <td>{{ $orderDetails['product_name'] }}</td>
                            <td>{{ $orderDetails['quantity'] }}</td>
                            <td>{{ $orderDetails['description'] }}</td>
                            <td>{{ $orderDetails['status'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table>
                    <tr><td><strong>Delivery Address:</strong></td></tr>
                    <tr><td>{{ $orderDetails['delivery_address'] }}</td></tr>

                </table>
            </td>
        </tr>
    </table>
    <p>
        Thank you for shopping with BYT Developers. Your order is now being processed and will be dispatched soon. You will receive another email with the tracking details once your order is shipped.<br><br>

        If you have any questions or concerns about your order, please feel free to contact our customer support team at 09121212112.<br><br>

        We appreciate your business!<br><br><br>

        Best regards,<br>
        BYT Company<br>
        Adama, 04<br>
        byt@gmail.com<br>
        +2519134343<br>
    </p>
</body>
</html>
