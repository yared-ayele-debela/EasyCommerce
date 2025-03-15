<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delivery Order Notification</title>
</head>
<body>
    <table style="width:700px;">
        <tr>
            <td style="text-align: center;">
                <h1><strong>{{ $email_template->name }}</strong></h1>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <!-- You can include your company logo here -->
        <!-- <tr><td><img src="your_logo_url" alt="Company Logo"></td></tr> -->
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>Hello {{ $first_name }} {{ $last_name }},</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>We are pleased to inform you that a new custom order has been assigned to you for delivery. Please find the details of the order below:</td>
        </tr>
        <tr><td> Order ID :{{ $order_id }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table style="width:95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                    <tr bgcolor="#cccccc">
                        <th>Customer Name</th>
                        <td>Mobile Number</td>
                        <td>Status</td>
                        <td>Product Name</td>
                        <td>Quantity </td>
                        <td>Description</td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td>{{ $orderDetails['customer_name'] }}</td>
                        <td>{{ $orderDetails['phone_number'] }}</td>
                        <td>{{ $orderDetails['status'] }}</td>

                        @foreach ($orderDetails['custom_order_product'] as $product )
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ $product['description'] }}</td>

                    </tr>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table>
                    <tr><td><strong>Delivery Address:</strong></td></tr>
                    <tr><td>{{ $product['delivery_address'] }}</td></tr>
                </table>
            </td>
        </tr>
    </table>
    @endforeach

    <p>
        Please make sure to review the order details carefully. Ensure that the products are securely packed and handle the delivery with care.<br>
        Your prompt and responsible delivery service is highly valued by our customers.<br><br>

        If you encounter any issues or have questions regarding this delivery, please do not hesitate to contact our support team at 09121212112.<br><br>

        Thank you for your dedication and hard work. We appreciate your efforts in ensuring our customers receive their orders in excellent condition and on time.<br><br><br>

         Best regards,<br>
        {{ $email_template->name }} company<br>
        Address : {{ $email_template->address }} <br>
        Email :{{ $email_template->email }} <br>
        Phone :{{ $email_template->phone }} <br>
    </p>
</body>
</html>
