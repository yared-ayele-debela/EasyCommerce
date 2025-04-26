@php
   use App\Models\AppSetting;
   $setting = AppSetting::first();
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; margin: 0; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <tr style="background-color: #17BE18;">
            <td style="padding: 20px; text-align: center;">
                <img src="{{ asset('/storage/appsettings/'.$setting->logo) }}" alt="Company Logo" style="max-width: 100px;">
                <h4 style="color: white !important;margin:7px !important;">{{ $setting->application_title }}</h4>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <h2 style="color: #333;">Thank you for your order, {{ $order['name'] }}!</h2>
                <p style="color: #555;">Your order <strong>#{{ $order['order_code'] }}</strong> has been placed successfully.</p>
                <h3 style="color: #17BE18;">Order Summary:</h3>
                <ul style="color: #555; padding-left: 20px;">
                    @foreach ($order['orders_products'] as $product)
                        <li style="margin-bottom: 8px;">
                            {{ $product['product_name'] }} - Size: {{ $product['product_size'] }} - Qty: {{ $product['product_qty'] }} -
                            Price: {{ number_format($product['product_price'], 2)  }} ETB
                        </li>
                    @endforeach
                </ul>

                <p style="color: #333;"><strong>Grand Total:</strong> {{ number_format($order['grand_total'], 2) }} ETB</p>

                <p style="color: #555;">We will notify you once your order is shipped. Thank you for shopping with us!</p>

                <p style="margin-top: 30px; color: #17BE18;"><strong>Need Help?</strong></p>
                <p style="color: #555;">Contact us at: <a href="mailto:{{ $setting->email_address }}" style="color: #17BE18;">{{ $setting->email_address }}</a> or call us at <a href="tel:{{ $setting->phone_no }}" style="color: #17BE18;">{{ $setting->phone_no }}</a></p>
            </td>
        </tr>

        <tr style="background-color: #f0f0f0;">
            <td style="text-align: center; padding: 20px; font-size: 12px; color: #999;">
                &copy; {{ date('Y') }} {{ $setting->application_title }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
