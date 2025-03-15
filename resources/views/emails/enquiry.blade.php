<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <tr><td>Dear Admin</td></tr>
    <tr><td>&nbsp;</td></tr><br>
    <tr><td>User Enquiry from <strong>{{ $email_template->name }}</strong> </td></tr><br>
    <tr></tr>
    <tr><td>Name: {{ $name }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Email: {{ $email }}</td></tr>
    <tr><td>&nbsp;<br>Mobile Number : {{ $phone }}</td></tr>
    <br>
    <tr><td>Message: {{ $comment }}</td></tr><br>
    <tr><td>{{ $email_template->name }}</td></tr>
</body>
</html>
