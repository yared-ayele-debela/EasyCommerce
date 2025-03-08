{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<tr>
    <td style="text-align: center;">
        <h1><strong>{{ $email_template->name }}</strong></h1>
    </td>
</tr>
<tr><td>Dear {{ $userDetails['name'] }}</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Your return request for Order no. <strong>{{$returnDetails['order_id']}} </strong> with  {{ $email_template->name }} is <strong> {{$returnDetails['return_status']}} </strong></td></tr>
<tr></tr><br>
<tr><td>Best regards,</td></tr><br>
<tr><td>{{ $email_template->name }} company</td></tr><br>
<tr><td>Address : {{ $email_template->address }} </td></tr><br>
<tr><td>Email :{{ $email_template->email }} </td></tr><br>
<tr><td>Phone :{{ $email_template->phone }} </td></tr><br>
<br>

</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Template</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Additional Styles */
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-8">
                <div class="text-center">
                    <h1><strong>{{ $email_template->name }}</strong></h1>
                </div>
                <p>Dear {{ $userDetails['name'] }},</p>
                <p>Your return request for Order no. <strong>{{$returnDetails['order_id']}}</strong> with {{ $email_template->name }} is <strong>{{$returnDetails['return_status']}}</strong></p>
                <p>Best regards,</p>
                <p>{{ $email_template->name }} company</p>
                <p>Address: {{ $email_template->address }}</p>
                <p>Email: {{ $email_template->email }}</p>
                <p>Phone: {{ $email_template->phone }}</p>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and jQuery (for Bootstrap functionalities) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
