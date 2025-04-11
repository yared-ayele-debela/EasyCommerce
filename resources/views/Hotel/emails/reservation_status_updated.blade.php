@php
   use App\Models\AppSetting;
   $setting= AppSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status Updated</title>
    <!-- Add Bootstrap CSS (use a CDN for simplicity) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
          .bg-success{
            background-color: #17BE18 !important;
        }
    </style>
</head>
<body style="background-color: #f4f7fa; padding: 20px;">
    <!-- Email Container -->
    <div class="container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <!-- Header Section -->
        <div class="text-center p-4  pb-2 border-bottom">
            <img src="{{ asset('/storage/appsettings/'.$setting->logo) }}" alt="Company Logo" style="max-height: 60px;">
            <h4 class="mt-2">{{ $setting->application_title }}</h4>
        </div>
        <div class="bg-success text-white text-center p-2">
          <h4 class="mb-0">Reservation Status Updated</h4>
        </div>
        <!-- Body Section -->
        <div class="p-4">
            <p class="lead">Dear {{ $reservation->user->name }},</p>

            <p>Your reservation at <strong>{{ $reservation->hotel->name }}</strong> for room <strong>{{ $reservation->room->name }}</strong> has been updated.</p>

            <p><strong>New Reservation Status:</strong> <span class="badge bg-info">{{ ucfirst($reservation->status) }}</span></p>

            <table class="table table-borderless">
                <tr>
                    <td><strong>Check-in Date:</strong></td>
                    <td>{{ $reservation->check_in_date }}</td>
                </tr>
                <tr>
                    <td><strong>Check-out Date:</strong></td>
                    <td>{{ $reservation->check_out_date }}</td>
                </tr>
                <tr>
                    <td><strong>Total Price:</strong></td>
                    <td>{{ number_format($reservation->total_price, 2) }} ETB</td>
                </tr>
            </table>
            <p>If you have any questions or need further assistance, please don't hesitate to <a href="mailto:{{ $setting->email_address }}" class="text-primary">contact us</a>.</p>
            <p>Best regards,<br><strong> {{ $setting->application_title }}</strong></p>
        </div>


    </div>

    <!-- Add Bootstrap JS (optional for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
