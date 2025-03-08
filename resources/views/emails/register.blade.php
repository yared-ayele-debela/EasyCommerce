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
    <tr><td>Welcome to our website. Your account has been successfully created with blow information:</td></tr>
    <tr><td>&nbsp;<br><br></td></tr>
    <tr><td>Name :{{ $name }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Mobile :{{ $mobile }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Email :{{ $email }}</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Password : ******(as chosen by you)</td></tr>
    <tr><td>&nbsp;<br></td></tr>
    Best regards,<br>
    {{ $email_template->name }} company<br>
    Address : {{ $email_template->address }} <br>
    Email :{{ $email_template->email }} <br>
    Phone :{{ $email_template->phone }} <br>
</body>
</html>
