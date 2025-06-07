@php
use App\Models\AppSetting;
$settings = AppSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>Reservation Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0px auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .header {
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
            background-color: #17BE18;
            color: #fff;
        }

        .service-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .total {
            text-align: left;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 10px;
        }
        .totals {
            text-align: left;
            font-size: 0.9rem;
            font-weight: bold;
            margin-top: 5px;
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
        .custom-btn{
            background-color:#17BE18;
            color: white;
        }

    </style>
</head>
<body>

    <div class="container bg-light shadow-none ">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="container" id="receipt">
            <div class="header d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ url('/') }}">
                        <img src="{{ $settings->logo }}" alt="{{ $settings->application_title }}" style="max-height: 60px;">
                    </a>
                    <h6 class="text-dark">{{ $settings->application_title }}</h6>
                </div>
                <div>
                    <h4>Hotel Reservation Receipt  <button class="btn custom-btn btn-sm" onclick="printReceipt()"><i class="bi bi-printer-fill"></i></button></h4>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <h4 class="section-title"> <img src="{{ asset('restaurant_frontend/reserve.png') }}" width="20" alt=""> Reservation Info</h4>
                    <p><strong>Reservation ID:</strong> #{{ $reservation->id }}</p>
                    <p><strong>Customer Name:</strong> {{ $reservation->user->name }}</p>
                    <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
                    <p><strong>Reservation Date:</strong> {{ $reservation->created_at->format('F d, Y') }}</p>
                    <p><strong>Check in Date:</strong> {{ $reservation->check_in_date }}</p>
                    <p><strong>Check out Date:</strong> {{ $reservation->check_out_date }}</p>
                    <p><strong>Reserved days:</strong> {{ $reservation->total_night }}</p>
                    @if($reservation->total_adult > 0)
                    <p><strong>Total Adults:</strong> {{ $reservation->total_adult }}</p>
                    @endif
                    @if($reservation->total_child > 0)
                    <p><strong>Total Childern:</strong> {{ $reservation->total_child }}</p>
                    @endif
                    @if($reservation->total_infant > 0)
                    <p><strong>Total Infants:</strong> {{ $reservation->total_infant }}</p>
                    @endif
                    <p><strong>Status:</strong> {{ $reservation->status }}</p>
                </div>

                <div class="info-box">
                    <h4 class="section-title"><i class="bi bi-pin-map-fill"></i> Customer Address</h4>
                    <p><strong>Address:</strong> {{ $reservation->user->address ?? '-' }}</p>
                    <p><strong>City:</strong> {{ $reservation->user->city ?? '-' }}</p>
                    <p><strong>State:</strong> {{ $reservation->user->state ?? '-' }}</p>
                    <p><strong>Country:</strong> {{ $reservation->user->country ?? '-' }}</p>
                    <p><strong>Pincode:</strong> {{ $reservation->user->pincode ?? '-' }}</p>
                </div>
                <div class="info-box">
                    <h4 class="section-title"><img src="{{ asset('restaurant_frontend/hotel.png') }}" width="20" alt=""> Hotel Information</h4>
                    <p><strong>Hotel Name :</strong> {{ $reservation->hotel->name }}</p>
                    <p><strong>Hotel Phone Number :</strong> {{ $reservation->hotel->phone }}</p>
                    <p><strong>Category :</strong> {{ $reservation->hotel->category->name }}</p>
                    <p><strong>Address :</strong> {{ $reservation->hotel->location }}</p>
                    <p><strong>Price per Night :</strong> {{ $reservation->hotel->price_per_night }} ETB</p>
                </div>
                <div class="info-box">
                    <h4 class="section-title"><img src="{{ asset('restaurant_frontend/double-bed.png') }}" width="20" alt=""> Room Information</h4>
                    <p><strong>Room Type :</strong> {{ $reservation->room->room_type }}</p>
                    <p><strong>Capacity :</strong> {{ $reservation->room->capacity }}</p>
                    <p><strong>Room Price :</strong> {{ $reservation->room->price }} ETB</p>
                </div>
            </div>
            <hr>
            <p class="totals">Final Price: {{ number_format($reservation->total_price, 2) }} ETB</p>
            <p class="totals">Discount Amount: {{ number_format($reservation->discount_amount, 2) }} ETB</p>
            <hr>
            <p class="total">Total: {{ number_format($reservation->final_price, 2) }} ETB</p>
            <p class="date"><small class="font-italic float-right">Date: {{ $reservation->created_at->format('F d, Y') }}</small></p>
            <div class="mt-4">
                <p>If you have any questions or need further assistance, please don't hesitate to <a href="{{ $settings->email_address }}" class="text-primary">{{ $settings->email_address }}</a>.</p>
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
