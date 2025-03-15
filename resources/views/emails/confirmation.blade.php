<!DOCTYPE html>
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
    </tr><br>
    <tr><td>Dear {{ $name }}</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Please click on below link to activate your  Account :</td></tr>
    <tr></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td><a href="{{ url('user/confirm/'.$code) }}">Confirm Account</a></td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <br>
    Best regards,<br>
    {{ $email_template->name }} company<br>
    Address : {{ $email_template->address }} <br>
    Email :{{ $email_template->email }} <br>
    Phone :{{ $email_template->phone }} <br>
</body>
</html>
