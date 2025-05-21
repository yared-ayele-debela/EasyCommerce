@php
use App\Models\AppSetting;
$setting = AppSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-success {
            background-color: #17BE18 !important;
        }

        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

    </style>
</head>
<body>
    <div class="container" style="max-width: 700px; margin: 0 auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div class="text-center p-4 pb-2 border-bottom">
            <img src="{{ $setting->logo }}" alt="Company Logo" style="max-height: 60px;">
            <h4 class="mt-2">{{ $setting->application_title }}</h4>
        </div>
        <div class="bg-success text-white text-center p-2">
            <h4 class="mb-0">Reservation Confirmation</h4>
        </div>
        <div class="p-4">
            <p class="lead">Dear {{ $reservation->user->name }},</p>
            <p>Your reservation at <strong>{{ $reservation->hotel->name }}</strong> for room <strong>{{ $reservation->room->name }}</strong> has been confirmed.</p>
            <table class="table table-borderless">
                <tr>
                    <td><strong>Reservation ID:</strong></td>
                    <td>{{ $reservation->id }}</td>
                </tr>
                <tr>
                    <td><strong>Check-in Date:</strong></td>
                    <td>{{ $reservation->check_in_date }}</td>
                </tr>
                <tr>
                    <td><strong>Check-out Date:</strong></td>
                    <td>{{ $reservation->check_out_date }}</td>
                </tr>
                <tr>
                    <td><strong>Total Nights:</strong></td>
                    <td>{{ $reservation->total_night }}</td>
                </tr>
                <tr>
                    <td><strong>Total Adults:</strong></td>
                    <td>{{ $reservation->total_adult }}</td>
                </tr>
                <tr>
                    <td><strong>Total Children:</strong></td>
                    <td>{{ $reservation->total_child }}</td>
                </tr>
                <tr>
                    <td><strong>Total Infants:</strong></td>
                    <td>{{ $reservation->total_infant }}</td>
                </tr>
                <tr>
                    <td><strong>Total Price:</strong></td>
                    <td>{{ number_format($reservation->total_price, 2) }} ETB</td>
                </tr>
                <tr>
                    <td><strong>Discount:</strong></td>
                    <td>{{ number_format($reservation->discount_amount, 2) }} ETB</td>
                </tr>
                <tr>
                    <td><strong>Final Price:</strong></td>
                    <td><strong>{{ number_format($reservation->final_price, 2) }} ETB</strong></td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td><span class="badge bg-success">{{ ucfirst($reservation->status) }}</span></td>
                </tr>
                <tr>
                    <td><strong>Payment Status:</strong></td>
                    <td><span class="badge bg-info">{{ ucfirst($reservation->payment_status) }}</span></td>
                </tr>
                <tr>
                    <td><strong>Created At:</strong></td>
                    <td>{{ $reservation->created_at }}</td>
                </tr>
            </table>

            <p>If you have any questions or need further assistance, please don't hesitate to <a href="{{ $setting->email_address }}" class="text-primary">{{ $setting->email_address }}</a>.</p>
            <p>Best regards,<br><strong>{{ $setting->application_title }}</strong></p>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
